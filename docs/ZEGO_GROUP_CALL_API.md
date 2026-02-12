# Zego Cloud Group Call API Documentation

## Overview

This document provides comprehensive API documentation for the Zego Cloud Group Call system integration. All endpoints require user authentication.

**Base URL:** `{YOUR_BASE_URL}/group-call`

**Authentication:** All endpoints require the user to be authenticated. Include the authentication token/session in your requests.

---

## Quick Reference - API Endpoints

| # | Action | Method | Endpoint | Auth Required |
|---|--------|--------|----------|---------------|
| 1 | Search Users | GET | `/group-call/search-users?query={text}` | Yes |
| 2 | Initiate Call | POST | `/group-call/initiate` | Yes |
| 3 | Join Call | POST | `/group-call/{id}/join` | Yes |
| 4 | Reject Call | POST | `/group-call/{id}/reject` | Yes |
| 5 | Leave Call | POST | `/group-call/{id}/leave` | Yes |
| 6 | End Call | POST | `/group-call/{id}/end` | Yes (Host only) |
| 7 | Add Participants | POST | `/group-call/{id}/add-participants` | Yes |
| 8 | Get Call Details | GET | `/group-call/{id}/details` | Yes |
| 9 | Get Participants | GET | `/group-call/{id}/participants` | Yes |

---

## API Call Workflows

### Workflow 1: Starting a New Group Call (Host Flow)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                        HOST STARTS A GROUP CALL                             │
└─────────────────────────────────────────────────────────────────────────────┘

Step 1: Search for users to invite
        ↓
    GET /group-call/search-users?query=john
        ↓
    Response: List of users with id, name, email, image
        ↓
Step 2: Select users and initiate call
        ↓
    POST /group-call/initiate
    Body: { participant_ids: [2,5,8], call_type: "video", name: "Team Call" }
        ↓
    Response: { group_call: {...}, room_url: "..." }
        ↓
Step 3: Extract room_id from response
        ↓
Step 4: Connect to Zego Cloud SDK using room_id
        ↓
    [HOST IS NOW IN THE CALL - WAITING FOR OTHERS TO JOIN]
```

**Code Example (Host Starting Call):**

```javascript
// Step 1: Search users
const searchResponse = await fetch('/group-call/search-users?query=john', {
    method: 'GET',
    headers: { 'Authorization': 'Bearer {token}' }
});
const { users } = await searchResponse.json();
// users = [{ id: 2, name: "John", email: "john@example.com", image: "..." }, ...]

// Step 2: Initiate the call
const initiateResponse = await fetch('/group-call/initiate', {
    method: 'POST',
    headers: {
        'Authorization': 'Bearer {token}',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        participant_ids: [2, 5, 8],  // User IDs from search
        call_type: 'video',          // or 'audio'
        name: 'Team Meeting'         // Optional
    })
});
const { group_call, room_url } = await initiateResponse.json();

// Step 3: Use these values for Zego SDK
const roomId = group_call.room_id;      // "group_room_xxx_123456"
const groupCallId = group_call.id;       // 1
const callType = group_call.call_type;   // "video"

// Step 4: Initialize Zego Cloud SDK with roomId
// zegoCloud.joinRoom(roomId, userInfo);
```

---

### Workflow 2: Receiving & Joining a Call (Participant Flow)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                     PARTICIPANT RECEIVES CALL INVITATION                     │
└─────────────────────────────────────────────────────────────────────────────┘

    [Firebase Push Notification Received]
        ↓
    Extract: group_call_id, room_id, call_type, host_name
        ↓
    Show Incoming Call UI to User
        ↓
    ┌─────────────────┬─────────────────┐
    │                 │                 │
    ▼                 ▼                 │
[User Accepts]    [User Rejects]        │
    │                 │                 │
    ▼                 ▼                 │
POST /group-call  POST /group-call      │
/{id}/join        /{id}/reject          │
    │                 │                 │
    ▼                 ▼                 │
Response:         Response:             │
{room_url,        {success: true}       │
group_call}           │                 │
    │                 │                 │
    ▼                 ▼                 │
Connect to        Close Incoming        │
Zego SDK          Call UI               │
    │                                   │
    ▼                                   │
[PARTICIPANT IS                         │
NOW IN THE CALL]                        │
```

**Code Example (Participant Joining Call):**

