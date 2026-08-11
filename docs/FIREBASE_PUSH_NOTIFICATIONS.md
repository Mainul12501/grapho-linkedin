# Firebase Push Notifications - Complete Documentation

## Table of Contents
1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Setup & Configuration](#setup--configuration)
4. [Mobile App Integration](#mobile-app-integration)
5. [Backend Usage](#backend-usage)
6. [API Endpoints](#api-endpoints)
7. [Notification Types](#notification-types)
8. [Testing](#testing)
9. [Troubleshooting](#troubleshooting)
10. [Best Practices](#best-practices)

---

## Overview

This application uses **Firebase Cloud Messaging (FCM)** to send real-time push notifications to mobile devices. The system is designed to work seamlessly with both Android and iOS apps.

### Key Features
- ✅ Real-time push notifications to mobile devices
- ✅ Support for both Android and iOS
- ✅ Multiple notification types (profile views, messages, job applications, etc.)
- ✅ Data-only messages for background sync
- ✅ Batch notifications to multiple users
- ✅ Token validation and management
- ✅ Comprehensive logging for debugging

---

## Architecture

### Components

```
┌─────────────────────────────────────────────────────────┐
│                    Laravel Backend                       │
│                                                          │
│  ┌──────────────────────────────────────────────────┐  │
│  │  FirebaseNotificationService.php                  │  │
│  │  - OAuth2 authentication                          │  │
│  │  - FCM HTTP v1 API integration                    │  │
│  │  - Token management & caching                     │  │
│  └──────────────────────────────────────────────────┘  │
│                         ↑                                │
│  ┌──────────────────────────────────────────────────┐  │
│  │  FirebaseHelper.php                               │  │
│  │  - Convenience methods                            │  │
│  │  - Pre-built notification types                   │  │
│  └──────────────────────────────────────────────────┘  │
│                         ↑                                │
│  ┌──────────────────────────────────────────────────┐  │
│  │  Controllers (EmployerViewController, etc.)       │  │
│  │  - Business logic                                 │  │
│  │  - Trigger notifications                          │  │
│  └──────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
                           │
                           ↓
                ┌─────────────────────┐
                │  Firebase Cloud     │
                │  Messaging (FCM)    │
                └─────────────────────┘
                           │
                           ↓
                 ┌──────────────────┐
                 │  Mobile Devices  │
                 │  (Android/iOS)   │
                 └──────────────────┘
```

### File Structure

```
app/
├── Services/
│   └── FirebaseNotificationService.php    # Core FCM service
├── Helpers/
│   └── FirebaseHelper.php                 # Helper functions
└── Http/Controllers/
    └── Auth/CustomLoginController.php     # FCM token registration

storage/app/
└── firebase/
    └── likewise-serviceAuthToken.json     # Firebase credentials

docs/
└── FIREBASE_PUSH_NOTIFICATIONS.md        # This documentation
```

---

## Setup & Configuration

### 1. Firebase Project Setup

The Firebase project is already configured:
- **Project ID**: `likewise-abdaf`
- **Credentials Location**: `storage/app/firebase/likewise-serviceAuthToken.json`

### 2. Server Configuration

No additional PHP packages required! The implementation uses:
- **Guzzle HTTP Client** (already included with Laravel)
- **Native PHP OpenSSL** for JWT signing

### 3. Database Configuration

The `users` table already includes the necessary FCM token fields:
- `fcm_token` (string, nullable) - Stores the device's FCM registration token
- `device_token` (string, nullable) - Alternative token field

---

## Mobile App Integration

### For Android (Flutter/React Native/Native Android)

#### 1. Add Firebase to Your Android App

1. Download `google-services.json` from Firebase Console
2. Place it in your Android app's `app/` directory
3. Add Firebase dependencies to your `build.gradle`

#### 2. Get FCM Token

**Flutter Example:**
```dart
import 'package:firebase_messaging/firebase_messaging.dart';

class FCMService {
  final FirebaseMessaging _fcm = FirebaseMessaging.instance;

  Future<String?> getFCMToken() async {
    // Request permission (iOS)
    await _fcm.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );

    // Get token
    String? token = await _fcm.getToken();
    print('FCM Token: $token');
    return token;
  }

  // Send token to backend
  Future<void> registerToken(String token, String bearerToken) async {
    final response = await http.post(
      Uri.parse('http://your-api.com/api/update-fcm-token'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $bearerToken',
        'Accept': 'application/json',
      },
      body: json.encode({'fcm_token': token}),
    );

    if (response.statusCode == 200) {
      print('FCM token registered successfully');
    }
  }

  // Listen for token refresh
  void listenForTokenRefresh(String bearerToken) {
    _fcm.onTokenRefresh.listen((newToken) {
      registerToken(newToken, bearerToken);
    });
  }
}
```

**React Native Example:**
```javascript
import messaging from '@react-native-firebase/messaging';
import axios from 'axios';

async function getFCMToken() {
  // Request permission
  const authStatus = await messaging().requestPermission();
  const enabled =
    authStatus === messaging.AuthorizationStatus.AUTHORIZED ||
    authStatus === messaging.AuthorizationStatus.PROVISIONAL;

  if (enabled) {
    // Get token
    const token = await messaging().getToken();
    console.log('FCM Token:', token);
    return token;
  }
}

async function registerToken(token, bearerToken) {
  try {
    const response = await axios.post(
      'http://your-api.com/api/update-fcm-token',
      { fcm_token: token },
      {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${bearerToken}`,
          'Accept': 'application/json',
        },
      }
    );
    console.log('Token registered:', response.data);
  } catch (error) {
    console.error('Error registering token:', error);
  }
}

// Listen for token refresh
messaging().onTokenRefresh(async (newToken) => {
  await registerToken(newToken, bearerToken);
});
```

#### 3. Handle Notifications

**Flutter Example:**
```dart
class FCMService {
  void setupNotificationHandlers() {
    // Handle foreground notifications
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      print('Foreground message received');
      print('Title: ${message.notification?.title}');
      print('Body: ${message.notification?.body}');
      print('Data: ${message.data}');

      // Show local notification or update UI
      _showLocalNotification(message);
    });

    // Handle notification tap (app opened from background)
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      print('Notification tapped');
      _handleNotificationTap(message.data);
    });

    // Handle notification tap (app opened from terminated state)
    FirebaseMessaging.instance.getInitialMessage().then((RemoteMessage? message) {
      if (message != null) {
        print('App opened from notification');
        _handleNotificationTap(message.data);
      }
    });
  }

  void _handleNotificationTap(Map<String, dynamic> data) {
    final notificationType = data['notification_type'];

    switch (notificationType) {
      case 'profile_view':
        // Navigate to profile view screen
        navigatorKey.currentState?.pushNamed(
          '/profile-viewers',
          arguments: {'viewer_id': data['viewer_id']},
        );
        break;

      case 'new_message':
        // Navigate to chat screen
        navigatorKey.currentState?.pushNamed(
          '/chat',
          arguments: {'sender_id': data['sender_id']},
        );
        break;

      case 'job_application':
        // Navigate to job applications screen
        navigatorKey.currentState?.pushNamed(
          '/job-applications',
          arguments: {'job_id': data['job_id']},
        );
        break;

      default:
        // Navigate to notifications screen
        navigatorKey.currentState?.pushNamed('/notifications');
    }
  }

  void _showLocalNotification(RemoteMessage message) {
    // Use flutter_local_notifications package
    // to show notification in foreground
  }
}
```

### For iOS

1. Add Firebase to your iOS app using Firebase Console
2. Download `GoogleService-Info.plist`
3. Enable Push Notifications in Xcode capabilities
4. Configure APNs certificates in Firebase Console
5. Follow the same token registration process as Android

---

## Backend Usage

### Basic Usage Examples

#### 1. Send Notification to a Single User

```php
use App\Helpers\FirebaseHelper;

