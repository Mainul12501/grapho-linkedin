# Zego Audio/Video Call - Firebase Push Notifications

## Overview

Firebase push notifications have been integrated with the Zego audio/video calling system to notify users when they receive incoming calls, when calls are accepted, rejected, or ended.

## Features

- Push notifications for incoming audio calls
- Push notifications for incoming video calls
- Call accepted notifications
- Call rejected notifications
- Call ended notifications with duration
- High-priority notifications for incoming calls
- Support for both Android and iOS platforms

---

## Implementation Summary

### Files Modified

1. **app/Helpers/FirebaseHelper.php**
   - Added `sendIncomingCallNotification()` - Sends notification when a call is initiated
   - Added `sendCallAcceptedNotification()` - Sends notification when a call is accepted
   - Added `sendCallRejectedNotification()` - Sends notification when a call is rejected
   - Added `sendCallEndedNotification()` - Sends notification when a call ends

2. **app/Http/Controllers/Frontend/ZegoCloud/ZegoCloudController.php**
   - Updated `initiateCall()` to send Firebase notification to receiver
   - Updated `acceptCall()` to send Firebase notification to caller
   - Updated `rejectCall()` to send Firebase notification to caller
   - Updated `endCall()` to send Firebase notification to the other party

3. **app/Http/Controllers/Api/Mobile/ZegoCloudMobileController.php**
   - Replaced old `PushNotificationService` with new `FirebaseHelper` methods
   - Updated all call-related methods to use Firebase notifications

---

## How It Works

### 1. Incoming Call Flow

```
User A initiates call → Call created in database → CallInitiated event broadcast
                                                 ↓
                                    Firebase notification sent to User B
                                                 ↓
                              User B's phone receives push notification
                                                 ↓
                              User B can accept or reject the call
```

### 2. Call Accepted Flow

```
User B accepts call → Call status updated → CallAccepted event broadcast
                                          ↓
                          Firebase notification sent to User A
                                          ↓
                        User A's phone receives notification
                                          ↓
                              Both users join the call
```

### 3. Call Rejected Flow

```
User B rejects call → Call status updated → CallRejected event broadcast
                                          ↓
                          Firebase notification sent to User A
                                          ↓
                        User A's phone receives notification
                                          ↓
                          User A is notified call was declined
```

### 4. Call Ended Flow

```
User A/B ends call → Call status updated → CallEnded event broadcast
                                         ↓
                          Firebase notification sent to other user
                                         ↓
                        Other user receives notification with duration
```

---

## Notification Payloads

### Incoming Call Notification

**Title:** "Incoming Audio Call" or "Incoming Video Call"

**Body:** "{Caller Name} is calling you..."

**Data Payload:**
```json
{
  "notification_type": "incoming_call",
  "call_id": "123",
  "room_id": "room_abc123_1234567890",
  "call_type": "audio|video",
  "caller_id": "456",
  "caller_name": "John Doe",
  "caller_photo": "https://example.com/photo.jpg",
  "action": "call_initiated",
  "timestamp": "2025-12-17T10:30:00Z"
}
```

**Priority:** HIGH (for immediate delivery)

**Platform-specific:**
- **Android:** Uses `incoming_calls` notification channel with high priority
- **iOS:** Uses `INCOMING_CALL` category with alert, badge, and sound

---

### Call Accepted Notification

**Title:** "Call Accepted"

**Body:** "{Receiver Name} accepted your call"

**Data Payload:**
```json
{
  "notification_type": "call_accepted",
  "call_id": "123",
  "room_id": "room_abc123_1234567890",
  "receiver_id": "789",
  "receiver_name": "Jane Smith",
  "action": "call_accepted",
  "timestamp": "2025-12-17T10:30:15Z"
}
```

---

### Call Rejected Notification

**Title:** "Call Declined"

**Body:** "{Receiver Name} declined your call"

**Data Payload:**
```json
{
  "notification_type": "call_rejected",
  "call_id": "123",
  "receiver_id": "789",
  "receiver_name": "Jane Smith",
  "action": "call_rejected",
  "timestamp": "2025-12-17T10:30:20Z"
}
```

---

### Call Ended Notification

**Title:** "Call Ended"

**Body:** "Call with {Other User Name} ended. Duration: 00:05:30"

**Data Payload:**
```json
{
  "notification_type": "call_ended",
  "call_id": "123",
  "other_user_id": "456",
  "other_user_name": "John Doe",
  "duration": "330",
  "action": "call_ended",
  "timestamp": "2025-12-17T10:35:30Z"
}
```