```javascript
// Firebase notification received with data:
const notificationData = {
    notification_type: 'group_call_invite',
    group_call_id: 1,
    room_id: 'group_room_xxx_123456',
    call_type: 'video',
    host_name: 'John Doe',
    host_id: 1,
    host_photo: 'https://...',
    call_name: 'Team Meeting'
};

// Show incoming call UI...

// If user ACCEPTS the call:
async function acceptCall(groupCallId) {
    const response = await fetch(`/group-call/${groupCallId}/join`, {
        method: 'POST',
        headers: { 'Authorization': 'Bearer {token}' }
    });
    const { group_call, room_url } = await response.json();

    // Connect to Zego SDK
    const roomId = group_call.room_id;
    // zegoCloud.joinRoom(roomId, userInfo);
}

// If user REJECTS the call:
async function rejectCall(groupCallId) {
    await fetch(`/group-call/${groupCallId}/reject`, {
        method: 'POST',
        headers: { 'Authorization': 'Bearer {token}' }
    });
    // Close incoming call UI
}
```

---

### Workflow 3: During Active Call (In-Call Actions)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           DURING ACTIVE CALL                                 │
└─────────────────────────────────────────────────────────────────────────────┘

                        [CALL IS ACTIVE]
                              │
        ┌─────────────────────┼─────────────────────┐
        │                     │                     │
        ▼                     ▼                     ▼
   Add More            Get Participants        Leave/End Call
   Participants              │                     │
        │                     │           ┌────────┴────────┐
        ▼                     ▼           │                 │
POST /{id}/          GET /{id}/      [If Host]        [If Participant]
add-participants     participants         │                 │
        │                     │           ▼                 ▼
        ▼                     ▼      POST /{id}/end   POST /{id}/leave
New users get        Returns:             │                 │
invited via          - participants       ▼                 ▼
Firebase             - invited        [Call ends       [User exits,
                                      for everyone]    call continues]
```

**Code Example (In-Call Actions):**

```javascript
// Add more participants during call
async function addParticipants(groupCallId, userIds) {
    const response = await fetch(`/group-call/${groupCallId}/add-participants`, {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer {token}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            participant_ids: userIds  // [15, 20, 25]
        })
    });
    const { added_count, group_call } = await response.json();
    // added_count = 3
}

// Get current participants (for UI display)
async function getParticipants(groupCallId) {
    const response = await fetch(`/group-call/${groupCallId}/participants`, {
        method: 'GET',
        headers: { 'Authorization': 'Bearer {token}' }
    });
    const { participants, invited } = await response.json();
    // participants = users currently in call (status: "joined")
    // invited = users still pending (status: "invited")
}

// Leave call (for participants)
async function leaveCall(groupCallId) {
    await fetch(`/group-call/${groupCallId}/leave`, {
        method: 'POST',
        headers: { 'Authorization': 'Bearer {token}' }
    });
    // Disconnect from Zego SDK
    // zegoCloud.leaveRoom();
}

// End call (HOST ONLY)
async function endCall(groupCallId) {
    await fetch(`/group-call/${groupCallId}/end`, {
        method: 'POST',
        headers: { 'Authorization': 'Bearer {token}' }
    });
    // This ends the call for ALL participants
}
```

---

### Workflow 4: Complete Call Lifecycle

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                        COMPLETE CALL LIFECYCLE                               │
└─────────────────────────────────────────────────────────────────────────────┘

[HOST]                                              [PARTICIPANTS]
   │                                                      │
   │ 1. POST /initiate                                    │
   │    {participant_ids, call_type}                      │
   │──────────────────────────────────────────────────────┼──→ Firebase Push
   │                                                      │    Notification
   │ 2. Connect to Zego SDK                               │
   │    (status: "initiated")                             │
   │                                                      │ 3. Show Incoming
   │                                                      │    Call UI
   │                                                      │
   │                                                      │ 4a. POST /{id}/join
   │◀──────────────────────────────────────────────────────    OR
   │    WebSocket: ParticipantJoined                      │ 4b. POST /{id}/reject
   │    (status changes to "active")                      │
   │                                                      │
   │                        [CALL ACTIVE]                 │
   │                             │                        │
   │ 5. Optional: Add more       │                        │
   │    POST /{id}/add-participants                       │
   │                             │                        │
   │ 6. Optional: GET /{id}/participants                  │ 6. Same
   │    (sync participant list)  │                        │
   │                             │                        │
   │                             │                        │ 7. POST /{id}/leave
   │◀──────────────────────────────────────────────────────    (optional)
   │    WebSocket: ParticipantLeft                        │
   │                             │                        │
   │ 8. POST /{id}/end           │                        │
   │    OR POST /{id}/leave      │                        │
   │────────────────────────────────────────────────────────→ WebSocket:
   │                                                      │   CallEnded
   │              [CALL ENDED - status: "ended"]          │
   │                                                      │
```