// Send to user by ID
FirebaseHelper::sendToUser(
    userId: 123,
    title: 'Hello!',
    body: 'You have a new notification',
    data: ['custom_key' => 'custom_value']
);
```

#### 2. Send Notification to Multiple Users

```php
use App\Helpers\FirebaseHelper;

$userIds = [1, 2, 3, 4, 5];

FirebaseHelper::sendToUsers(
    userIds: $userIds,
    title: 'Announcement',
    body: 'System maintenance scheduled for tonight',
    data: ['announcement_id' => '123']
);
```

#### 3. Send to FCM Token Directly

```php
use App\Helpers\FirebaseHelper;

FirebaseHelper::sendToToken(
    fcmToken: 'device_fcm_token_here',
    title: 'Test Notification',
    body: 'This is a test'
);
```

#### 4. Profile View Notification (Already Integrated)

```php
use App\Helpers\FirebaseHelper;

// When someone views a profile
FirebaseHelper::sendProfileViewNotification(
    viewedUserId: $employeeId,
    viewerName: 'John Doe',
    viewerId: $employerId
);

// This sends:
// Title: "Profile View"
// Body: "John Doe viewed your profile"
// Data: {
//   "notification_type": "profile_view",
//   "viewer_id": "123",
//   "viewer_name": "John Doe",
//   "viewed_at": "2025-12-17T10:30:00Z"
// }
```

#### 5. Job Application Notification

```php
use App\Helpers\FirebaseHelper;

