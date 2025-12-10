# Mobile App Integration Guide - ZegoCloud Calling System

## Overview

This guide will help you integrate the ZegoCloud audio/video calling system with your mobile application (iOS/Android). The system supports cross-platform calling between web and mobile apps with real-time call state synchronization.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Architecture Overview](#architecture-overview)
3. [Authentication](#authentication)
4. [API Endpoints](#api-endpoints)
5. [WebSocket Integration](#websocket-integration)
6. [Push Notifications](#push-notifications)
7. [ZegoCloud SDK Integration](#zegocloud-sdk-integration)
8. [Call Flow](#call-flow)
9. [Code Examples](#code-examples)
10. [Troubleshooting](#troubleshooting)

---

## Prerequisites

### Required Credentials

1. **API Base URL**: Your backend API URL (e.g., `https://yourdomain.com/api`)
2. **ZegoCloud Credentials**:
   - App ID
   - Server Secret
3. **Push Notification Credentials**:
   - **For Android**: Firebase Cloud Messaging (FCM) Server Key
   - **For iOS**: Apple Push Notification service (APNs) credentials

### Required SDKs

#### iOS
```bash
# Add to your Podfile
pod 'ZegoExpressEngine'
pod 'Alamofire'  # For API calls
pod 'Starscream'  # For WebSocket
```

#### Android
```gradle
// Add to your build.gradle
dependencies {
    implementation 'com.github.zegolibrary:express-video:+'
    implementation 'com.squareup.retrofit2:retrofit:2.9.0'
    implementation 'com.squareup.retrofit2:converter-gson:2.9.0'
    implementation 'com.google.firebase:firebase-messaging:23.0.0'
    implementation 'io.socket:socket.io-client:2.1.0'
}
```

---

## Architecture Overview

### Communication Flow

```
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│             │         │             │         │             │
│   Web App   │◄───────►│   Backend   │◄───────►│  Mobile App │
│             │         │   Server    │         │             │
└─────────────┘         └─────────────┘         └─────────────┘
      │                       │                        │
      │                       │                        │
      ▼                       ▼                        ▼
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│  Laravel    │         │  Laravel    │         │   Push      │
│  Echo       │         │  Websocket  │         │   Notif.    │
│  (Pusher)   │         │  Server     │         │   Service   │
└─────────────┘         └─────────────┘         └─────────────┘
                              │
                              ▼
                        ┌─────────────┐
                        │  ZegoCloud  │
                        │   Server    │
                        └─────────────┘
```

### Call State Flow

1. **Call Initiated**: Caller initiates call → Backend creates call record → Push notification sent to receiver → WebSocket broadcast
2. **Call Accepted**: Receiver accepts → Both parties join ZegoCloud room → WebSocket broadcast
3. **Call Rejected**: Receiver rejects → Caller notified via WebSocket and push → Call ends
4. **Call Ended**: Either party ends → Other party notified via WebSocket and push → Call record updated

---

## Authentication

### 1. User Login

**Endpoint**: `POST /api/auth/custom-login`

**Request**:
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response**:
```json
{
  "success": true,
  "token": "1|abcdefghijklmnopqrstuvwxyz123456",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "user_type": "employee"
  }
}
```

### 2. Register Device for Push Notifications

**Endpoint**: `POST /api/mobile/call/register-device`

**Headers**:
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request**:
```json
{
  "device_token": "fcm_device_token_here",
  "device_platform": "android"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Device registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "device_platform": "android",
    "is_online": true
  }
}
```

---

## API Endpoints

### Base URL
```
https://yourdomain.com/api/mobile/call
```

### Authentication
All endpoints require Bearer token authentication:
```
Authorization: Bearer {your_access_token}
```

### Endpoints Reference

#### 1. Register Device
- **POST** `/register-device`
- **Purpose**: Register device token for push notifications
- **Required**: `device_token`, `device_platform` (ios/android)

#### 2. Update Online Status
- **POST** `/update-online-status`
- **Purpose**: Update user's online status
- **Required**: `is_online` (boolean)

#### 3. Initiate Call
- **POST** `/initiate`
- **Purpose**: Start a new call
- **Required**: `receiver_id`, `call_type` (audio/video)
- **Response**:
```json
{
  "success": true,
  "call": {
    "id": 123,
    "caller_id": 1,
    "receiver_id": 2,
    "room_id": "room_xyz123_1638475647",
    "call_type": "video",
    "status": "initiated"
  },
  "room_id": "room_xyz123_1638475647",
  "zegocloud_config": {
    "app_id": "1234567890",
    "room_id": "room_xyz123_1638475647",
    "user_id": "1",
    "user_name": "John Doe"
  }
}
```

#### 4. Accept Call
- **POST** `/{callId}/accept`
- **Purpose**: Accept an incoming call
- **Response**: Returns ZegoCloud configuration for joining the room

#### 5. Reject Call
- **POST** `/{callId}/reject`
- **Purpose**: Reject an incoming call

#### 6. End Call
- **POST** `/{callId}/end`
- **Purpose**: End an active call
- **Response**:
```json
{
  "success": true,
  "message": "Call ended",
  "duration": 125
}
```

#### 7. Get Active Calls
- **GET** `/active-calls`
- **Purpose**: Get list of active calls for the user

#### 8. Get Call History
- **GET** `/call-history?per_page=20`
- **Purpose**: Get paginated call history

#### 9. Get Call Details
- **GET** `/{callId}/details`
- **Purpose**: Get details of a specific call

#### 10. Check User Availability
- **GET** `/user/{userId}/availability`
- **Purpose**: Check if a user is available for calls
- **Response**:
```json
{
  "success": true,
  "user": {
    "id": 2,
    "name": "Jane Doe",
    "is_online": true,
    "last_seen": "2023-12-01T15:30:00Z"
  },
  "is_available": true,
  "has_active_call": false
}
```

#### 11. Generate Token
- **POST** `/generate-token`
- **Purpose**: Generate ZegoCloud configuration
- **Required**: `room_id`

---

## WebSocket Integration

### Laravel Echo Setup

The backend uses Laravel broadcasting with Pusher. You need to listen to these channels:

#### Private Channel
```
private-user.{userId}
```

#### Events to Listen

1. **call.initiated**: When someone calls you
2. **call.accepted**: When your call is accepted
3. **call.rejected**: When your call is rejected
4. **call.ended**: When the call ends

### Implementation Example (React Native with Socket.IO)

```javascript
import io from 'socket.io-client';

// Connect to WebSocket
const socket = io('https://yourdomain.com', {
  auth: {
    token: userToken
  },
  transports: ['websocket']
});

// Listen to private channel
const userId = getCurrentUserId();
socket.on(`private-user.${userId}`, (data) => {
  console.log('Received event:', data);

  switch(data.event) {
    case 'call.initiated':
      handleIncomingCall(data.data);
      break;
    case 'call.accepted':
      handleCallAccepted(data.data);
      break;
    case 'call.rejected':
      handleCallRejected(data.data);
      break;
    case 'call.ended':
      handleCallEnded(data.data);
      break;
  }
});
```

### iOS (Swift) WebSocket Example

```swift
import Starscream

class WebSocketManager: WebSocketDelegate {
    var socket: WebSocket!

    func connect(token: String, userId: Int) {
        var request = URLRequest(url: URL(string: "wss://yourdomain.com")!)
        request.timeoutInterval = 5
        socket = WebSocket(request: request)
        socket.delegate = self
        socket.connect()
    }

    func didReceive(event: WebSocketEvent, client: WebSocket) {
        switch event {
        case .text(let string):
            handleMessage(string)
        default:
            break
        }
    }

    func handleMessage(_ message: String) {
        // Parse and handle incoming events
        if let data = message.data(using: .utf8) {
            let json = try? JSONSerialization.jsonObject(with: data)
            // Handle call events
        }
    }
}
```

### Android (Kotlin) WebSocket Example

```kotlin
import io.socket.client.IO
import io.socket.client.Socket
import org.json.JSONObject

class WebSocketManager(private val token: String, private val userId: Int) {
    private var socket: Socket? = null

    fun connect() {
        val opts = IO.Options()
        opts.auth = mapOf("token" to token)
        opts.transports = arrayOf("websocket")

        socket = IO.socket("https://yourdomain.com", opts)

        socket?.on("private-user.$userId") { args ->
            val data = args[0] as JSONObject
            handleCallEvent(data)
        }

        socket?.connect()
    }

    private fun handleCallEvent(data: JSONObject) {
        when (data.getString("event")) {
            "call.initiated" -> handleIncomingCall(data)
            "call.accepted" -> handleCallAccepted(data)
            "call.rejected" -> handleCallRejected(data)
            "call.ended" -> handleCallEnded(data)
        }
    }
}
```

---

## Push Notifications

### Android (FCM) Setup

#### 1. Add Firebase to Your Project
Follow the official Firebase setup guide for Android.

#### 2. Handle Incoming Call Notifications

```kotlin
class MyFirebaseMessagingService : FirebaseMessagingService() {

    override fun onMessageReceived(remoteMessage: RemoteMessage) {
        super.onMessageReceived(remoteMessage)

        val data = remoteMessage.data

        when (data["notification_type"]) {
            "incoming_call" -> showIncomingCallNotification(data)
            "call_accepted" -> handleCallAccepted(data)
            "call_rejected" -> handleCallRejected(data)
            "call_ended" -> handleCallEnded(data)
        }
    }

    private fun showIncomingCallNotification(data: Map<String, String>) {
        val callId = data["call_id"]
        val callerName = data["caller_name"]
        val callType = data["call_type"]

        // Show full-screen notification with Accept/Reject buttons
        val intent = Intent(this, IncomingCallActivity::class.java).apply {
            putExtra("call_id", callId)
            putExtra("caller_name", callerName)
            putExtra("call_type", callType)
            flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TOP
        }

        startActivity(intent)
    }

    override fun onNewToken(token: String) {
        super.onNewToken(token)
        // Send token to server
        registerDeviceToken(token)
    }
}
```

#### 3. AndroidManifest.xml

```xml
<service
    android:name=".MyFirebaseMessagingService"
    android:exported="false">
    <intent-filter>
        <action android:name="com.google.firebase.MESSAGING_EVENT" />
    </intent-filter>
</service>
```

### iOS (APNs) Setup

#### 1. Enable Push Notifications in Xcode

1. Go to your project settings
2. Select your target
3. Click on "Signing & Capabilities"
4. Add "Push Notifications" capability

#### 2. Request Notification Permission

```swift
import UserNotifications

class NotificationManager: NSObject, UNUserNotificationCenterDelegate {

    func requestPermission() {
        UNUserNotificationCenter.current().requestAuthorization(options: [.alert, .sound, .badge]) { granted, error in
            if granted {
                DispatchQueue.main.async {
                    UIApplication.shared.registerForRemoteNotifications()
                }
            }
        }
    }

    func application(_ application: UIApplication,
                     didRegisterForRemoteNotificationsWithDeviceToken deviceToken: Data) {
        let token = deviceToken.map { String(format: "%02.2hhx", $0) }.joined()
        // Register token with server
        registerDeviceToken(token: token)
    }
}
```

#### 3. Handle Incoming Notifications

```swift
extension NotificationManager {

    func userNotificationCenter(_ center: UNUserNotificationCenter,
                                willPresent notification: UNNotification,
                                withCompletionHandler completionHandler: @escaping (UNNotificationPresentationOptions) -> Void) {

        let userInfo = notification.request.content.userInfo

        if let notificationType = userInfo["notification_type"] as? String {
            switch notificationType {
            case "incoming_call":
                showIncomingCallScreen(userInfo)
            case "call_accepted":
                handleCallAccepted(userInfo)
            case "call_rejected":
                handleCallRejected(userInfo)
            case "call_ended":
                handleCallEnded(userInfo)
            default:
                break
            }
        }

        completionHandler([.banner, .sound])
    }

    func userNotificationCenter(_ center: UNUserNotificationCenter,
                                didReceive response: UNNotificationResponse,
                                withCompletionHandler completionHandler: @escaping () -> Void) {

        let userInfo = response.notification.request.content.userInfo

        // Handle notification tap
        if let callId = userInfo["call_id"] as? String {
            openCallScreen(callId: callId)
        }

        completionHandler()
    }
}
```

---

## ZegoCloud SDK Integration

### Android Implementation

#### 1. Initialize ZegoCloud Engine

```kotlin
import im.zego.zegoexpress.ZegoExpressEngine
import im.zego.zegoexpress.constants.ZegoScenario

class ZegoManager(private val context: Context) {

    private var engine: ZegoExpressEngine? = null

    fun initEngine(appId: Long, appSign: String) {
        val profile = ZegoEngineProfile()
        profile.appID = appId
        profile.appSign = appSign
        profile.scenario = ZegoScenario.GENERAL
        profile.application = context.applicationContext as Application

        engine = ZegoExpressEngine.createEngine(profile, null)
    }

    fun joinRoom(roomId: String, userId: String, userName: String) {
        val user = ZegoUser(userId)
        user.userName = userName

        val roomConfig = ZegoRoomConfig()
        engine?.loginRoom(roomId, user, roomConfig)
    }

    fun startPublishingStream(streamId: String) {
        engine?.startPublishingStream(streamId)
    }

    fun startPlayingStream(streamId: String, view: TextureView) {
        engine?.startPlayingStream(streamId, ZegoCanvas(view))
    }

    fun leaveRoom(roomId: String) {
        engine?.logoutRoom(roomId)
    }

    fun destroyEngine() {
        ZegoExpressEngine.destroyEngine(null)
    }
}
```

#### 2. Video Call Activity

```kotlin
class VideoCallActivity : AppCompatActivity() {

    private lateinit var zegoManager: ZegoManager
    private lateinit var localView: TextureView
    private lateinit var remoteView: TextureView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_video_call)

        localView = findViewById(R.id.local_view)
        remoteView = findViewById(R.id.remote_view)

        val callId = intent.getStringExtra("call_id")
        val roomId = intent.getStringExtra("room_id")
        val appId = intent.getLongExtra("app_id", 0)
        val appSign = intent.getStringExtra("app_sign") ?: ""

        zegoManager = ZegoManager(this)
        zegoManager.initEngine(appId, appSign)

        // Join room
        val userId = getUserId().toString()
        val userName = getUserName()
        zegoManager.joinRoom(roomId, userId, userName)

        // Start publishing
        zegoManager.startPublishingStream("stream_$userId")

        // Set event listeners
        setupZegoEventListeners()
    }

    private fun setupZegoEventListeners() {
        // Listen for remote user joining
        // Listen for remote stream
        // Handle call events
    }

    override fun onDestroy() {
        super.onDestroy()
        zegoManager.leaveRoom(roomId)
        zegoManager.destroyEngine()
    }
}
```

### iOS Implementation

#### 1. Initialize ZegoCloud Engine

```swift
import ZegoExpressEngine

class ZegoManager: NSObject {

    var engine: ZegoExpressEngine?

    func initEngine(appId: UInt32, appSign: String) {
        let profile = ZegoEngineProfile()
        profile.appID = appId
        profile.appSign = appSign
        profile.scenario = .general

        engine = ZegoExpressEngine.createEngine(with: profile, eventHandler: self)
    }

    func joinRoom(roomId: String, userId: String, userName: String) {
        let user = ZegoUser(userID: userId)
        user.userName = userName

        let roomConfig = ZegoRoomConfig()
        engine?.loginRoom(roomId, user: user, config: roomConfig)
    }

    func startPublishingStream(streamId: String, view: UIView) {
        let canvas = ZegoCanvas(view: view)
        engine?.startPreview(canvas)
        engine?.startPublishingStream(streamId)
    }

    func startPlayingStream(streamId: String, view: UIView) {
        let canvas = ZegoCanvas(view: view)
        engine?.startPlayingStream(streamId, canvas: canvas)
    }

    func leaveRoom(roomId: String) {
        engine?.logoutRoom(roomId)
    }

    func destroyEngine() {
        ZegoExpressEngine.destroy(nil)
    }
}

extension ZegoManager: ZegoEventHandler {
    // Implement event handlers
    func onRoomUserUpdate(_ updateType: ZegoUpdateType, userList: [ZegoUser], roomID: String) {
        // Handle user joining/leaving
    }

    func onRoomStreamUpdate(_ updateType: ZegoUpdateType, streamList: [ZegoStream], extendedData: [AnyHashable : Any]?, roomID: String) {
        // Handle stream updates
    }
}
```

#### 2. Video Call View Controller

```swift
class VideoCallViewController: UIViewController {

    var zegoManager: ZegoManager!
    var localView: UIView!
    var remoteView: UIView!

    var callId: String!
    var roomId: String!

    override func viewDidLoad() {
        super.viewDidLoad()

        setupViews()

        // Initialize Zego
        zegoManager = ZegoManager()
        zegoManager.initEngine(appId: appId, appSign: appSign)

        // Join room
        let userId = String(getUserId())
        let userName = getUserName()
        zegoManager.joinRoom(roomId: roomId, userId: userId, userName: userName)

        // Start publishing
        zegoManager.startPublishingStream(streamId: "stream_\(userId)", view: localView)
    }

    deinit {
        zegoManager.leaveRoom(roomId: roomId)
        zegoManager.destroyEngine()
    }
}
```

---

## Call Flow

### Complete Call Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                         Call Initiation                              │
└─────────────────────────────────────────────────────────────────────┘

Caller (Web/Mobile)                Backend                  Receiver (Mobile)
       │                              │                              │
       │  POST /mobile/call/initiate  │                              │
       │─────────────────────────────>│                              │
       │                              │                              │
       │         Call Created         │                              │
       │<─────────────────────────────│                              │
       │                              │                              │
       │                              │  Push Notification          │
       │                              │────────────────────────────>│
       │                              │                              │
       │                              │  WebSocket Event            │
       │                              │────────────────────────────>│
       │                              │   (call.initiated)           │
       │                              │                              │
       │                              │                              │
       │                      Show Incoming Call Screen              │
       │                              │                              │

┌─────────────────────────────────────────────────────────────────────┐
│                         Call Acceptance                              │
└─────────────────────────────────────────────────────────────────────┘

       │                              │                              │
       │                              │  POST /mobile/call/123/accept│
       │                              │<─────────────────────────────│
       │                              │                              │
       │  WebSocket Event            │         Call Accepted         │
       │<─────────────────────────────│─────────────────────────────>│
       │   (call.accepted)            │                              │
       │                              │                              │
       │  Join ZegoCloud Room         │  Join ZegoCloud Room         │
       │─────────────────────────────────────────────────────────────│
       │                                                              │
       │                    Video/Audio Streaming                     │
       │<────────────────────────────────────────────────────────────>│
       │                                                              │

┌─────────────────────────────────────────────────────────────────────┐
│                         Call Rejection                               │
└─────────────────────────────────────────────────────────────────────┘

       │                              │                              │
       │                              │  POST /mobile/call/123/reject│
       │                              │<─────────────────────────────│
       │                              │                              │
       │  WebSocket Event            │         Call Rejected         │
       │<─────────────────────────────│─────────────────────────────>│
       │   (call.rejected)            │                              │
       │                              │                              │
       │  Show "Call Declined"        │                              │
       │                              │                              │

┌─────────────────────────────────────────────────────────────────────┐
│                           Call Ending                                │
└─────────────────────────────────────────────────────────────────────┘

       │                              │                              │
       │  POST /mobile/call/123/end   │                              │
       │─────────────────────────────>│                              │
       │                              │                              │
       │         Call Ended           │  WebSocket Event             │
       │<─────────────────────────────│────────────────────────────>│
       │                              │   (call.ended)               │
       │                              │                              │
       │  Leave ZegoCloud Room        │  Leave ZegoCloud Room        │
       │                              │                              │
```

### Detailed Step-by-Step Flow

#### 1. User Makes a Call from Web

```javascript
// Web calls the endpoint
fetch('/call/initiate', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken
  },
  body: JSON.stringify({
    receiver_id: 2,
    call_type: 'video'
  })
});
```

#### 2. Backend Processes Call

- Creates call record in database
- Broadcasts `CallInitiated` event via WebSocket
- Sends push notification to receiver's mobile device

#### 3. Mobile Receives Push Notification

```kotlin
// Android receives FCM notification
override fun onMessageReceived(remoteMessage: RemoteMessage) {
    val data = remoteMessage.data
    if (data["notification_type"] == "incoming_call") {
        // Show incoming call screen
        showIncomingCallActivity(
            callId = data["call_id"],
            callerName = data["caller_name"],
            callType = data["call_type"]
        )
    }
}
```

#### 4. Mobile User Accepts/Rejects Call

```kotlin
// Accept call
fun acceptCall(callId: String) {
    apiService.acceptCall(callId).enqueue(object : Callback<CallResponse> {
        override fun onResponse(call: Call<CallResponse>, response: Response<CallResponse>) {
            if (response.isSuccessful) {
                val zegoConfig = response.body()?.zegocloud_config
                joinZegoRoom(zegoConfig)
            }
        }
    })
}

// Reject call
fun rejectCall(callId: String) {
    apiService.rejectCall(callId).enqueue(object : Callback<ApiResponse> {
        override fun onResponse(call: Call<ApiResponse>, response: Response<ApiResponse>) {
            // Close incoming call screen
            finish()
        }
    })
}
```

#### 5. Web Receives WebSocket Event

```javascript
// Web listens for call status updates
Echo.private(`user.${userId}`)
  .listen('.call.accepted', (e) => {
    // Join ZegoCloud room
    joinCallRoom(e.room_id);
  })
  .listen('.call.rejected', (e) => {
    // Show rejection message
    alert('Call was declined');
  })
  .listen('.call.ended', (e) => {
    // Leave room and cleanup
    leaveCallRoom();
  });
```

---

## Code Examples

### Complete Mobile API Service

#### Android (Retrofit)

```kotlin
interface CallApiService {

    @POST("mobile/call/register-device")
    suspend fun registerDevice(
        @Body request: RegisterDeviceRequest
    ): Response<RegisterDeviceResponse>

    @POST("mobile/call/update-online-status")
    suspend fun updateOnlineStatus(
        @Body request: OnlineStatusRequest
    ): Response<ApiResponse>

    @POST("mobile/call/initiate")
    suspend fun initiateCall(
        @Body request: InitiateCallRequest
    ): Response<CallResponse>

    @POST("mobile/call/{callId}/accept")
    suspend fun acceptCall(
        @Path("callId") callId: String
    ): Response<CallResponse>

    @POST("mobile/call/{callId}/reject")
    suspend fun rejectCall(
        @Path("callId") callId: String
    ): Response<ApiResponse>

    @POST("mobile/call/{callId}/end")
    suspend fun endCall(
        @Path("callId") callId: String
    ): Response<EndCallResponse>

    @GET("mobile/call/active-calls")
    suspend fun getActiveCalls(): Response<ActiveCallsResponse>

    @GET("mobile/call/call-history")
    suspend fun getCallHistory(
        @Query("per_page") perPage: Int = 20
    ): Response<CallHistoryResponse>

    @GET("mobile/call/{callId}/details")
    suspend fun getCallDetails(
        @Path("callId") callId: String
    ): Response<CallDetailsResponse>

    @GET("mobile/call/user/{userId}/availability")
    suspend fun checkUserAvailability(
        @Path("userId") userId: Int
    ): Response<UserAvailabilityResponse>

    @POST("mobile/call/generate-token")
    suspend fun generateToken(
        @Body request: GenerateTokenRequest
    ): Response<TokenResponse>
}

// Data classes
data class RegisterDeviceRequest(
    val device_token: String,
    val device_platform: String
)

data class InitiateCallRequest(
    val receiver_id: Int,
    val call_type: String
)

data class CallResponse(
    val success: Boolean,
    val call: Call,
    val room_id: String?,
    val zegocloud_config: ZegoConfig?
)

data class ZegoConfig(
    val app_id: String,
    val room_id: String,
    val user_id: String,
    val user_name: String
)
```

#### iOS (Alamofire)

```swift
import Alamofire

class CallAPIService {

    let baseURL = "https://yourdomain.com/api/mobile/call"
    var headers: HTTPHeaders {
        return [
            "Authorization": "Bearer \(getAuthToken())",
            "Content-Type": "application/json"
        ]
    }

    func registerDevice(deviceToken: String, platform: String, completion: @escaping (Result<RegisterDeviceResponse, Error>) -> Void) {
        let parameters: [String: Any] = [
            "device_token": deviceToken,
            "device_platform": platform
        ]

        AF.request("\(baseURL)/register-device",
                   method: .post,
                   parameters: parameters,
                   encoding: JSONEncoding.default,
                   headers: headers)
            .responseDecodable(of: RegisterDeviceResponse.self) { response in
                switch response.result {
                case .success(let data):
                    completion(.success(data))
                case .failure(let error):
                    completion(.failure(error))
                }
            }
    }

    func initiateCall(receiverId: Int, callType: String, completion: @escaping (Result<CallResponse, Error>) -> Void) {
        let parameters: [String: Any] = [
            "receiver_id": receiverId,
            "call_type": callType
        ]

        AF.request("\(baseURL)/initiate",
                   method: .post,
                   parameters: parameters,
                   encoding: JSONEncoding.default,
                   headers: headers)
            .responseDecodable(of: CallResponse.self) { response in
                switch response.result {
                case .success(let data):
                    completion(.success(data))
                case .failure(let error):
                    completion(.failure(error))
                }
            }
    }

    func acceptCall(callId: String, completion: @escaping (Result<CallResponse, Error>) -> Void) {
        AF.request("\(baseURL)/\(callId)/accept",
                   method: .post,
                   headers: headers)
            .responseDecodable(of: CallResponse.self) { response in
                switch response.result {
                case .success(let data):
                    completion(.success(data))
                case .failure(let error):
                    completion(.failure(error))
                }
            }
    }

    func rejectCall(callId: String, completion: @escaping (Result<ApiResponse, Error>) -> Void) {
        AF.request("\(baseURL)/\(callId)/reject",
                   method: .post,
                   headers: headers)
            .responseDecodable(of: ApiResponse.self) { response in
                switch response.result {
                case .success(let data):
                    completion(.success(data))
                case .failure(let error):
                    completion(.failure(error))
                }
            }
    }

    func endCall(callId: String, completion: @escaping (Result<EndCallResponse, Error>) -> Void) {
        AF.request("\(baseURL)/\(callId)/end",
                   method: .post,
                   headers: headers)
            .responseDecodable(of: EndCallResponse.self) { response in
                switch response.result {
                case .success(let data):
                    completion(.success(data))
                case .failure(let error):
                    completion(.failure(error))
                }
            }
    }
}

// Models
struct CallResponse: Codable {
    let success: Bool
    let call: CallModel
    let room_id: String?
    let zegocloud_config: ZegoConfig?
}

struct ZegoConfig: Codable {
    let app_id: String
    let room_id: String
    let user_id: String
    let user_name: String
}

struct CallModel: Codable {
    let id: Int
    let caller_id: Int
    let receiver_id: Int
    let room_id: String
    let call_type: String
    let status: String
}
```

---

## Troubleshooting

### Common Issues

#### 1. Push Notifications Not Received

**Possible Causes**:
- Device token not registered properly
- FCM/APNs credentials not configured on backend
- App in background not handling notifications

**Solutions**:
```kotlin
// Android: Check if device token is registered
val token = FirebaseMessaging.getInstance().token
Log.d("FCM", "Device Token: $token")

// Ensure you register the token on app launch
registerDeviceToken(token)
```

```swift
// iOS: Check notification permissions
UNUserNotificationCenter.current().getNotificationSettings { settings in
    print("Notification settings: \(settings)")
}
```

#### 2. WebSocket Connection Fails

**Possible Causes**:
- Incorrect WebSocket URL
- Authentication token expired
- Firewall blocking WebSocket connections

**Solutions**:
```javascript
// Check WebSocket connection
socket.on('connect', () => {
    console.log('WebSocket connected');
});

socket.on('error', (error) => {
    console.error('WebSocket error:', error);
});

socket.on('disconnect', (reason) => {
    console.log('WebSocket disconnected:', reason);
    // Attempt reconnection
    socket.connect();
});
```

#### 3. ZegoCloud Room Join Fails

**Possible Causes**:
- Invalid App ID or Server Secret
- Network connectivity issues
- Room ID mismatch

**Solutions**:
```kotlin
// Android: Add error handling
engine.setEventHandler(object : IZegoEventHandler() {
    override fun onRoomStateUpdate(
        roomID: String,
        state: ZegoRoomState,
        errorCode: Int,
        extendedData: JSONObject
    ) {
        if (errorCode != 0) {
            Log.e("Zego", "Room join failed: $errorCode")
            // Handle error
        }
    }
})
```

#### 4. Call State Not Synchronized

**Possible Causes**:
- WebSocket not connected
- Event listeners not properly set up
- Broadcasting not configured on backend

**Solutions**:
- Ensure WebSocket is connected before initiating calls
- Verify Laravel Echo and broadcasting configuration
- Check that events are being broadcasted with `toOthers()`

#### 5. Audio/Video Quality Issues

**Possible Causes**:
- Poor network conditions
- Incorrect ZegoCloud stream configuration
- Device hardware limitations

**Solutions**:
```kotlin
// Android: Configure video quality
val videoConfig = ZegoVideoConfig()
videoConfig.setResolution(1280, 720)
videoConfig.fps = 30
videoConfig.bitrate = 1500
engine.setVideoConfig(videoConfig)
```

```swift
// iOS: Configure video quality
let videoConfig = ZegoVideoConfig()
videoConfig.setResolution(CGSize(width: 1280, height: 720))
videoConfig.fps = 30
videoConfig.bitrate = 1500
engine.setVideoConfig(videoConfig)
```

---

## Backend Configuration

### Environment Variables

Add these to your `.env` file:

```env
# ZegoCloud
ZEGOCLOUD_APP_ID=your_app_id
ZEGOCLOUD_SERVER_SECRET=your_server_secret

# Firebase Cloud Messaging (Android)
FCM_SERVER_KEY=your_fcm_server_key

# Apple Push Notifications (iOS)
APN_KEY_ID=your_apn_key_id
APN_TEAM_ID=your_team_id
APN_BUNDLE_ID=com.yourapp.bundle
APN_KEY_PATH=/path/to/AuthKey.p8
APN_PRODUCTION=false

# Broadcasting (Laravel Echo)
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_key
PUSHER_APP_SECRET=your_pusher_secret
PUSHER_APP_CLUSTER=your_cluster
```

### Run Migrations

```bash
php artisan migrate
```

This will create the necessary columns in the `users` table:
- `device_token`
- `device_platform`
- `is_online`
- `last_seen`

---

## Support & Resources

### Official Documentation

- **ZegoCloud**: https://docs.zegocloud.com/
- **Laravel Broadcasting**: https://laravel.com/docs/broadcasting
- **Firebase Cloud Messaging**: https://firebase.google.com/docs/cloud-messaging
- **Apple Push Notifications**: https://developer.apple.com/documentation/usernotifications

### Contact

For backend API issues, contact your backend development team.
For mobile integration support, refer to this documentation or create an issue in your project repository.

---

## Changelog

### Version 1.0.0 (2025-12-01)
- Initial release
- Cross-platform calling support (Web ↔ Mobile)
- Push notifications for incoming calls
- Real-time call state synchronization
- Call history and active call management