---

## Step-by-Step Implementation Guide

### Step 1: Setup Firebase Notification Handler

```javascript
// Handle incoming call notification
function handleFirebaseNotification(notification) {
    if (notification.data.notification_type === 'group_call_invite') {
        const callData = {
            groupCallId: notification.data.group_call_id,
            roomId: notification.data.room_id,
            callType: notification.data.call_type,
            hostName: notification.data.host_name,
            hostPhoto: notification.data.host_photo,
            callName: notification.data.call_name
        };

        // Show incoming call screen
        showIncomingCallUI(callData);
    }
}
```

### Step 2: Implement Call Actions

```javascript
class GroupCallService {
    constructor(baseUrl, authToken) {
        this.baseUrl = baseUrl;
        this.headers = {
            'Authorization': `Bearer ${authToken}`,
            'Content-Type': 'application/json'
        };
    }

    // Search users to invite
    async searchUsers(query) {
        const response = await fetch(
            `${this.baseUrl}/group-call/search-users?query=${query}`,
            { method: 'GET', headers: this.headers }
        );
        return response.json(); // { users: [...] }
    }

    // Start a new call
    async initiateCall(participantIds, callType, name = null) {
        const response = await fetch(
            `${this.baseUrl}/group-call/initiate`,
            {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({
                    participant_ids: participantIds,
                    call_type: callType,
                    name: name
                })
            }
        );
        return response.json(); // { success, group_call, room_url }
    }

    // Join a call (when invited)
    async joinCall(groupCallId) {
        const response = await fetch(
            `${this.baseUrl}/group-call/${groupCallId}/join`,
            { method: 'POST', headers: this.headers }
        );
        return response.json(); // { success, group_call, room_url }
    }

    // Reject a call invitation
    async rejectCall(groupCallId) {
        const response = await fetch(
            `${this.baseUrl}/group-call/${groupCallId}/reject`,
            { method: 'POST', headers: this.headers }
        );
        return response.json(); // { success }
    }

    // Leave an active call
    async leaveCall(groupCallId) {
        const response = await fetch(
            `${this.baseUrl}/group-call/${groupCallId}/leave`,
            { method: 'POST', headers: this.headers }
        );
        return response.json(); // { success }
    }

    // End call (host only)
    async endCall(groupCallId) {
        const response = await fetch(
            `${this.baseUrl}/group-call/${groupCallId}/end`,
            { method: 'POST', headers: this.headers }
        );
        return response.json(); // { success }
    }

    // Add more participants to ongoing call
    async addParticipants(groupCallId, participantIds) {
        const response = await fetch(
            `${this.baseUrl}/group-call/${groupCallId}/add-participants`,
            {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({ participant_ids: participantIds })
            }
        );
        return response.json(); // { success, added_count, group_call }
    }

    // Get call details
    async getCallDetails(groupCallId) {
        const response = await fetch(
            `${this.baseUrl}/group-call/${groupCallId}/details`,
            { method: 'GET', headers: this.headers }
        );
        return response.json(); // { group_call }
    }

    // Get participants list
    async getParticipants(groupCallId) {
        const response = await fetch(
            `${this.baseUrl}/group-call/${groupCallId}/participants`,
            { method: 'GET', headers: this.headers }
        );
        return response.json(); // { participants, invited }
    }
}
```

### Step 3: Connect to Zego Cloud SDK

```javascript
// After initiating or joining a call
async function connectToZegoCall(groupCall, currentUser) {
    const roomId = groupCall.room_id;
    const callType = groupCall.call_type;

    // Initialize Zego SDK (pseudo-code - refer to Zego docs)
    const zegoEngine = new ZegoExpressEngine(appID, server);

    await zegoEngine.loginRoom(roomId, {
        userID: currentUser.id.toString(),
        userName: currentUser.name
    });

    if (callType === 'video') {
        await zegoEngine.startPublishingStream(streamID);
        await zegoEngine.startPreview();
    } else {
        // Audio only
        await zegoEngine.startPublishingStream(streamID, { video: false });
    }
}
```

---

## Data Models