---

## Usage Examples

### Backend (Laravel)

The Firebase notifications are automatically sent when call events occur. No additional code is needed in your application logic.

**Example: Initiating a call**

```php
use App\Http\Controllers\Frontend\ZegoCloud\ZegoCloudController;

// When you call the initiateCall method, Firebase notification is automatically sent
POST /api/zego/initiate-call
{
    "receiver_id": 123,
    "call_type": "video"
}

// The controller will:
// 1. Create call record in database
// 2. Broadcast CallInitiated event
// 3. Send Firebase push notification to receiver (if they have fcm_token)
```

### Mobile App (Flutter/React Native)

**Handle incoming call notification:**

```dart
// Flutter example
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  if (message.data['notification_type'] == 'incoming_call') {
    // Show incoming call screen
    final callId = message.data['call_id'];
    final roomId = message.data['room_id'];
    final callType = message.data['call_type'];
    final callerName = message.data['caller_name'];
    final callerPhoto = message.data['caller_photo'];

    // Navigate to incoming call screen or show full-screen notification
    showIncomingCallScreen(
      callId: callId,
      roomId: roomId,
      callType: callType,
      callerName: callerName,
      callerPhoto: callerPhoto,
    );
  }
});
```

**Handle call accepted notification:**

```dart
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  if (message.data['notification_type'] == 'call_accepted') {
    // Navigate to call screen
    final roomId = message.data['room_id'];
    final callId = message.data['call_id'];

    // Join the call room
    joinCallRoom(roomId: roomId, callId: callId);
  }
});
```

**Handle call rejected notification:**

```dart
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  if (message.data['notification_type'] == 'call_rejected') {
    // Show toast or dismiss calling screen
    final receiverName = message.data['receiver_name'];

    showToast('$receiverName declined your call');
    dismissCallingScreen();
  }
});
```

**Handle call ended notification:**

```dart
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  if (message.data['notification_type'] == 'call_ended') {
    // End the call and show duration
    final duration = int.parse(message.data['duration']);
    final otherUserName = message.data['other_user_name'];

    endCall();
    showCallEndedDialog(
      message: 'Call with $otherUserName ended',
      duration: Duration(seconds: duration),
    );
  }
});
```

---

## Mobile App Setup

### Prerequisites

1. **FCM Token Registration**

   Users must register their FCM token using the `/api/update-fcm-token` endpoint:

   ```bash
   POST /api/update-fcm-token
   Headers:
     Authorization: Bearer {user_token}
     Content-Type: application/json
   Body:
     {
       "fcm_token": "device_fcm_token_here"
     }
   ```

2. **Notification Permissions**

   Ensure the app has requested notification permissions from the user.

3. **Firebase Configuration**

   Add Firebase configuration files to your mobile app:
   - Android: `google-services.json`
   - iOS: `GoogleService-Info.plist`

### Notification Channels (Android)

Create a high-priority notification channel for incoming calls:

```kotlin
// Android (Kotlin)
val channelId = "incoming_calls"
val channelName = "Incoming Calls"
val channelDescription = "Notifications for incoming audio and video calls"

val channel = NotificationChannel(
    channelId,
    channelName,
    NotificationManager.IMPORTANCE_HIGH
).apply {
    description = channelDescription
    enableVibration(true)
    enableLights(true)
    setSound(
        Uri.parse("android.resource://" + context.packageName + "/raw/ringtone"),
        AudioAttributes.Builder()
            .setUsage(AudioAttributes.USAGE_NOTIFICATION_RINGTONE)
            .setContentType(AudioAttributes.CONTENT_TYPE_SONIFICATION)
            .build()
    )
}

notificationManager.createNotificationChannel(channel)
```

### Notification Categories (iOS)

Register notification category for incoming calls:

```swift
// iOS (Swift)
let acceptAction = UNNotificationAction(
    identifier: "ACCEPT_CALL",
    title: "Accept",
    options: [.foreground]
)

let declineAction = UNNotificationAction(
    identifier: "DECLINE_CALL",
    title: "Decline",
    options: [.destructive]
)

let callCategory = UNNotificationCategory(
    identifier: "INCOMING_CALL",
    actions: [acceptAction, declineAction],
    intentIdentifiers: [],
    options: []
)

UNUserNotificationCenter.current().setNotificationCategories([callCategory])
```

---

## Testing

### Test Incoming Call Notification