FirebaseHelper::sendJobApplicationNotification(
    employerId: $job->user_id,
    applicantName: 'Jane Smith',
    applicantId: 456,
    jobTitle: 'Senior Developer',
    jobId: 789
);
```

#### 6. Message Notification

```php
use App\Helpers\FirebaseHelper;

FirebaseHelper::sendMessageNotification(
    recipientId: $recipientId,
    senderName: 'John Doe',
    senderId: $senderId,
    messagePreview: 'Hey, how are you?'
);
```

#### 7. Custom Notification

```php
use App\Helpers\FirebaseHelper;

FirebaseHelper::sendCustomNotification(
    userIds: 123, // or array of IDs
    title: 'New Feature!',
    body: 'Check out our new feature',
    notificationType: 'feature_announcement',
    customData: [
        'feature_id' => '123',
        'feature_name' => 'Dark Mode',
        'deep_link' => '/settings/theme'
    ]
);
```

#### 8. Data-Only Message (Silent Push)

```php
use App\Helpers\FirebaseHelper;

// Useful for background data sync
FirebaseHelper::sendDataToUser(
    userId: 123,
    data: [
        'sync_type' => 'profile_update',
        'last_updated' => now()->toIso8601String()
    ]
);
```

### Advanced Usage

#### Using the Service Directly

```php
use App\Services\FirebaseNotificationService;

$firebaseService = new FirebaseNotificationService();

// Send with custom Android and iOS options
$firebaseService->sendToDevice(
    fcmToken: 'device_token_here',
    title: 'Custom Notification',
    body: 'With custom settings',
    data: ['key' => 'value'],
    options: [
        'image' => 'https://example.com/image.jpg',
        'android' => [
            'priority' => 'high',
            'notification' => [
                'sound' => 'custom_sound',
                'color' => '#FF0000',
                'icon' => 'notification_icon',
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
            ]
        ],
        'apns' => [
            'payload' => [
                'aps' => [
                    'sound' => 'custom_sound.wav',
                    'badge' => 5,
                    'category' => 'MESSAGE_CATEGORY'
                ]
            ]
        ]
    ]
);
```

---

## API Endpoints

### 1. Register/Update FCM Token

**Endpoint**: `POST /api/update-fcm-token`

**Authentication**: Required (Bearer Token)

**Request Headers**:
```
Content-Type: application/json
Authorization: Bearer YOUR_SANCTUM_TOKEN
Accept: application/json
```

**Request Body**:
```json
{
  "fcm_token": "device_fcm_registration_token_here"
}
```

**Response** (200 OK):
```json
{
  "status": "success",
  "msg": "FCM Token updated successfully"
}
```

**Example cURL**:
```bash
curl -X POST http://127.0.0.1:8000/api/update-fcm-token \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{"fcm_token":"your_fcm_token_here"}'
```

**When to Call This**:
- When user logs in (send their FCM token to server)
- When FCM token is refreshed (Firebase auto-refreshes tokens periodically)
- When user enables notifications in app settings

---

## Notification Types

### Supported Notification Types

The mobile app should handle these `notification_type` values:

| Type | Description | Data Fields |
|------|-------------|-------------|
| `profile_view` | Someone viewed user's profile | `viewer_id`, `viewer_name`, `viewed_at` |
| `job_application` | New job application received | `applicant_id`, `applicant_name`, `job_id`, `job_title`, `applied_at` |
| `new_message` | New chat message received | `sender_id`, `sender_name`, `message_preview`, `sent_at` |
| `connection_request` | New connection/follow request | `requester_id`, `requester_name`, `requested_at` |
| Custom types | Application-specific notifications | Custom data fields |

### Notification Payload Structure

**Standard Notification**:
```json
{
  "notification": {
    "title": "Profile View",
    "body": "John Doe viewed your profile"
  },
  "data": {
    "notification_type": "profile_view",
    "viewer_id": "123",
    "viewer_name": "John Doe",
    "viewed_at": "2025-12-17T10:30:00Z"
  }
}
```

**Data-Only Message**:
```json
{
  "data": {
    "sync_type": "profile_update",
    "last_updated": "2025-12-17T10:30:00Z"
  }
}
```

---

## Testing

### 1. Test Notification from Backend

Create a test route (for development only):

```php
// routes/web.php or routes/api.php
Route::get('/test-notification/{userId}', function ($userId) {
    return FirebaseHelper::sendToUser(
        userId: $userId,
        title: 'Test Notification',
        body: 'This is a test notification from the server',
        data: [
            'notification_type' => 'test',
            'timestamp' => now()->toIso8601String()
        ]
    );
});
```

### 2. Test Token Validation

```php
use App\Helpers\FirebaseHelper;