### GroupCall Object

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier for the group call |
| `host_id` | integer | User ID of the call host |
| `room_id` | string | Unique room identifier for Zego Cloud |
| `name` | string | Name/title of the group call |
| `call_type` | string | Type of call: `"audio"` or `"video"` |
| `status` | string | Call status: `"initiated"`, `"active"`, or `"ended"` |
| `max_participants` | integer | Maximum allowed participants (default: 10) |
| `started_at` | datetime/null | When the call started |
| `ended_at` | datetime/null | When the call ended |
| `duration` | integer/null | Call duration in seconds |
| `created_at` | datetime | Record creation timestamp |
| `updated_at` | datetime | Record update timestamp |
| `host` | User Object | Host user details (when loaded) |
| `participants` | array | List of GroupCallParticipant objects (when loaded) |

### GroupCallParticipant Object

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique identifier |
| `group_call_id` | integer | Associated group call ID |
| `user_id` | integer | Participant's user ID |
| `status` | string | `"invited"`, `"joined"`, `"rejected"`, or `"left"` |
| `invited_at` | datetime | When the invitation was sent |
| `joined_at` | datetime/null | When the participant joined |
| `left_at` | datetime/null | When the participant left |
| `user` | User Object | User details (when loaded) |

### User Object (Partial)

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | User ID |
| `name` | string | User's display name |
| `email` | string | User's email address |
| `image` | string/null | User's profile image URL |

---

## API Endpoints - Detailed Reference

### 1. Search Users

Search for users to invite to a group call.

| | |
|---|---|
| **Endpoint** | `GET /group-call/search-users` |
| **Method** | GET |
| **Auth Required** | Yes |

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `query` | string | Yes | Search term (min 2 characters) |

**Request:**
```
GET /group-call/search-users?query=john
```

**Response (200):**
```json
{
    "users": [
        {
            "id": 3,
            "name": "John Williams",
            "email": "johnw@example.com",
            "image": "https://example.com/images/johnw.jpg"
        }
    ]
}
```

---

### 2. Initiate Group Call

| | |
|---|---|
| **Endpoint** | `POST /group-call/initiate` |
| **Method** | POST |
| **Auth Required** | Yes |

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `participant_ids` | array[integer] | Yes | User IDs to invite (min 1) |
| `call_type` | string | Yes | `"audio"` or `"video"` |
| `name` | string | No | Call name (max 100 chars) |

**Request:**
```json
{
    "participant_ids": [2, 5, 8],
    "call_type": "video",
    "name": "Team Meeting"
}
```

**Response (200):**
```json
{
    "success": true,
    "group_call": {
        "id": 1,
        "host_id": 1,
        "room_id": "group_room_aB3dEf4GhI5jKlMn6OpQ_1706360400",
        "name": "Team Meeting",
        "call_type": "video",
        "status": "initiated",
        "max_participants": 10,
        "started_at": null,
        "ended_at": null,
        "duration": null,
        "participants": [...]
    },
    "room_url": "https://yourapp.com/group-call/call-page?roomID=...&type=video&groupCallId=1"
}
```

**Errors:**
- `400`: "You must invite at least one other participant"
- `422`: Validation errors

---

### 3. Join Group Call

| | |
|---|---|
| **Endpoint** | `POST /group-call/{groupCallId}/join` |
| **Method** | POST |
| **Auth Required** | Yes |

**URL Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `groupCallId` | integer | The group call ID |

**Request:**
```
POST /group-call/1/join
```

**Response (200):**
```json
{
    "success": true,
    "group_call": {
        "id": 1,
        "room_id": "group_room_aB3dEf4GhI5jKlMn6OpQ_1706360400",
        "status": "active",
        "participants": [...]
    },
    "room_url": "https://yourapp.com/group-call/call-page?roomID=...&type=video&groupCallId=1"
}
```

**Errors:**
- `403`: "You are not invited to this call"
- `400`: "Call is full or has ended"

---

### 4. Reject Group Call

| | |
|---|---|
| **Endpoint** | `POST /group-call/{groupCallId}/reject` |
| **Method** | POST |
| **Auth Required** | Yes |

**Request:**
```
POST /group-call/1/reject
```

**Response (200):**
```json
{
    "success": true
}
```

**Errors:**
- `400`: "Invalid request"

---

### 5. Leave Group Call

| | |
|---|---|
| **Endpoint** | `POST /group-call/{groupCallId}/leave` |
| **Method** | POST |
| **Auth Required** | Yes |

**Request:**
```
POST /group-call/1/leave
```

**Response (200):**
```json
{
    "success": true
}
```