1. **Login with two users** (User A and User B)
2. **Register FCM tokens** for both users
3. **User A initiates a call** to User B:
   ```bash
   POST /api/zego/initiate-call
   {
     "receiver_id": {USER_B_ID},
     "call_type": "video"
   }
   ```
4. **User B should receive** a push notification on their device
5. **Verify notification content:**
   - Title: "Incoming Video Call"
   - Body: "{User A Name} is calling you..."
   - Data includes call_id, room_id, caller info

### Test Call Accepted Notification

1. **User B accepts the call** via the API or mobile app
2. **User A should receive** a push notification
3. **Verify notification content:**
   - Title: "Call Accepted"
   - Body: "{User B Name} accepted your call"

### Test Call Rejected Notification

1. **User B rejects the call** via the API or mobile app
2. **User A should receive** a push notification
3. **Verify notification content:**
   - Title: "Call Declined"
   - Body: "{User B Name} declined your call"

### Test Call Ended Notification

1. **Either user ends an active call**
2. **The other user should receive** a push notification
3. **Verify notification content:**
   - Title: "Call Ended"
   - Body includes duration if call was active

---

## Troubleshooting

### Notifications not received

**Check:**
1. User has registered FCM token using `/api/update-fcm-token`
2. User's `fcm_token` field in database is not null
3. Firebase credentials are correctly configured in `storage/app/firebase/`
4. Mobile app has notification permissions enabled
5. Check Laravel logs for Firebase errors: `tail -f storage/logs/laravel.log | grep Firebase`

### Notifications delayed

**Possible causes:**
- FCM server delays (normal for non-critical priority notifications)
- Device in battery saver mode
- App in background with restricted background data

**Solution:**
- Incoming call notifications use HIGH priority to ensure immediate delivery
- Test with device plugged in and app in foreground first

### Wrong notification content

**Check:**
- Verify the data payload structure matches expected format
- Check if caller name/photo is properly loaded from database
- Review mobile app notification handling code

---

## API Endpoints

### Web (Browser)

- **POST** `/zego/initiate-call` - Initiate a call
- **POST** `/zego/accept-call/{call}` - Accept a call
- **POST** `/zego/reject-call/{call}` - Reject a call
- **POST** `/zego/end-call/{call}` - End a call

### Mobile (API)

- **POST** `/api/mobile/zego/initiate-call` - Initiate a call
- **POST** `/api/mobile/zego/accept-call/{callId}` - Accept a call
- **POST** `/api/mobile/zego/reject-call/{callId}` - Reject a call
- **POST** `/api/mobile/zego/end-call/{callId}` - End a call
- **POST** `/api/update-fcm-token` - Register FCM token

---

## Best Practices

### For Backend Developers

1. Always check if user has `fcm_token` before sending notifications
2. Log all notification attempts for debugging
3. Use appropriate notification priority (HIGH for calls)
4. Include all necessary data in the payload for mobile app handling

### For Mobile Developers

1. Register FCM token immediately after user login
2. Update FCM token when it refreshes (Firebase auto-refreshes tokens)
3. Handle all notification types: incoming_call, call_accepted, call_rejected, call_ended
4. Show appropriate UI based on notification type
5. Use high-priority notification channels for incoming calls
6. Test notifications in foreground, background, and terminated states
7. Implement proper navigation from notification tap

---

## Security Considerations

1. **Authentication Required**: All call endpoints require authentication
2. **Authorization Checks**: Users can only accept/reject/end calls they're part of
3. **Token Security**: FCM tokens are stored securely in the database
4. **Firebase Credentials**: Service account credentials are stored in `storage/app/firebase/` (not in version control)

---

## Future Enhancements

- Support for group calls
- Call history notifications
- Missed call notifications
- Do Not Disturb mode
- Notification sounds customization
- Call waiting notifications
- Conference call notifications

---

## Related Documentation

- [Firebase Push Notifications Guide](FIREBASE_PUSH_NOTIFICATIONS.md)
- [Mobile Developer Guide](MOBILE_DEVELOPER_GUIDE.md)
- [Zego Integration Guide](ZEGOCLOUD_INTEGRATION_GUIDE.md)

---

## Support

For issues related to:
- **Firebase notifications**: Check Firebase Console and Laravel logs
- **Zego calls**: Check Zego Console and call records in database
- **Mobile app integration**: Refer to Mobile Developer Guide

---

**Last Updated:** 2025-12-17
**Version:** 1.0.0