$isValid = FirebaseHelper::validateToken('your_fcm_token_here');

if ($isValid) {
    echo "Token is valid!";
} else {
    echo "Token is invalid or expired";
}
```

### 3. Check Logs

All Firebase operations are logged. Check your Laravel logs:

```bash
tail -f storage/logs/laravel.log | grep Firebase
```

You'll see logs like:
```
[2025-12-17 10:30:00] local.INFO: Firebase: Notification sent successfully {"token":"abc123...","title":"Profile View"}
[2025-12-17 10:30:05] local.ERROR: Firebase: Failed to send notification {"token":"xyz789...","error":"Invalid token"}
```

### 4. Test with Postman

1. **Get your Sanctum token** by logging in
2. **Register FCM token**:
   ```
   POST http://127.0.0.1:8000/api/update-fcm-token
   Headers:
     Authorization: Bearer YOUR_TOKEN
     Content-Type: application/json
     Accept: application/json
   Body:
     {"fcm_token": "YOUR_DEVICE_FCM_TOKEN"}
   ```
3. **Trigger a notification** (e.g., view a profile):
   ```
   GET http://127.0.0.1:8000/api/employee-profile/6
   Headers:
     Authorization: Bearer YOUR_TOKEN
     Accept: application/json
   ```

---

## Troubleshooting

### Common Issues

#### 1. "Failed to get Firebase access token"

**Cause**: Invalid credentials or network issue

**Solution**:
- Verify `storage/app/firebase/likewise-serviceAuthToken.json` exists
- Check file permissions (should be readable by web server)
- Verify JSON is valid
- Check server can reach `https://oauth2.googleapis.com/token`

#### 2. "Invalid token" or "Token not registered"

**Cause**: FCM token is invalid, expired, or not registered

**Solution**:
- Ensure mobile app calls `/api/update-fcm-token` after login
- FCM tokens can expire - implement token refresh listener in mobile app
- Validate token using `FirebaseHelper::validateToken()`

#### 3. Notifications not received on mobile

**Checklist**:
- ✅ Is FCM token registered on backend? (Check `users.fcm_token` in database)
- ✅ Is mobile app in foreground? (Foreground handling requires local notification)
- ✅ Are notifications enabled in app settings?
- ✅ For iOS: Are APNs certificates configured in Firebase?
- ✅ Check Laravel logs for errors
- ✅ Check Firebase Console → Cloud Messaging for delivery reports

#### 4. "User has no FCM token" in logs

**Cause**: User hasn't registered their FCM token yet

**Solution**:
- Mobile app must call `/api/update-fcm-token` endpoint after login
- Implement automatic token registration in your mobile app's initialization

#### 5. Notifications work in dev but not production

**Checklist**:
- ✅ Verify production Firebase credentials are correct
- ✅ Check server can reach Firebase APIs (no firewall blocking)
- ✅ Ensure production mobile app uses production Firebase config
- ✅ Verify SSL certificates are valid

---

## Best Practices

### 1. Token Management

✅ **DO**:
- Store FCM tokens securely in database
- Update token whenever it's refreshed (Firebase auto-refreshes)
- Clear token on user logout
- Validate tokens before sending bulk notifications