**Note:** If the HOST leaves, the call ENDS for everyone automatically.

**Errors:**
- `400`: "You are not in this call"

---

### 6. End Group Call (Host Only)

| | |
|---|---|
| **Endpoint** | `POST /group-call/{groupCallId}/end` |
| **Method** | POST |
| **Auth Required** | Yes (Host only) |

**Request:**
```
POST /group-call/1/end
```

**Response (200):**
```json
{
    "success": true
}
```

**Errors:**
- `403`: "Only the host can end the call"

---

### 7. Add Participants

| | |
|---|---|
| **Endpoint** | `POST /group-call/{groupCallId}/add-participants` |
| **Method** | POST |
| **Auth Required** | Yes |

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `participant_ids` | array[integer] | Yes | User IDs to add |

**Request:**
```json
{
    "participant_ids": [15, 20]
}
```

**Response (200):**
```json
{
    "success": true,
    "added_count": 2,
    "group_call": {...}
}
```

**Errors:**
- `403`: "Unauthorized"
- `400`: "Call has ended"

---

### 8. Get Call Details

| | |
|---|---|
| **Endpoint** | `GET /group-call/{groupCallId}/details` |
| **Method** | GET |
| **Auth Required** | Yes |

**Response (200):**
```json
{
    "group_call": {
        "id": 1,
        "host_id": 1,
        "room_id": "group_room_xxx",
        "name": "Team Meeting",
        "call_type": "video",
        "status": "active",
        "host": {...},
        "participants": [...]
    }
}
```

---

### 9. Get Participants

| | |
|---|---|
| **Endpoint** | `GET /group-call/{groupCallId}/participants` |
| **Method** | GET |
| **Auth Required** | Yes |

**Response (200):**
```json
{
    "participants": [
        {
            "id": 1,
            "user_id": 1,
            "status": "joined",
            "user": { "id": 1, "name": "John", ... }
        }
    ],
    "invited": [
        {
            "id": 2,
            "user_id": 5,
            "status": "invited",
            "user": { "id": 5, "name": "Bob", ... }
        }
    ]
}
```

---

## Firebase Push Notification Payload

When a user is invited, they receive this FCM notification:

```json
{
    "notification_type": "group_call_invite",
    "host_name": "John Doe",
    "host_id": 1,
    "host_photo": "https://example.com/images/john.jpg",
    "group_call_id": 1,
    "room_id": "group_room_aB3dEf4GhI5jKlMn6OpQ_1706360400",
    "call_type": "video",
    "call_name": "Team Meeting"
}
```

---

## WebSocket Events

Listen for these real-time events:

| Event | Trigger | Action |
|-------|---------|--------|
| `GroupCallInitiated` | New call invitation | Show incoming call UI |
| `GroupCallParticipantJoined` | User joins call | Update participant list |
| `GroupCallParticipantLeft` | User leaves call | Update participant list |
| `GroupCallInviteRejected` | User rejects invite | Update invited list |
| `GroupCallEnded` | Call ended | Close call UI, disconnect SDK |

---

## Status Flow Summary

```
CALL STATUS:
┌───────────┐     ┌────────┐     ┌───────┐
│ initiated │ ──→ │ active │ ──→ │ ended │
└───────────┘     └────────┘     └───────┘
   (created)     (first join)   (host ends/leaves)


PARTICIPANT STATUS:
┌─────────┐     ┌────────┐     ┌──────┐
│ invited │ ──→ │ joined │ ──→ │ left │
└─────────┘     └────────┘     └──────┘
     │
     │          ┌──────────┐
     └────────→ │ rejected │
                └──────────┘
```

---

## Error Codes

| HTTP | Meaning | Common Causes |
|------|---------|---------------|
| 200 | Success | Request completed |
| 400 | Bad Request | Call ended, invalid params |
| 403 | Forbidden | Not invited, not host |
| 422 | Validation Error | Missing/invalid fields |

---

## Checklist for Mobile App Developer

- [ ] Register FCM token with backend for push notifications
- [ ] Handle `group_call_invite` notification type
- [ ] Implement incoming call UI (accept/reject buttons)
- [ ] Integrate Zego Cloud SDK for actual video/audio
- [ ] Store `group_call_id` and `room_id` during active call
- [ ] Implement participant list UI (use GET /participants)
- [ ] Handle WebSocket events for real-time updates
- [ ] Implement leave/end call functionality
- [ ] Handle call ended event (disconnect SDK, close UI)
- [ ] Support both audio and video call types
