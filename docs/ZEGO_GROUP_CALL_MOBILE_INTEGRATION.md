# Zego Cloud Group Video Call - Mobile App Integration Guide

## Table of Contents
1. [Overview](#overview)
2. [Prerequisites](#prerequisites)
3. [Authentication](#authentication)
4. [API Base URL](#api-base-url)
5. [API Endpoints](#api-endpoints)
6. [Data Models](#data-models)
7. [Push Notifications (FCM)](#push-notifications-fcm)
8. [Call Flow Diagram](#call-flow-diagram)
9. [Zego SDK Integration](#zego-sdk-integration)
10. [Error Handling](#error-handling)
11. [Best Practices](#best-practices)

---

## Overview

This document provides integration guidelines for implementing Zego Cloud Group Video/Audio calling functionality in the mobile application. The system allows employers and sub-employers to initiate group calls with up to 10 participants.

### Key Features:
- Group video and audio calls
- Up to 10 participants per call
- Real-time participant management
- Push notification support for call invitations
- Host controls (add participants, end call)

---

## Prerequisites

### Required SDK/Libraries:
- **Zego Express SDK** for video/audio calling
- **Firebase Cloud Messaging (FCM)** for push notifications
- HTTP client for API calls

### Zego Cloud Credentials (obtain from backend team):
```
ZEGOCLOUD_APP_ID: [Get from backend]
```

---

## Authentication

All API endpoints require authentication using **Laravel Sanctum Bearer Token**.

### Headers Required:
```
Authorization: Bearer {sanctum_token}
Content-Type: application/json
Accept: application/json
```

---

## API Base URL

```
Production: https://your-domain.com/api/group-call
```

---

## API Endpoints

### 1. Initiate Group Call

Starts a new group call with an initial participant.

**Endpoint:** `POST /api/group-call/initiate`

**Permission:** Only `employer` and `sub_employer` user types can initiate calls.

**Request Body:**
```json
{
    "receiver_id": 123,
    "call_type": "video"
}
```

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| receiver_id | integer | Yes | User ID of the first person to invite |
| call_type | string | Yes | Either `"audio"` or `"video"` |

**Success Response (200):**
```json
{
    "success": true,
    "group_call": {
        "id": 1,
        "host_id": 10,
        "room_id": "group_room_abc123xyz_1704067200",
        "name": "John Doe's Group Call",
        "call_type": "video",
        "status": "initiated",
        "max_participants": 10,
        "started_at": null,
        "ended_at": null,
        "duration": null,
        "created_at": "2024-01-01T12:00:00.000000Z",
        "updated_at": "2024-01-01T12:00:00.000000Z",
        "participants": [
            {
                "id": 1,
                "group_call_id": 1,
                "user_id": 10,
                "status": "joined",
                "invited_at": "2024-01-01T12:00:00.000000Z",
                "joined_at": "2024-01-01T12:00:00.000000Z",
                "left_at": null,
                "user": {
                    "id": 10,
                    "name": "John Doe",
                    "email": "john@example.com",
                    "profile_image": "https://...",
                    "user_type": "employer"
                }
            },
            {
                "id": 2,
                "group_call_id": 1,
                "user_id": 123,
                "status": "invited",
                "invited_at": "2024-01-01T12:00:00.000000Z",
                "joined_at": null,
                "left_at": null,
                "user": {
                    "id": 123,
                    "name": "Jane Smith",
                    "email": "jane@example.com",
                    "profile_image": "https://...",
                    "user_type": "sub_employer"
                }
            }
        ]
    },
    "room_url": "https://your-domain.com/api/group-call/call-page?roomID=group_room_abc123xyz_1704067200&type=video&groupCallId=1"
}
```

**Error Responses:**
- `403` - Only employers can initiate group calls
- `400` - You cannot call yourself
- `422` - Validation error

---

### 2. Join Group Call

Join an existing group call that you were invited to.

**Endpoint:** `POST /api/group-call/{groupCallId}/join`

**Request Body:** None required

**Success Response (200):**
```json
{
    "success": true,
    "group_call": {
        "id": 1,
        "host_id": 10,
        "room_id": "group_room_abc123xyz_1704067200",
        "name": "John Doe's Group Call",
        "call_type": "video",
        "status": "active",
        "max_participants": 10,
        "started_at": "2024-01-01T12:01:00.000000Z",
        "ended_at": null,
        "duration": null,
        "participants": [...]
    },
    "room_url": "https://your-domain.com/api/group-call/call-page?roomID=group_room_abc123xyz_1704067200&type=video&groupCallId=1"
}
```

**Error Responses:**
- `403` - You are not invited to this call
- `400` - Call is full or has ended

---

### 3. Reject Group Call Invitation

Decline a group call invitation.

**Endpoint:** `POST /api/group-call/{groupCallId}/reject`

**Request Body:** None required

**Success Response (200):**
```json
{
    "success": true
}
```

**Error Responses:**
- `400` - Invalid request (not invited or already responded)

---

### 4. Leave Group Call

Leave an ongoing group call.

**Endpoint:** `POST /api/group-call/{groupCallId}/leave`

**Request Body:** None required

**Success Response (200):**
```json
{
    "success": true
}
```

**Important Notes:**
- If the **host** leaves, the call ends for all participants
- If all participants leave, the call automatically ends

**Error Responses:**
- `400` - You are not in this call

---

### 5. End Group Call (Host Only)

Forcefully end the group call for all participants.

**Endpoint:** `POST /api/group-call/{groupCallId}/end`

**Request Body:** None required

**Success Response (200):**
```json
{
    "success": true
}
```

**Error Responses:**
- `403` - Only the host can end the call

---

### 6. Add Participants to Ongoing Call

Add more participants to an active group call.

**Endpoint:** `POST /api/group-call/{groupCallId}/add-participants`

**Request Body:**
```json
{
    "participant_ids": [124, 125, 126]
}
```

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| participant_ids | array | Yes | Array of user IDs to invite |

**Success Response (200):**
```json
{
    "success": true,
    "added_count": 3,
    "group_call": {
        "id": 1,
        "participants": [...]
    }
}
```

**Notes:**
- Users must be within the caller's team (sub-employers or parent employer)
- Already invited users are skipped
- Maximum 10 participants per call

**Error Responses:**
- `403` - Unauthorized
- `400` - Call has ended

---

### 7. Get Call Details

Retrieve complete information about a group call.

**Endpoint:** `GET /api/group-call/{groupCallId}/details`

**Success Response (200):**
```json
{
    "group_call": {
        "id": 1,
        "host_id": 10,
        "room_id": "group_room_abc123xyz_1704067200",
        "name": "John Doe's Group Call",
        "call_type": "video",
        "status": "active",
        "max_participants": 10,
        "started_at": "2024-01-01T12:01:00.000000Z",
        "ended_at": null,
        "duration": null,
        "created_at": "2024-01-01T12:00:00.000000Z",
        "updated_at": "2024-01-01T12:01:00.000000Z",
        "host": {
            "id": 10,
            "name": "John Doe",
            "email": "john@example.com",
            "profile_image": "https://..."
        },
        "participants": [
            {
                "id": 1,
                "group_call_id": 1,
                "user_id": 10,
                "status": "joined",
                "invited_at": "2024-01-01T12:00:00.000000Z",
                "joined_at": "2024-01-01T12:00:00.000000Z",
                "left_at": null,
                "user": {
                    "id": 10,
                    "name": "John Doe",
                    "email": "john@example.com",
                    "profile_image": "https://...",
                    "user_type": "employer"
                }
            }
        ]
    }
}
```

**Error Responses:**
- `403` - Unauthorized (not host or participant)

---

### 8. Get Participants

Get list of active and invited participants.

**Endpoint:** `GET /api/group-call/{groupCallId}/participants`

**Success Response (200):**
```json
{
    "participants": [
        {
            "id": 1,
            "group_call_id": 1,
            "user_id": 10,
            "status": "joined",
            "invited_at": "2024-01-01T12:00:00.000000Z",
            "joined_at": "2024-01-01T12:00:00.000000Z",
            "left_at": null,
            "user": {
                "id": 10,
                "name": "John Doe",
                "email": "john@example.com",
                "profile_image": "https://..."
            }
        }
    ],
    "invited": [
        {
            "id": 2,
            "group_call_id": 1,
            "user_id": 123,
            "status": "invited",
            "invited_at": "2024-01-01T12:00:00.000000Z",
            "joined_at": null,
            "left_at": null,
            "user": {
                "id": 123,
                "name": "Jane Smith",
                "email": "jane@example.com",
                "profile_image": "https://..."
            }
        }
    ]
}
```

**Error Responses:**
- `403` - Unauthorized

---

### 9. Get Callable Users

Get list of users that can be added to a group call.

**Endpoint:** `GET /api/group-call/callable-users`

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| group_call_id | integer | No | If provided, excludes users already in this call |

**Success Response (200):**
```json
{
    "users": [
        {
            "id": 124,
            "name": "Alice Johnson",
            "email": "alice@example.com",
            "profile_image": "https://...",
            "user_type": "sub_employer"
        },
        {
            "id": 125,
            "name": "Bob Williams",
            "email": "bob@example.com",
            "profile_image": "https://...",
            "user_type": "sub_employer"
        }
    ]
}
```

**Notes:**
- For `employer`: Returns their sub_employers
- For `sub_employer`: Returns parent employer + sibling sub_employers

---

## Data Models

### GroupCall Model

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| host_id | integer | User ID of call host |
| room_id | string | Unique Zego room identifier |
| name | string | Display name for the call |
| call_type | enum | `audio` or `video` |
| status | enum | `initiated`, `active`, or `ended` |
| max_participants | integer | Maximum allowed participants (default: 10) |
| started_at | datetime | When first participant joined |
| ended_at | datetime | When call ended |
| duration | integer | Call duration in seconds |
| created_at | datetime | Record creation time |
| updated_at | datetime | Last update time |

### GroupCallParticipant Model

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| group_call_id | integer | Foreign key to group_calls |
| user_id | integer | User ID of participant |
| status | enum | `invited`, `joined`, `left`, or `rejected` |
| invited_at | datetime | When user was invited |
| joined_at | datetime | When user joined |
| left_at | datetime | When user left |

### Participant Status Flow:
```
invited -> joined -> left
invited -> rejected
```

### Call Status Flow:
```
initiated -> active -> ended
```

---

## Push Notifications (FCM)

### Group Call Invitation Notification

When a user is invited to a group call, they receive a push notification.

**Notification Payload:**
```json
{
    "notification": {
        "title": "Group Video Call Invitation",
        "body": "John Doe is inviting you to join a group call"
    },
    "data": {
        "notification_type": "group_call_invite",
        "group_call_id": "1",
        "room_id": "group_room_abc123xyz_1704067200",
        "call_type": "video",
        "call_name": "John Doe's Group Call",
        "host_id": "10",
        "host_name": "John Doe",
        "host_photo": "https://...",
        "action": "group_call_invite",
        "timestamp": "2024-01-01T12:00:00+00:00"
    }
}
```

### Handling FCM Notifications

**Android (Flutter example):**
```dart
void handleGroupCallNotification(RemoteMessage message) {
  final data = message.data;

  if (data['notification_type'] == 'group_call_invite') {
    // Show incoming call UI
    showIncomingCallScreen(
      groupCallId: int.parse(data['group_call_id']),
      roomId: data['room_id'],
      callType: data['call_type'],
      hostName: data['host_name'],
      hostPhoto: data['host_photo'],
      callName: data['call_name'],
    );
  }
}
```

**iOS - Configure high-priority notifications:**
```swift
// Ensure VoIP push notifications are properly configured
// for a better call experience on iOS
```

### FCM Token Registration

Ensure the user's FCM token is registered with the backend:

**Endpoint:** `POST /api/update-fcm-token`

**Request Body:**
```json
{
    "fcm_token": "your_fcm_token_here"
}
```

---

## Call Flow Diagram

### Initiating a Call (Host)

```
┌─────────────┐          ┌─────────────┐          ┌─────────────┐
│   Host      │          │   Server    │          │  Receiver   │
└─────────────┘          └─────────────┘          └─────────────┘
       │                        │                        │
       │  POST /initiate        │                        │
       │───────────────────────>│                        │
       │                        │                        │
       │                        │  FCM Push Notification │
       │                        │───────────────────────>│
       │                        │                        │
       │  Response with room_id │                        │
       │<───────────────────────│                        │
       │                        │                        │
       │  Connect to Zego Room  │                        │
       │═══════════════════════>│                        │
       │                        │                        │
```

### Joining a Call (Participant)

```
┌─────────────┐          ┌─────────────┐          ┌─────────────┐
│ Participant │          │   Server    │          │   Zego      │
└─────────────┘          └─────────────┘          └─────────────┘
       │                        │                        │
       │  FCM Notification      │                        │
       │<═══════════════════════│                        │
       │                        │                        │
       │  POST /{id}/join       │                        │
       │───────────────────────>│                        │
       │                        │                        │
       │  Response with room_id │                        │
       │<───────────────────────│                        │
       │                        │                        │
       │  Connect to Zego Room  │                        │
       │════════════════════════════════════════════════>│
       │                        │                        │
```

---

## Zego SDK Integration

### Initialize Zego Express SDK

**Flutter Example:**
```dart
import 'package:zego_express_engine/zego_express_engine.dart';

class ZegoService {
  static const int appID = YOUR_APP_ID; // Get from backend team

  static Future<void> initializeEngine() async {
    ZegoEngineProfile profile = ZegoEngineProfile(
      appID,
      ZegoScenario.Default,
    );
    await ZegoExpressEngine.createEngineWithProfile(profile);
  }
}
```

### Join Room

```dart
Future<void> joinRoom({
  required String roomId,
  required String odIdStr,
  required String userName,
  required bool isVideo,
}) async {
  // Create user
  ZegoUser user = ZegoUser(userId, userName);

  // Room configuration
  ZegoRoomConfig config = ZegoRoomConfig.defaultConfig();
  config.isUserStatusNotify = true;

  // Login to room
  await ZegoExpressEngine.instance.loginRoom(
    roomId,
    user,
    config: config,
  );

  // Start publishing stream
  await ZegoExpressEngine.instance.startPublishingStream(
    '${roomId}_${userId}_stream',
  );

  if (isVideo) {
    // Start local preview
    await ZegoExpressEngine.instance.startPreview(
      canvas: ZegoCanvas(localViewId),
    );
  }
}
```

### Handle Remote Streams

```dart
void setupEventHandlers() {
  ZegoExpressEngine.onRoomStreamUpdate = (
    String roomID,
    ZegoUpdateType updateType,
    List<ZegoStream> streamList,
    Map<String, dynamic> extendedData,
  ) {
    if (updateType == ZegoUpdateType.Add) {
      // New stream available - start playing
      for (var stream in streamList) {
        ZegoExpressEngine.instance.startPlayingStream(
          stream.streamID,
          canvas: ZegoCanvas(getRemoteViewId(stream.user.userID)),
        );
      }
    } else {
      // Stream removed - stop playing
      for (var stream in streamList) {
        ZegoExpressEngine.instance.stopPlayingStream(stream.streamID);
      }
    }
  };

  ZegoExpressEngine.onRoomUserUpdate = (
    String roomID,
    ZegoUpdateType updateType,
    List<ZegoUser> userList,
  ) {
    // Handle user join/leave events
    if (updateType == ZegoUpdateType.Add) {
      // User joined
    } else {
      // User left
    }
  };
}
```

### Leave Room

```dart
Future<void> leaveRoom(String roomId) async {
  // Stop publishing
  await ZegoExpressEngine.instance.stopPublishingStream();

  // Stop preview
  await ZegoExpressEngine.instance.stopPreview();

  // Logout from room
  await ZegoExpressEngine.instance.logoutRoom(roomId);
}
```

### Mute/Unmute Controls

```dart
// Mute/unmute microphone
await ZegoExpressEngine.instance.muteMicrophone(isMuted);

// Enable/disable camera
await ZegoExpressEngine.instance.enableCamera(!isVideoOff);

// Switch camera (front/back)
await ZegoExpressEngine.instance.useFrontCamera(useFront);

// Enable/disable speaker
await ZegoExpressEngine.instance.muteSpeaker(isMuted);
```

---

## Error Handling

### HTTP Error Codes

| Code | Description | Action |
|------|-------------|--------|
| 400 | Bad Request | Check request parameters |
| 403 | Forbidden | User not authorized for this action |
| 404 | Not Found | Group call doesn't exist |
| 422 | Validation Error | Check request body format |
| 500 | Server Error | Retry or contact support |

### Common Error Responses

**Validation Error (422):**
```json
{
    "message": "The receiver id field is required.",
    "errors": {
        "receiver_id": ["The receiver id field is required."]
    }
}
```

**Authorization Error (403):**
```json
{
    "error": "Only employers can initiate group calls"
}
```

---

## Best Practices

### 1. Connection Management
- Always call the `/leave` endpoint when user leaves the call
- Handle app termination/background to properly leave the call
- Implement reconnection logic for network interruptions

### 2. UI/UX Recommendations
- Show incoming call UI with accept/reject buttons
- Display participant avatars and names
- Show connection status indicators
- Implement mute/camera toggle buttons
- Show call duration timer

### 3. Network Handling
- Check network connectivity before initiating calls
- Handle network changes gracefully
- Show appropriate error messages for connection issues

### 4. Resource Management
- Release Zego engine resources when not needed
- Stop all streams before leaving room
- Clean up views and controllers

### 5. Security
- Never expose Zego credentials in client code
- Always validate server responses
- Handle token expiration gracefully

---

## Quick Reference - API Endpoints Summary

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/group-call/initiate` | Start a new group call |
| POST | `/api/group-call/{id}/join` | Join an existing call |
| POST | `/api/group-call/{id}/reject` | Reject call invitation |
| POST | `/api/group-call/{id}/leave` | Leave the call |
| POST | `/api/group-call/{id}/end` | End call (host only) |
| POST | `/api/group-call/{id}/add-participants` | Add more participants |
| GET | `/api/group-call/{id}/details` | Get call details |
| GET | `/api/group-call/{id}/participants` | Get participant list |
| GET | `/api/group-call/callable-users` | Get users available to call |

---

## Support

For any questions or issues with this integration, please contact the backend development team.

**Version:** 1.0
**Last Updated:** February 2026
