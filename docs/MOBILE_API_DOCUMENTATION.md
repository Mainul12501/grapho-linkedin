# ZegoCloud Messaging API Documentation for Mobile Developers

## Table of Contents
1. [Overview](#overview)
2. [Authentication](#authentication)
3. [Base URL](#base-url)
4. [API Endpoints](#api-endpoints)
5. [Integration Flow](#integration-flow)
6. [Code Examples](#code-examples)
7. [Error Handling](#error-handling)
8. [Rate Limiting](#rate-limiting)
9. [Testing](#testing)

---

## Overview

This API provides backend services for implementing ZegoCloud ZIM (Zego Instant Messaging) in your mobile applications (iOS/Android/React Native/Flutter).

### What This API Provides:
- ✅ ZegoCloud authentication token generation
- ✅ User contact list management
- ✅ User profile management
- ✅ Online status updates
- ✅ User search functionality

### What You Need to Implement in Your App:
- ZegoCloud ZIM SDK integration (for actual messaging)
- Message UI/UX
- Push notifications (optional)
- Local message storage (optional)

---

## Authentication

All API endpoints require authentication using **Laravel Sanctum** tokens.

### Getting Authentication Token

**Option 1: Using Existing Login API**
```http
POST /api/auth/custom-login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "token": "1|laravel_sanctum_token_here...",
    "user": {
        "id": 123,
        "name": "John Doe",
        "email": "user@example.com"
    }
}
```

### Using the Token

Include the token in all subsequent API requests:

```http
Authorization: Bearer 1|laravel_sanctum_token_here...
```

---

## Base URL

**Production:** `https://yourdomain.com/api`
**Local Development:** `http://127.0.0.1:8000/api`

All endpoints are prefixed with `/api` automatically by Laravel.

---

## API Endpoints

### 1. Get ZegoCloud Token

Generate authentication token for ZegoCloud ZIM SDK.

**Endpoint:** `POST /zego/messaging/token`

**Headers:**
```
Authorization: Bearer {your_sanctum_token}
Content-Type: application/json
```

**Request Body:** None (uses authenticated user)

**Response:**
```json
{
    "success": true,
    "message": "Token generated successfully",
    "data": {
        "app_id": 131228524,
        "token": "04a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0...",
        "user_id": "123",
        "user_name": "John Doe",
        "expires_at": 1640000000,
        "expires_in_seconds": 3600
    }
}
```

**Usage in Mobile App:**
```dart
// Flutter example
final zimToken = response['data']['token'];
final appId = response['data']['app_id'];
final userId = response['data']['user_id'];

// Initialize ZIM SDK
ZIM.create(appID: appId);
await ZIM.getInstance()!.login(
  ZIMUserInfo(userID: userId, userName: userName),
  token: zimToken
);
```

---

### 2. Get Contacts List

Retrieve list of users available for messaging.

**Endpoint:** `GET /zego/messaging/contacts`

**Headers:**
```
Authorization: Bearer {your_sanctum_token}
```

**Query Parameters:**

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| search | string | No | - | Filter by name or email |
| limit | integer | No | 100 | Number of results (max: 500) |
| offset | integer | No | 0 | Pagination offset |
| user_type | string | No | - | Filter by type: employee/employer |

**Example Request:**
```http
GET /api/zego/messaging/contacts?search=john&limit=20&offset=0
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Contacts retrieved successfully",
    "data": {
        "contacts": [
            {
                "id": 2,
                "name": "John Doe",
                "email": "john@example.com",
                "user_type": "employee",
                "profile_photo_url": "https://example.com/photo.jpg",
                "is_online": true,
                "last_seen": "2025-12-09T10:30:00Z"
            },
            {
                "id": 3,
                "name": "Jane Smith",
                "email": "jane@example.com",
                "user_type": "employer",
                "profile_photo_url": null,
                "is_online": false,
                "last_seen": "2025-12-08T15:20:00Z"
            }
        ],
        "pagination": {
            "total": 150,
            "limit": 20,
            "offset": 0,
            "has_more": true
        }
    }
}
```

---

### 3. Get User Details

Get detailed information about a specific user.

**Endpoint:** `GET /zego/messaging/users/{user_id}`

**Headers:**
```
Authorization: Bearer {your_sanctum_token}
```

**Example Request:**
```http
GET /api/zego/messaging/users/123
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "User details retrieved successfully",
    "data": {
        "id": 123,
        "name": "John Doe",
        "email": "john@example.com",
        "user_type": "employee",
        "profile_photo_url": "https://example.com/photo.jpg",
        "is_online": true,
        "last_seen": "2025-12-09T10:30:00Z",
        "created_at": "2025-01-01T00:00:00Z"
    }
}
```

---

### 4. Search Users

Search for users by name or email.

**Endpoint:** `POST /zego/messaging/search-users`

**Headers:**
```
Authorization: Bearer {your_sanctum_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "query": "john",
    "limit": 20
}
```

**Response:**
```json
{
    "success": true,
    "message": "Search completed successfully",
    "data": {
        "results": [
            {
                "id": 2,
                "name": "John Doe",
                "email": "john@example.com",
                "user_type": "employee",
                "profile_photo_url": "https://example.com/photo.jpg"
            }
        ],
        "total": 5
    }
}
```

---

### 5. Get Current User Profile

Get authenticated user's profile information.

**Endpoint:** `GET /zego/messaging/profile`

**Headers:**
```
Authorization: Bearer {your_sanctum_token}
```

**Response:**
```json
{
    "success": true,
    "message": "Profile retrieved successfully",
    "data": {
        "id": 1,
        "name": "Current User",
        "email": "user@example.com",
        "user_type": "employee",
        "profile_photo_url": "https://example.com/photo.jpg",
        "is_online": true,
        "created_at": "2025-01-01T00:00:00Z"
    }
}
```

---

### 6. Update Online Status

Update user's online/offline status.

**Endpoint:** `POST /zego/messaging/update-online-status`

**Headers:**
```
Authorization: Bearer {your_sanctum_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "is_online": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "Online status updated successfully",
    "data": {
        "is_online": true,
        "last_seen": "2025-12-09T10:30:00Z"
    }
}
```

**Best Practice:**
Call this endpoint:
- When app comes to foreground: `is_online: true`
- When app goes to background: `is_online: false`
- When user logs out: `is_online: false`

---

### 7. Verify Token

Verify if authentication token is still valid.

**Endpoint:** `POST /zego/messaging/verify-token`

**Headers:**
```
Authorization: Bearer {your_sanctum_token}
```

**Response:**
```json
{
    "success": true,
    "message": "Token is valid",
    "data": {
        "valid": true,
        "user_id": "123"
    }
}
```

---

## Integration Flow

### Complete Mobile App Integration Steps

```
1. User Login
   ↓
2. Receive Laravel Sanctum Token
   ↓
3. Call GET /zego/messaging/token
   ↓
4. Receive ZegoCloud Token & App ID
   ↓
5. Initialize ZIM SDK with Token
   ↓
6. Load Contacts (GET /zego/messaging/contacts)
   ↓
7. Display Contact List in UI
   ↓
8. User Selects Contact
   ↓
9. Use ZIM SDK to Send/Receive Messages
   ↓
10. Update Online Status Periodically
```

### Flowchart

```
┌─────────────────┐
│   User Login    │
└────────┬────────┘
         │
         ▼
┌─────────────────────────┐
│ Get Laravel Auth Token  │
└────────┬────────────────┘
         │
         ▼
┌──────────────────────────┐
│ GET /zego/messaging/token│
└────────┬─────────────────┘
         │
         ▼
┌─────────────────────────────┐
│ Initialize ZIM SDK          │
│ ZIM.create(appID)           │
│ ZIM.login(userInfo, token)  │
└────────┬────────────────────┘
         │
         ▼
┌──────────────────────────────┐
│ GET /zego/messaging/contacts │
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────────┐
│ Display Contact List │
└────────┬─────────────┘
         │
         ▼
┌─────────────────────────┐
│ Start Messaging with ZIM│
└─────────────────────────┘
```

---

## Code Examples

### Flutter/Dart

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:zego_zim/zego_zim.dart';

class ZegoMessagingService {
  final String baseUrl = 'http://127.0.0.1:8000/api';
  String? sanctumToken;

  // 1. Get ZegoCloud Token
  Future<Map<String, dynamic>> getZegoToken() async {
    final response = await http.post(
      Uri.parse('$baseUrl/zego/messaging/token'),
      headers: {
        'Authorization': 'Bearer $sanctumToken',
        'Content-Type': 'application/json',
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return data['data'];
    } else {
      throw Exception('Failed to get token');
    }
  }

  // 2. Initialize ZIM
  Future<void> initializeZIM() async {
    try {
      // Get token from API
      final tokenData = await getZegoToken();

      final appId = tokenData['app_id'];
      final token = tokenData['token'];
      final userId = tokenData['user_id'];
      final userName = tokenData['user_name'];

      // Create ZIM instance
      await ZIM.create(appID: appId);

      // Login to ZIM
      final userInfo = ZIMUserInfo()
        ..userID = userId
        ..userName = userName;

      await ZIM.getInstance()!.login(userInfo, token);

      print('✅ ZIM initialized successfully');
    } catch (e) {
      print('❌ ZIM initialization failed: $e');
    }
  }

  // 3. Get Contacts
  Future<List<dynamic>> getContacts({
    String? search,
    int limit = 100,
    int offset = 0,
  }) async {
    final queryParams = {
      if (search != null) 'search': search,
      'limit': limit.toString(),
      'offset': offset.toString(),
    };

    final uri = Uri.parse('$baseUrl/zego/messaging/contacts')
        .replace(queryParameters: queryParams);

    final response = await http.get(
      uri,
      headers: {
        'Authorization': 'Bearer $sanctumToken',
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return data['data']['contacts'];
    } else {
      throw Exception('Failed to load contacts');
    }
  }

  // 4. Update Online Status
  Future<void> updateOnlineStatus(bool isOnline) async {
    await http.post(
      Uri.parse('$baseUrl/zego/messaging/update-online-status'),
      headers: {
        'Authorization': 'Bearer $sanctumToken',
        'Content-Type': 'application/json',
      },
      body: json.encode({'is_online': isOnline}),
    );
  }

  // 5. Send Message using ZIM SDK
  Future<void> sendMessage(String toUserId, String messageText) async {
    final message = ZIMTextMessage(message: messageText);

    final config = ZIMMessageSendConfig()
      ..priority = ZIMMessagePriority.medium;

    try {
      final result = await ZIM.getInstance()!.sendPeerMessage(
        message,
        toUserId,
        config,
      );
      print('✅ Message sent: ${result.message.messageID}');
    } catch (e) {
      print('❌ Failed to send message: $e');
    }
  }
}

// Usage Example
void main() async {
  final service = ZegoMessagingService();
  service.sanctumToken = 'your_sanctum_token_here';

  // Initialize
  await service.initializeZIM();

  // Get contacts
  final contacts = await service.getContacts(limit: 50);
  print('Contacts: $contacts');

  // Send message
  await service.sendMessage('123', 'Hello from Flutter!');

  // Update status
  await service.updateOnlineStatus(true);
}
```

---

### React Native / JavaScript

```javascript
import axios from 'axios';
import ZIM from 'zego-zim-react-native';

const BASE_URL = 'http://127.0.0.1:8000/api';
let sanctumToken = '';

// 1. Setup Axios Instance
const api = axios.create({
  baseURL: BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Add token to all requests
api.interceptors.request.use(config => {
  if (sanctumToken) {
    config.headers.Authorization = `Bearer ${sanctumToken}`;
  }
  return config;
});

// 2. Get ZegoCloud Token
async function getZegoToken() {
  try {
    const response = await api.post('/zego/messaging/token');
    return response.data.data;
  } catch (error) {
    console.error('Error getting token:', error);
    throw error;
  }
}

// 3. Initialize ZIM
async function initializeZIM() {
  try {
    const tokenData = await getZegoToken();

    const { app_id, token, user_id, user_name } = tokenData;

    // Create ZIM instance
    ZIM.create({ appID: app_id });

    // Login
    const userInfo = { userID: user_id, userName: user_name };
    await ZIM.getInstance().login(userInfo, token);

    console.log('✅ ZIM initialized successfully');

    // Setup message listener
    ZIM.getInstance().on('receivePeerMessage', (zim, { messageList, fromConversationID }) => {
      console.log('📨 Message received:', messageList);
      // Handle incoming messages
    });

  } catch (error) {
    console.error('❌ ZIM initialization failed:', error);
  }
}

// 4. Get Contacts
async function getContacts(params = {}) {
  try {
    const response = await api.get('/zego/messaging/contacts', { params });
    return response.data.data.contacts;
  } catch (error) {
    console.error('Error getting contacts:', error);
    throw error;
  }
}

// 5. Search Users
async function searchUsers(query) {
  try {
    const response = await api.post('/zego/messaging/search-users', {
      query,
      limit: 20,
    });
    return response.data.data.results;
  } catch (error) {
    console.error('Error searching users:', error);
    throw error;
  }
}

// 6. Update Online Status
async function updateOnlineStatus(isOnline) {
  try {
    await api.post('/zego/messaging/update-online-status', {
      is_online: isOnline,
    });
  } catch (error) {
    console.error('Error updating status:', error);
  }
}

// 7. Send Message
async function sendMessage(toUserId, messageText) {
  try {
    const message = { type: 1, message: messageText };
    const config = { priority: 2 };

    const result = await ZIM.getInstance().sendMessage(
      message,
      toUserId,
      0, // conversationType: 0 = peer (one-to-one)
      config
    );

    console.log('✅ Message sent:', result);
  } catch (error) {
    console.error('❌ Send failed:', error);
  }
}

// Usage
export default {
  setToken: (token) => { sanctumToken = token; },
  initializeZIM,
  getContacts,
  searchUsers,
  updateOnlineStatus,
  sendMessage,
};
```

---

### Swift (iOS)

```swift
import Foundation
import ZIM

class ZegoMessagingService {
    static let shared = ZegoMessagingService()

    private let baseURL = "http://127.0.0.1:8000/api"
    private var sanctumToken: String?

    // 1. Get ZegoCloud Token
    func getZegoToken(completion: @escaping (Result<[String: Any], Error>) -> Void) {
        guard let token = sanctumToken else {
            completion(.failure(NSError(domain: "", code: 401)))
            return
        }

        let url = URL(string: "\(baseURL)/zego/messaging/token")!
        var request = URLRequest(url: url)
        request.httpMethod = "POST"
        request.setValue("Bearer \(token)", forHTTPHeaderField: "Authorization")
        request.setValue("application/json", forHTTPHeaderField: "Content-Type")

        URLSession.shared.dataTask(with: request) { data, response, error in
            if let error = error {
                completion(.failure(error))
                return
            }

            guard let data = data,
                  let json = try? JSONSerialization.jsonObject(with: data) as? [String: Any],
                  let responseData = json["data"] as? [String: Any] else {
                completion(.failure(NSError(domain: "", code: 500)))
                return
            }

            completion(.success(responseData))
        }.resume()
    }

    // 2. Initialize ZIM
    func initializeZIM() {
        getZegoToken { [weak self] result in
            switch result {
            case .success(let data):
                guard let appID = data["app_id"] as? UInt32,
                      let token = data["token"] as? String,
                      let userID = data["user_id"] as? String,
                      let userName = data["user_name"] as? String else {
                    return
                }

                // Create ZIM instance
                ZIM.create(with: appID)

                // Login
                let userInfo = ZIMUserInfo()
                userInfo.userID = userID
                userInfo.userName = userName

                ZIM.shared()?.login(with: userInfo, token: token) { error in
                    if let error = error {
                        print("❌ ZIM login failed: \(error)")
                    } else {
                        print("✅ ZIM initialized successfully")
                        self?.setupEventHandlers()
                    }
                }

            case .failure(let error):
                print("❌ Failed to get token: \(error)")
            }
        }
    }

    // 3. Get Contacts
    func getContacts(completion: @escaping (Result<[[String: Any]], Error>) -> Void) {
        guard let token = sanctumToken else {
            completion(.failure(NSError(domain: "", code: 401)))
            return
        }

        let url = URL(string: "\(baseURL)/zego/messaging/contacts")!
        var request = URLRequest(url: url)
        request.setValue("Bearer \(token)", forHTTPHeaderField: "Authorization")

        URLSession.shared.dataTask(with: request) { data, response, error in
            if let error = error {
                completion(.failure(error))
                return
            }

            guard let data = data,
                  let json = try? JSONSerialization.jsonObject(with: data) as? [String: Any],
                  let responseData = json["data"] as? [String: Any],
                  let contacts = responseData["contacts"] as? [[String: Any]] else {
                completion(.failure(NSError(domain: "", code: 500)))
                return
            }

            completion(.success(contacts))
        }.resume()
    }

    // 4. Setup Event Handlers
    private func setupEventHandlers() {
        // Listen for messages
        ZIM.shared()?.setEventHandler(self)
    }

    // 5. Send Message
    func sendMessage(to userID: String, message: String) {
        let textMessage = ZIMTextMessage(message: message)
        let config = ZIMMessageSendConfig()
        config.priority = .medium

        ZIM.shared()?.sendPeerMessage(textMessage, toUserID: userID, config: config) { message, error in
            if let error = error {
                print("❌ Send failed: \(error)")
            } else {
                print("✅ Message sent")
            }
        }
    }
}

// MARK: - ZIMEventHandler
extension ZegoMessagingService: ZIMEventHandler {
    func zim(_ zim: ZIM, receivePeerMessage messageList: [ZIMMessage], fromUserID: String) {
        print("📨 Received messages from \(fromUserID)")
        // Handle incoming messages
    }
}
```

---

### Kotlin (Android)

```kotlin
import okhttp3.*
import okhttp3.MediaType.Companion.toMediaType
import okhttp3.RequestBody.Companion.toRequestBody
import org.json.JSONObject
import im.zego.zim.ZIM
import im.zego.zim.callback.ZIMLoggedInCallback
import im.zego.zim.entity.ZIMUserInfo

class ZegoMessagingService {
    private val baseUrl = "http://127.0.0.1:8000/api"
    private var sanctumToken: String? = null
    private val client = OkHttpClient()
    private val JSON = "application/json; charset=utf-8".toMediaType()

    // 1. Get ZegoCloud Token
    fun getZegoToken(callback: (Result<JSONObject>) -> Unit) {
        val request = Request.Builder()
            .url("$baseUrl/zego/messaging/token")
            .post("".toRequestBody(JSON))
            .addHeader("Authorization", "Bearer $sanctumToken")
            .build()

        client.newCall(request).enqueue(object : Callback {
            override fun onResponse(call: Call, response: Response) {
                val body = response.body?.string()
                val json = JSONObject(body ?: "")
                val data = json.getJSONObject("data")
                callback(Result.success(data))
            }

            override fun onFailure(call: Call, e: IOException) {
                callback(Result.failure(e))
            }
        })
    }

    // 2. Initialize ZIM
    fun initializeZIM() {
        getZegoToken { result ->
            result.onSuccess { data ->
                val appId = data.getLong("app_id")
                val token = data.getString("token")
                val userId = data.getString("user_id")
                val userName = data.getString("user_name")

                // Create ZIM instance
                ZIM.create(appId.toInt(), application)

                // Login
                val userInfo = ZIMUserInfo()
                userInfo.userID = userId
                userInfo.userName = userName

                ZIM.getInstance()?.login(userInfo, token, object : ZIMLoggedInCallback {
                    override fun onLoggedIn(errorInfo: ZIMError?) {
                        if (errorInfo?.code == ZIMErrorCode.SUCCESS) {
                            println("✅ ZIM initialized successfully")
                            setupEventHandlers()
                        } else {
                            println("❌ ZIM login failed: ${errorInfo?.message}")
                        }
                    }
                })
            }
        }
    }

    // 3. Get Contacts
    fun getContacts(callback: (Result<List<JSONObject>>) -> Unit) {
        val request = Request.Builder()
            .url("$baseUrl/zego/messaging/contacts")
            .get()
            .addHeader("Authorization", "Bearer $sanctumToken")
            .build()

        client.newCall(request).enqueue(object : Callback {
            override fun onResponse(call: Call, response: Response) {
                val body = response.body?.string()
                val json = JSONObject(body ?: "")
                val data = json.getJSONObject("data")
                val contactsArray = data.getJSONArray("contacts")

                val contacts = mutableListOf<JSONObject>()
                for (i in 0 until contactsArray.length()) {
                    contacts.add(contactsArray.getJSONObject(i))
                }

                callback(Result.success(contacts))
            }

            override fun onFailure(call: Call, e: IOException) {
                callback(Result.failure(e))
            }
        })
    }

    // 4. Send Message
    fun sendMessage(toUserId: String, messageText: String) {
        val message = ZIMTextMessage(messageText)
        val config = ZIMMessageSendConfig()
        config.priority = ZIMMessagePriority.MEDIUM

        ZIM.getInstance()?.sendPeerMessage(message, toUserId, config,
            object : ZIMMessageSentCallback {
                override fun onMessageSent(message: ZIMMessage, errorInfo: ZIMError?) {
                    if (errorInfo?.code == ZIMErrorCode.SUCCESS) {
                        println("✅ Message sent")
                    } else {
                        println("❌ Send failed: ${errorInfo?.message}")
                    }
                }
            })
    }

    companion object {
        val instance = ZegoMessagingService()
    }
}
```

---

## Error Handling

### Standard Error Response Format

```json
{
    "success": false,
    "message": "Error message here",
    "data": null,
    "errors": {
        "field_name": ["Error detail"]
    }
}
```

### Common Error Codes

| HTTP Code | Meaning | Solution |
|-----------|---------|----------|
| 400 | Bad Request | Check request parameters |
| 401 | Unauthorized | Token expired or invalid - re-login |
| 404 | Not Found | Resource doesn't exist |
| 422 | Validation Error | Check `errors` field for details |
| 500 | Server Error | Contact backend team |

### Handling Token Expiration

```dart
// Flutter example
try {
  await api.get('/zego/messaging/contacts');
} catch (e) {
  if (e.response?.statusCode == 401) {
    // Token expired - re-login
    await reLogin();
  }
}
```

---

## Rate Limiting

**Current Limits:** None (implement as needed)

**Recommended Limits:**
- Token generation: 10 requests/minute
- Get contacts: 60 requests/minute
- Search users: 30 requests/minute
- Update status: 20 requests/minute

---

## Testing

### Using cURL

```bash
# 1. Login
curl -X POST http://127.0.0.1:8000/api/auth/custom-login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# 2. Get ZegoCloud Token
curl -X POST http://127.0.0.1:8000/api/zego/messaging/token \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 3. Get Contacts
curl -X GET "http://127.0.0.1:8000/api/zego/messaging/contacts?limit=10" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 4. Search Users
curl -X POST http://127.0.0.1:8000/api/zego/messaging/search-users \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"query":"john","limit":10}'

# 5. Update Online Status
curl -X POST http://127.0.0.1:8000/api/zego/messaging/update-online-status \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"is_online":true}'
```

### Using Postman

Import the Postman collection (see `POSTMAN_COLLECTION.json` in the next section).

---

## Quick Start Checklist

- [ ] Get Laravel Sanctum token from login API
- [ ] Call `/zego/messaging/token` to get ZegoCloud token
- [ ] Initialize ZIM SDK in your app
- [ ] Login to ZIM with received token
- [ ] Fetch contacts using `/zego/messaging/contacts`
- [ ] Display contacts in your UI
- [ ] Implement send/receive messages using ZIM SDK
- [ ] Update online status when app state changes
- [ ] Handle token expiration (re-login)
- [ ] Test with at least 2 devices/emulators

---

## Support & Contact

**API Issues:** Check Laravel logs at `storage/logs/laravel.log`
**ZIM SDK Issues:** Refer to [ZegoCloud Documentation](https://www.zegocloud.com/docs/zim-web/introduction/overview)

**Backend Developer:** [Your contact info]
**API Version:** 1.0.0
**Last Updated:** December 2025

---

## Appendix

### ZegoCloud SDK Installation

**Flutter:**
```yaml
dependencies:
  zego_zim: ^2.x.x
```

**React Native:**
```bash
npm install zego-zim-react-native
```

**iOS:**
```ruby
pod 'ZIM'
```

**Android:**
```gradle
implementation 'im.zego:zim:2.x.x'
```

### Useful Links

- [ZIM Flutter SDK](https://pub.dev/packages/zego_zim)
- [ZIM React Native SDK](https://www.npmjs.com/package/zego-zim-react-native)
- [ZIM iOS SDK](https://www.zegocloud.com/docs/zim-ios/overview)
- [ZIM Android SDK](https://www.zegocloud.com/docs/zim-android/overview)

---

**End of Documentation**
