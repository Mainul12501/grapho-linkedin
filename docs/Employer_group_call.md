# Employer Group Call - Mobile App Integration Guide

This document provides a complete guide for integrating the **Employer Group Call** system into the mobile app (Flutter/Dart). It covers the backend API endpoints, ZEGOCLOUD SDK setup, and the full call lifecycle.

---

## Table of Contents

1. [Overview](#1-overview)
2. [Architecture](#2-architecture)
3. [Prerequisites](#3-prerequisites)
4. [ZEGOCLOUD Flutter SDK Setup](#4-zegocloud-flutter-sdk-setup)
5. [Backend API Reference](#5-backend-api-reference)
6. [Call Lifecycle & Flow](#6-call-lifecycle--flow)
7. [Real-Time Events (Pusher)](#7-real-time-events-pusher)
8. [Firebase Push Notifications](#8-firebase-push-notifications)
9. [Flutter Implementation Guide](#9-flutter-implementation-guide)
10. [Error Handling](#10-error-handling)
11. [Platform-Specific Configuration](#11-platform-specific-configuration)

---

## 1. Overview

The Group Call system allows **employers** and **sub-employers** to initiate group video/audio calls with their team members. The system uses:

- **Backend API** (Laravel) - Manages call state, participants, and authorization
- **ZEGOCLOUD SDK** - Handles real-time audio/video communication
- **Pusher** - Delivers real-time call events (participant joined/left, call ended)
- **Firebase FCM** - Sends push notifications for incoming call invitations

### Key Rules

- Only **employers** and **sub-employers** can initiate calls
- Employers can call their sub-employers
- Sub-employers can call their parent employer and sibling sub-employers
- Maximum **10 participants** per call
- Supported call types: `audio` and `video`

---

## 2. Architecture

```
Mobile App (Flutter)
    |
    |-- HTTP REST API --> Laravel Backend (call management)
    |-- Pusher WebSocket --> Real-time events
    |-- Firebase FCM --> Push notifications (incoming calls)
    |-- ZEGOCLOUD SDK --> Audio/Video streaming (room-based)
```

### Flow Summary

```
1. Employer taps "Call" --> POST /api/group-call/initiate
2. Backend creates GroupCall record, broadcasts event, sends FCM
3. Receiver gets push notification / Pusher event
4. Receiver accepts --> POST /api/group-call/{id}/join
5. Both users connect to ZEGOCLOUD room using room_id
6. Host can add more participants --> POST /api/group-call/{id}/add-participants
7. Participant leaves --> POST /api/group-call/{id}/leave
8. Host ends call --> POST /api/group-call/{id}/end
```

---

## 3. Prerequisites

| Requirement | Details |
|---|---|
| ZEGOCLOUD Account | Register at [zegocloud.com](https://www.zegocloud.com) |
| App ID | `21874046` (from ZEGOCLOUD console) |
| Server Secret | Obtain from backend team (stored in `.env`) |
| Flutter SDK | >= 2.0 |
| Android | minSdkVersion 21, compileSdkVersion 33 |
| iOS | >= 12.0 |
| Pusher | For real-time call events |
| Firebase | For push notifications |

---

## 4. ZEGOCLOUD Flutter SDK Setup

### 4.1 Install Dependencies

```bash
flutter pub add zego_express_engine
flutter pub add zego_uikit_prebuilt_call
flutter pub add zego_uikit_signaling_plugin
flutter pub get
```

### 4.2 Import Packages

```dart
import 'package:zego_express_engine/zego_express_engine.dart';
import 'package:zego_uikit/zego_uikit.dart';
import 'package:zego_uikit_prebuilt_call/zego_uikit_prebuilt_call.dart';
import 'package:zego_uikit_signaling_plugin/zego_uikit_signaling_plugin.dart';
```

### 4.3 Initialize on App Start

```dart
final navigatorKey = GlobalKey<NavigatorState>();

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  ZegoUIKitPrebuiltCallInvitationService().setNavigatorKey(navigatorKey);

  await ZegoUIKit().initLog().then((value) async {
    await ZegoUIKitPrebuiltCallInvitationService().useSystemCallingUI(
      [ZegoUIKitSignalingPlugin()],
    );
    runApp(MyApp(navigatorKey: navigatorKey));
  });
}
```

### 4.4 Initialize After User Login

```dart
Future<void> onUserLogin(int userId, String userName) async {
  await ZegoUIKitPrebuiltCallInvitationService().init(
    appID: 21874046,  // Your ZEGOCLOUD App ID
    appSign: 'YOUR_APP_SIGN',  // Get from backend team
    userID: userId.toString(),
    userName: userName,
    plugins: [ZegoUIKitSignalingPlugin()],
  );
}

void onUserLogout() {
  ZegoUIKitPrebuiltCallInvitationService().uninit();
}
```

### 4.5 ZEGOCLOUD Token Generation

The web app uses `generateKitTokenForTest()` for token generation. For **production mobile apps**, generate tokens server-side. The token parameters are:

| Parameter | Value |
|---|---|
| `appID` | `21874046` |
| `serverSecret` | From backend `.env` |
| `roomID` | From API response `group_call.room_id` |
| `userID` | Current user's ID (as string) |
| `userName` | Current user's name |

```dart
// For testing (NOT production):
final kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
  appID,
  serverSecret,
  roomID,    // from API response
  userID,
  userName,
);
```

> **Important:** For production, implement server-side token generation and expose an API endpoint. Never embed `serverSecret` in the mobile app.

---

## 5. Backend API Reference

**Base URL:** `https://your-domain.com/api/group-call`

**Authentication:** All endpoints require `auth:sanctum` middleware. You must send a valid Sanctum Bearer token in the `Authorization` header:
```
Authorization: Bearer {sanctum_token}
```

> **Important:** The token is obtained from the login API. Without a valid Bearer token, all endpoints will return a `401 Unauthenticated` error.

---

### 5.1 Initiate a Group Call

Start a new group call with one receiver.

```
POST /api/group-call/initiate
```

**Request Body:**

| Field | Type | Required | Description |
|---|---|---|---|
| `receiver_id` | integer | Yes | User ID of the person to call |
| `call_type` | string | Yes | `"audio"` or `"video"` |

**Example Request:**
```json
{
  "receiver_id": 42,
  "call_type": "video"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "group_call": {
    "id": 1,
    "host_id": 10,
    "room_id": "group_room_abc123def456_1709312400",
    "name": "John Doe's Group Call",
    "call_type": "video",
    "status": "initiated",
    "max_participants": 10,
    "started_at": null,
    "ended_at": null,
    "duration": null,
    "created_at": "2026-03-01T12:00:00.000000Z",
    "updated_at": "2026-03-01T12:00:00.000000Z",
    "participants": [
      {
        "id": 1,
        "group_call_id": 1,
        "user_id": 10,
        "status": "joined",
        "invited_at": "2026-03-01T12:00:00.000000Z",
        "joined_at": "2026-03-01T12:00:00.000000Z",
        "left_at": null,
        "user": {
          "id": 10,
          "name": "John Doe",
          "email": "john@example.com"
        }
      },
      {
        "id": 2,
        "group_call_id": 1,
        "user_id": 42,
        "status": "invited",
        "invited_at": "2026-03-01T12:00:00.000000Z",
        "joined_at": null,
        "left_at": null,
        "user": {
          "id": 42,
          "name": "Jane Smith",
          "email": "jane@example.com"
        }
      }
    ]
  },
  "room_id": "group_room_abc123def456_1709312400",
  "call_type": "video",
  "group_call_id": 1
}
```

> **Note:** The API returns `room_id`, `call_type`, and `group_call_id` as separate fields for easy access. Use `room_id` to connect to the ZEGOCLOUD room.

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 403 | User is not an employer or sub_employer |
| 400 | Trying to call yourself |
| 422 | Validation error (invalid receiver_id or call_type) |

---

### 5.2 Join a Call

Accept an incoming call invitation and join the call.

```
POST /api/group-call/{groupCallId}/join
```

**URL Parameters:**

| Parameter | Type | Description |
|---|---|---|
| `groupCallId` | integer | The group call ID |

**Request Body:** None

**Success Response (200):**
```json
{
  "success": true,
  "group_call": {
    "id": 1,
    "host_id": 10,
    "room_id": "group_room_abc123def456_1709312400",
    "name": "John Doe's Group Call",
    "call_type": "video",
    "status": "active",
    "max_participants": 10,
    "started_at": "2026-03-01T12:00:05.000000Z",
    "ended_at": null,
    "duration": null,
    "participants": [ ... ]
  },
  "room_id": "group_room_abc123def456_1709312400",
  "call_type": "video",
  "group_call_id": 1
}
```

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 403 | User was not invited to this call |
| 400 | Call is full (max participants reached) or already ended |

**Important:** After a successful join, use the `room_id` from the response to connect to the ZEGOCLOUD room.

---

### 5.3 Reject a Call

Decline an incoming call invitation.

```
POST /api/group-call/{groupCallId}/reject
```

**URL Parameters:**

| Parameter | Type | Description |
|---|---|---|
| `groupCallId` | integer | The group call ID |

**Request Body:** None

**Success Response (200):**
```json
{
  "success": true
}
```

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 400 | Participant status is not "invited" (already joined/left/rejected) |

---

### 5.4 Leave a Call

Leave an ongoing call. If the host leaves, the entire call is ended for all participants.

```
POST /api/group-call/{groupCallId}/leave
```

**URL Parameters:**

| Parameter | Type | Description |
|---|---|---|
| `groupCallId` | integer | The group call ID |

**Request Body:** None

**Success Response (200):**
```json
{
  "success": true
}
```

**Side Effects:**
- If the **host** leaves, the call is **ended for all participants**
- If the **last active participant** leaves, the call is automatically ended
- Broadcasts `GroupCallParticipantLeft` event

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 400 | User is not a participant of this call |

---

### 5.5 End a Call (Host Only)

Forcefully end the call for all participants.

```
POST /api/group-call/{groupCallId}/end
```

**URL Parameters:**

| Parameter | Type | Description |
|---|---|---|
| `groupCallId` | integer | The group call ID |

**Request Body:** None

**Success Response (200):**
```json
{
  "success": true
}
```

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 403 | Only the host can end the call |

---

### 5.6 Add Participants to an Active Call

Add more users to an ongoing call (mid-call).

```
POST /api/group-call/{groupCallId}/add-participants
```

**URL Parameters:**

| Parameter | Type | Description |
|---|---|---|
| `groupCallId` | integer | The group call ID |

**Request Body:**

| Field | Type | Required | Description |
|---|---|---|---|
| `participant_ids` | array of integers | Yes | User IDs to invite |

**Example Request:**
```json
{
  "participant_ids": [15, 22, 38]
}
```

**Success Response (200):**
```json
{
  "success": true,
  "added_count": 3,
  "group_call": {
    "id": 1,
    "participants": [ ... ]
  }
}
```

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 403 | User is not the host or a participant |
| 400 | Call has already ended |
| 422 | Validation error (empty array, invalid user IDs) |

**Notes:**
- Only users from the caller's team can be added (employer's sub-employers or sub-employer's siblings)
- Users already in the call are skipped silently
- Each new participant receives a push notification and Pusher event

---

### 5.7 Get Call Details

Retrieve full details of a group call.

```
GET /api/group-call/{groupCallId}/details
```

**URL Parameters:**

| Parameter | Type | Description |
|---|---|---|
| `groupCallId` | integer | The group call ID |

**Success Response (200):**
```json
{
  "group_call": {
    "id": 1,
    "host_id": 10,
    "room_id": "group_room_abc123def456_1709312400",
    "name": "John Doe's Group Call",
    "call_type": "video",
    "status": "active",
    "max_participants": 10,
    "started_at": "2026-03-01T12:00:05.000000Z",
    "ended_at": null,
    "duration": null,
    "created_at": "2026-03-01T12:00:00.000000Z",
    "updated_at": "2026-03-01T12:00:05.000000Z",
    "host": {
      "id": 10,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "participants": [
      {
        "id": 1,
        "user_id": 10,
        "status": "joined",
        "invited_at": "2026-03-01T12:00:00.000000Z",
        "joined_at": "2026-03-01T12:00:00.000000Z",
        "left_at": null,
        "user": { "id": 10, "name": "John Doe" }
      },
      {
        "id": 2,
        "user_id": 42,
        "status": "joined",
        "invited_at": "2026-03-01T12:00:00.000000Z",
        "joined_at": "2026-03-01T12:00:05.000000Z",
        "left_at": null,
        "user": { "id": 42, "name": "Jane Smith" }
      }
    ]
  }
}
```

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 403 | User is not the host or a participant |

---

### 5.8 Get Participants

Get the current participant list, separated by status.

```
GET /api/group-call/{groupCallId}/participants
```

**Success Response (200):**
```json
{
  "participants": [
    {
      "id": 1,
      "user_id": 10,
      "status": "joined",
      "joined_at": "2026-03-01T12:00:00.000000Z",
      "user": { "id": 10, "name": "John Doe" }
    }
  ],
  "invited": [
    {
      "id": 3,
      "user_id": 55,
      "status": "invited",
      "invited_at": "2026-03-01T12:01:00.000000Z",
      "user": { "id": 55, "name": "Bob Wilson" }
    }
  ]
}
```

**Error Responses:**

| Status | Condition |
|---|---|
| 401 | Unauthenticated (missing or invalid Bearer token) |
| 403 | User is not the host or a participant |

---

### 5.9 Get Callable Users

Get the list of users the current user is allowed to call.

```
GET /api/group-call/callable-users
```

**Query Parameters:**

| Parameter | Type | Required | Description |
|---|---|---|---|
| `group_call_id` | integer | No | Exclude users already in this call |

**Success Response (200):**
```json
{
  "users": [
    {
      "id": 42,
      "name": "Jane Smith",
      "email": "jane@example.com",
      "profile_image": "path/to/image.jpg",
      "user_type": "sub_employer"
    },
    {
      "id": 55,
      "name": "Bob Wilson",
      "email": "bob@example.com",
      "profile_image": null,
      "user_type": "sub_employer"
    }
  ]
}
```

**Who can call whom:**

| Caller Role | Can Call |
|---|---|
| Employer | Their sub-employers |
| Sub-employer | Parent employer + sibling sub-employers |
| Employee | No one (returns empty) |

---

## 6. Call Lifecycle & Flow

### Call Status Transitions

```
initiated --> active --> ended
```

| Status | Meaning |
|---|---|
| `initiated` | Call created, waiting for participants to join |
| `active` | At least one invited participant has joined |
| `ended` | Call is over |

### Participant Status Transitions

```
invited --> joined --> left
invited --> rejected
```

| Status | Meaning |
|---|---|
| `invited` | User has been invited but hasn't responded |
| `joined` | User is actively in the call |
| `left` | User left the call |
| `rejected` | User declined the invitation |

### Complete Call Flow (Mobile App)

```
CALLER (Employer/Sub-employer):
1. GET  /callable-users              --> Show user picker UI
2. POST /initiate                    --> Create call with first receiver
3. Connect to ZEGOCLOUD room using room_id from response
4. (Optional) POST /{id}/add-participants --> Add more people mid-call
5. POST /{id}/leave or /{id}/end    --> Leave or end call

RECEIVER:
1. Receive FCM push notification with call data
2. Show incoming call UI (accept/reject)
3. If accept: POST /{id}/join       --> Get room_id
4. Connect to ZEGOCLOUD room using room_id from response
5. POST /{id}/leave                 --> Leave call when done

BOTH:
- Listen to Pusher events for real-time updates
- GET /{id}/details                 --> Refresh call state
- GET /{id}/participants            --> Refresh participant list
```

---

## 7. Real-Time Events (Pusher)

Subscribe to private channel: `private-group-call.{groupCallId}`

| Event Name | Payload | Description |
|---|---|---|
| `participant.joined` | `{ user: { id, name }, participant_count: int }` | A participant joined the call |
| `participant.left` | `{ user: { id, name }, participant_count: int }` | A participant left the call |
| `call.ended` | `{ group_call_id: int }` | The host ended the call |
| `invite.rejected` | `{ user: { id, name } }` | An invited user rejected the call |

### Flutter Pusher Setup

```dart
// Use pusher_channels_flutter package
final pusher = PusherChannelsFlutter.getInstance();

await pusher.init(
  apiKey: 'YOUR_PUSHER_KEY',
  cluster: 'YOUR_PUSHER_CLUSTER',
  onAuthorizer: (channelName, socketId, options) async {
    // Call your backend's /broadcasting/auth endpoint
    final response = await http.post(
      Uri.parse('$baseUrl/broadcasting/auth'),
      headers: {'Authorization': 'Bearer $token'},
      body: {'socket_id': socketId, 'channel_name': channelName},
    );
    return jsonDecode(response.body);
  },
);

await pusher.connect();

final channel = await pusher.subscribe(
  channelName: 'private-group-call.$groupCallId',
  onEvent: (event) {
    switch (event.eventName) {
      case 'participant.joined':
        // Update UI - show toast, update participant count
        break;
      case 'participant.left':
        // Update UI
        break;
      case 'call.ended':
        // Disconnect from ZEGOCLOUD room, navigate away
        break;
      case 'invite.rejected':
        // Show toast that user declined
        break;
    }
  },
);
```

---

## 8. Firebase Push Notifications

When a call is initiated or a participant is added, the backend sends an FCM notification to the receiver's device.

### Expected FCM Payload Structure

```json
{
  "notification": {
    "title": "Incoming Group Call",
    "body": "John Doe is calling you..."
  },
  "data": {
    "type": "group_call_invitation",
    "group_call_id": "1",
    "room_id": "group_room_abc123def456_1709312400",
    "call_type": "video",
    "caller_name": "John Doe",
    "caller_id": "10"
  }
}
```

### Handling in Flutter

```dart
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  if (message.data['type'] == 'group_call_invitation') {
    // Show incoming call UI overlay
    showIncomingCallScreen(
      groupCallId: int.parse(message.data['group_call_id']),
      roomId: message.data['room_id'],
      callType: message.data['call_type'],
      callerName: message.data['caller_name'],
    );
  }
});

// Handle notification when app is in background
FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
  if (message.data['type'] == 'group_call_invitation') {
    // Navigate to incoming call screen
  }
});
```

---

## 9. Flutter Implementation Guide

### 9.1 Joining a ZEGOCLOUD Room (After API Join)

After calling `POST /api/group-call/{id}/join` and getting the `room_id`, connect to the ZEGOCLOUD room:

```dart
import 'package:zego_uikit_prebuilt_call/zego_uikit_prebuilt_call.dart';

class GroupCallPage extends StatelessWidget {
  final String roomID;
  final String callType;  // "audio" or "video"
  final int currentUserId;
  final String currentUserName;

  const GroupCallPage({
    required this.roomID,
    required this.callType,
    required this.currentUserId,
    required this.currentUserName,
  });

  @override
  Widget build(BuildContext context) {
    return ZegoUIKitPrebuiltCall(
      appID: 21874046,
      appSign: 'YOUR_APP_SIGN',
      userID: currentUserId.toString(),
      userName: currentUserName,
      callID: roomID,  // This is the room_id from the API response
      config: callType == 'video'
          ? ZegoUIKitPrebuiltCallConfig.groupVideoCall()
          : ZegoUIKitPrebuiltCallConfig.groupVoiceCall()
        ..turnOnMicrophoneWhenJoining = true
        ..turnOnCameraWhenJoining = (callType == 'video')
        ..topMenuBarConfig.buttons = [
          ZegoCallMenuBarButtonName.showMemberListButton,
        ]
        ..bottomMenuBarConfig.buttons = [
          ZegoCallMenuBarButtonName.toggleMicrophoneButton,
          if (callType == 'video') ZegoCallMenuBarButtonName.toggleCameraButton,
          ZegoCallMenuBarButtonName.hangUpButton,
          if (callType == 'video') ZegoCallMenuBarButtonName.switchCameraButton,
        ]
        ..onHangUp = () {
          // Call leave API when user hangs up
          _leaveCall(context);
        },
    );
  }

  Future<void> _leaveCall(BuildContext context) async {
    // POST /api/group-call/{groupCallId}/leave
    await apiService.leaveCall(groupCallId);
    Navigator.of(context).pop();
  }
}
```

### 9.2 Initiating a Call

```dart
Future<void> startGroupCall(int receiverId, String callType) async {
  final response = await http.post(
    Uri.parse('$baseUrl/api/group-call/initiate'),
    headers: {
      'Authorization': 'Bearer $authToken',
      'Content-Type': 'application/json',
    },
    body: jsonEncode({
      'receiver_id': receiverId,
      'call_type': callType,
    }),
  );

  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    final roomId = data['room_id'];
    final groupCallId = data['group_call_id'];

    // Navigate to the call screen
    Navigator.push(context, MaterialPageRoute(
      builder: (_) => GroupCallPage(
        roomID: roomId,
        callType: callType,
        currentUserId: currentUser.id,
        currentUserName: currentUser.name,
      ),
    ));
  }
}
```

### 9.3 Accepting an Incoming Call

```dart
Future<void> acceptCall(int groupCallId) async {
  final response = await http.post(
    Uri.parse('$baseUrl/api/group-call/$groupCallId/join'),
    headers: {'Authorization': 'Bearer $authToken'},
  );

  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    final roomId = data['room_id'];
    final callType = data['call_type'];

    Navigator.push(context, MaterialPageRoute(
      builder: (_) => GroupCallPage(
        roomID: roomId,
        callType: callType,
        currentUserId: currentUser.id,
        currentUserName: currentUser.name,
      ),
    ));
  }
}
```

### 9.4 Rejecting an Incoming Call

```dart
Future<void> rejectCall(int groupCallId) async {
  await http.post(
    Uri.parse('$baseUrl/api/group-call/$groupCallId/reject'),
    headers: {'Authorization': 'Bearer $authToken'},
  );
  // Dismiss incoming call UI
}
```

### 9.5 Adding Participants Mid-Call

```dart
Future<void> addParticipants(int groupCallId, List<int> userIds) async {
  final response = await http.post(
    Uri.parse('$baseUrl/api/group-call/$groupCallId/add-participants'),
    headers: {
      'Authorization': 'Bearer $authToken',
      'Content-Type': 'application/json',
    },
    body: jsonEncode({
      'participant_ids': userIds,
    }),
  );

  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    print('Added ${data['added_count']} participants');
  }
}
```

### 9.6 Fetching Callable Users (For User Picker)

```dart
Future<List<User>> getCallableUsers({int? groupCallId}) async {
  String url = '$baseUrl/api/group-call/callable-users';
  if (groupCallId != null) {
    url += '?group_call_id=$groupCallId';
  }

  final response = await http.get(
    Uri.parse(url),
    headers: {'Authorization': 'Bearer $authToken'},
  );

  final data = jsonDecode(response.body);
  return (data['users'] as List).map((u) => User.fromJson(u)).toList();
}
```

---

## 10. Error Handling

### HTTP Error Codes

| Code | Meaning | Action |
|---|---|---|
| 200 | Success | Process response |
| 400 | Bad request (call ended, full, self-call, invalid state) | Show error message to user |
| 403 | Forbidden (not authorized, not a participant) | Show permission error |
| 422 | Validation error | Check request body |
| 401 | Unauthenticated | Redirect to login |
| 500 | Server error | Retry or show generic error |

### Common Error Scenarios

| Scenario | API Response | Mobile Action |
|---|---|---|
| Call already ended | 400 | Show "Call has ended" toast, dismiss call UI |
| Call is full | 400 | Show "Call is full" message |
| Not invited | 403 | Show "You are not invited" message |
| Host left | Pusher `call.ended` event | Auto-disconnect from ZEGOCLOUD, navigate away |
| Network disconnect | ZEGOCLOUD SDK callback | Show reconnecting UI, retry |

---

## 11. Platform-Specific Configuration

### Android

**`android/app/build.gradle`:**
```gradle
android {
    compileSdkVersion 33

    defaultConfig {
        minSdkVersion 21
    }
}
```

**`android/app/src/main/AndroidManifest.xml` permissions:**
```xml
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.RECORD_AUDIO" />
<uses-permission android:name="android.permission.CAMERA" />
<uses-permission android:name="android.permission.WAKE_LOCK" />
<uses-permission android:name="android.permission.VIBRATE" />
<uses-permission android:name="android.permission.POST_NOTIFICATIONS" />
<uses-permission android:name="android.permission.SYSTEM_ALERT_WINDOW" />
```

**Proguard rules (`android/app/proguard-rules.pro`):**
```
-keep class **.zego.** { *; }
```

### iOS

**`ios/Podfile`:**
```ruby
post_install do |installer|
  installer.pods_project.targets.each do |target|
    flutter_additional_ios_build_settings(target)
    target.build_configurations.each do |config|
      config.build_settings['GCC_PREPROCESSOR_DEFINITIONS'] ||= [
        '$(inherited)',
        'PERMISSION_CAMERA=1',
        'PERMISSION_MICROPHONE=1',
      ]
    end
  end
end
```

**`ios/Runner/Info.plist`:**
```xml
<key>NSCameraUsageDescription</key>
<string>We need camera access for video calls</string>
<key>NSMicrophoneUsageDescription</key>
<string>We need microphone access for calls</string>
```

**Additional iOS Setup:**
- Add Push Notifications capability
- Add Background Modes capability (Audio, VoIP, Remote notifications)
- Disable Bitcode for: `zego_zim`, `zego_zpns`, `zego_express_engine`

---

## Quick Reference - API Endpoints Summary

| Method | Endpoint | Purpose | Who Can Call |
|---|---|---|---|
| `POST` | `/api/group-call/initiate` | Start a new call | Employer, Sub-employer |
| `POST` | `/api/group-call/{id}/join` | Accept & join a call | Invited participants |
| `POST` | `/api/group-call/{id}/reject` | Decline a call | Invited participants |
| `POST` | `/api/group-call/{id}/leave` | Leave an active call | Active participants |
| `POST` | `/api/group-call/{id}/end` | End call for everyone | Host only |
| `POST` | `/api/group-call/{id}/add-participants` | Add users mid-call | Host or participants |
| `GET` | `/api/group-call/{id}/details` | Get call info | Host or participants |
| `GET` | `/api/group-call/{id}/participants` | Get participant list | Host or participants |
| `GET` | `/api/group-call/callable-users` | Get available users | Employer, Sub-employer |

---

## Useful Links

- [ZEGOCLOUD Video Call SDK - Flutter Quick Start](https://www.zegocloud.com/docs/video-call/quickstart?platform=flutter&language=dart)
- [ZEGOCLOUD Call Kit (Flutter) Overview](https://www.zegocloud.com/docs/uikit/callkit-flutter/overview)
- [ZEGOCLOUD Call Kit - Quick Start with Invitation](https://www.zegocloud.com/docs/uikit/callkit-flutter/quick-start-(with-call-invitation))
- [ZEGOCLOUD Video Conference Kit (Flutter)](https://www.zegocloud.com/docs/uikit/video-conference-kit-flutter/quick-start)
- [ZEGOCLOUD Call Kit Example (GitHub)](https://github.com/ZEGOCLOUD/zego_uikit_prebuilt_call_example_flutter)
- [ZEGOCLOUD Admin Console](https://console.zegocloud.com)