❌ **DON'T**:
- Store tokens in plain text config files
- Hardcode tokens in mobile app
- Send notifications to expired tokens

### 2. Notification Content

✅ **DO**:
- Keep titles concise (40 characters or less)
- Keep body text clear and actionable (100 characters or less)
- Include relevant data for deep linking
- Use appropriate notification type

❌ **DON'T**:
- Send sensitive information in notification body
- Use ALL CAPS or excessive emojis
- Send too many notifications (causes user fatigue)

### 3. Performance

✅ **DO**:
- Use batch sending for multiple users
- Implement retry logic with exponential backoff
- Cache Firebase access tokens (already implemented)
- Queue notifications for large batches

❌ **DON'T**:
- Send notifications in a loop (use `sendToMultipleDevices()`)
- Block user requests waiting for notification delivery
- Ignore failed delivery logs

### 4. User Experience

✅ **DO**:
- Provide notification preferences in app settings
- Respect user's notification settings
- Group similar notifications
- Implement deep linking to relevant app screens

❌ **DON'T**:
- Send notifications at inappropriate times
- Spam users with duplicate notifications
- Send generic "Test" notifications to production users

### 5. Security

✅ **DO**:
- Protect Firebase credentials file (already in storage/app)
- Use HTTPS for all API calls
- Validate user permissions before sending notifications
- Log notification activities for audit trail

❌ **DON'T**:
- Commit Firebase credentials to version control
- Expose credentials in API responses
- Allow unauthenticated notification sending

---

## Example Integration Flow

### Complete Flow: User Profile View Notification

```
1. Employer views Employee Profile
   ↓
2. Backend (EmployerViewController@employeeProfile)
   - Creates WebNotification record (for web UI)
   - Calls FirebaseHelper::sendProfileViewNotification()
   ↓
3. FirebaseHelper
   - Looks up employee's FCM token from database
   - Prepares notification payload
   - Calls FirebaseNotificationService
   ↓
4. FirebaseNotificationService
   - Gets OAuth2 access token (cached)
   - Sends to FCM HTTP v1 API
   ↓
5. Firebase Cloud Messaging
   - Routes to appropriate platform (Android/iOS)
   - Delivers to device
   ↓
6. Mobile App
   - Receives notification
   - Shows notification in system tray
   - User taps notification
   - App navigates to profile viewers screen
```

---

## Quick Reference

### Helper Functions

```php
// Send to single user
FirebaseHelper::sendToUser($userId, $title, $body, $data, $options)

// Send to multiple users
FirebaseHelper::sendToUsers($userIds, $title, $body, $data, $options)

// Send to FCM token
FirebaseHelper::sendToToken($fcmToken, $title, $body, $data, $options)

// Pre-built notification types
FirebaseHelper::sendProfileViewNotification($viewedUserId, $viewerName, $viewerId)
FirebaseHelper::sendJobApplicationNotification($employerId, $applicantName, $applicantId, $jobTitle, $jobId)
FirebaseHelper::sendMessageNotification($recipientId, $senderName, $senderId, $messagePreview)
FirebaseHelper::sendConnectionRequestNotification($recipientId, $requesterName, $requesterId)

// Custom notification
FirebaseHelper::sendCustomNotification($userIds, $title, $body, $notificationType, $customData, $options)

// Data-only message
FirebaseHelper::sendDataToUser($userId, $data)

// Validate token
FirebaseHelper::validateToken($fcmToken)
```

### Service Methods

```php
$service = new FirebaseNotificationService();

// Send to device
$service->sendToDevice($fcmToken, $title, $body, $data, $options)

// Send to multiple devices
$service->sendToMultipleDevices($fcmTokens, $title, $body, $data, $options)

// Send data message
$service->sendDataMessage($fcmToken, $data)

// Validate token
$service->validateToken($fcmToken)
```

---

## Support

For issues or questions:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check Firebase Console for delivery metrics
3. Review this documentation
4. Check FCM documentation: https://firebase.google.com/docs/cloud-messaging

---

## Changelog

- **2025-12-17**: Initial implementation
  - Created FirebaseNotificationService
  - Created FirebaseHelper with convenience methods
  - Integrated with profile view notifications
  - Added comprehensive documentation
