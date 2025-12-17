# Mobile Developer Guide - Firebase Push Notifications

## Quick Start for Mobile Developers

This guide provides everything you need to integrate push notifications in your mobile app.

---

## 1. Firebase Configuration

### Get Your Firebase Config Files

**For Android:**
- Download `google-services.json` from: [Firebase Console](https://console.firebase.google.com/project/likewise-abdaf)
- Place in: `android/app/google-services.json`

**For iOS:**
- Download `GoogleService-Info.plist` from: [Firebase Console](https://console.firebase.google.com/project/likewise-abdaf)
- Place in: `ios/Runner/GoogleService-Info.plist`

---

## 2. API Endpoint for Token Registration

### Endpoint Details

**URL:** `POST http://your-api-domain.com/api/update-fcm-token`

**Headers:**
```
Content-Type: application/json
Authorization: Bearer {user_sanctum_token}
Accept: application/json
```

**Request Body:**
```json
{
  "fcm_token": "your_device_fcm_token_here"
}
```

**Success Response (200):**
```json
{
  "status": "success",
  "msg": "FCM Token updated successfully"
}
```

**Error Response (401):**
```json
{
  "message": "Unauthenticated."
}
```

---

## 3. Flutter Integration

### Step 1: Add Dependencies

```yaml
# pubspec.yaml
dependencies:
  firebase_core: ^2.24.0
  firebase_messaging: ^14.7.0
  flutter_local_notifications: ^16.3.0  # For foreground notifications
```

### Step 2: Initialize Firebase

```dart
// main.dart
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'firebase_options.dart';

// Background message handler (must be top-level function)
@pragma('vm:entry-point')
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);
  print('Background message: ${message.messageId}');
}

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);

  // Set background message handler
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  runApp(MyApp());
}
```

### Step 3: Create FCM Service

```dart
// services/fcm_service.dart
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class FCMService {
  static final FCMService _instance = FCMService._internal();
  factory FCMService() => _instance;
  FCMService._internal();

  final FirebaseMessaging _fcm = FirebaseMessaging.instance;
  final FlutterLocalNotificationsPlugin _localNotifications =
      FlutterLocalNotificationsPlugin();

  String? _fcmToken;
  String? get fcmToken => _fcmToken;

  // Initialize FCM
  Future<void> initialize() async {
    // Request permission
    NotificationSettings settings = await _fcm.requestPermission(
      alert: true,
      badge: true,
      sound: true,
      provisional: false,
    );

    if (settings.authorizationStatus == AuthorizationStatus.authorized) {
      print('FCM: User granted permission');

      // Initialize local notifications
      await _initializeLocalNotifications();

      // Get token
      await getToken();

      // Setup message handlers
      _setupMessageHandlers();

      // Listen for token refresh
      _fcm.onTokenRefresh.listen((newToken) {
        _fcmToken = newToken;
        print('FCM: Token refreshed: $newToken');
        // Update token on server
        registerTokenOnServer(newToken);
      });
    }
  }

  // Initialize local notifications for foreground
  Future<void> _initializeLocalNotifications() async {
    const androidSettings = AndroidInitializationSettings('@mipmap/ic_launcher');
    const iosSettings = DarwinInitializationSettings();

    const settings = InitializationSettings(
      android: androidSettings,
      iOS: iosSettings,
    );

    await _localNotifications.initialize(
      settings,
      onDidReceiveNotificationResponse: _onNotificationTapped,
    );
  }

  // Get FCM token
  Future<String?> getToken() async {
    try {
      _fcmToken = await _fcm.getToken();
      print('FCM Token: $_fcmToken');
      return _fcmToken;
    } catch (e) {
      print('Error getting FCM token: $e');
      return null;
    }
  }

  // Register token on server
  Future<bool> registerTokenOnServer(String token) async {
    try {
      // Replace with your actual API endpoint and token
      final response = await http.post(
        Uri.parse('http://your-api.com/api/update-fcm-token'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ${yourUserToken}', // Get from your auth service
          'Accept': 'application/json',
        },
        body: json.encode({'fcm_token': token}),
      );

      if (response.statusCode == 200) {
        print('FCM: Token registered successfully');
        return true;
      } else {
        print('FCM: Failed to register token: ${response.body}');
        return false;
      }
    } catch (e) {
      print('FCM: Error registering token: $e');
      return false;
    }
  }

  // Setup message handlers
  void _setupMessageHandlers() {
    // Foreground messages
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      print('Foreground message received');
      print('Title: ${message.notification?.title}');
      print('Body: ${message.notification?.body}');
      print('Data: ${message.data}');

      // Show local notification
      _showLocalNotification(message);
    });

    // Background/Terminated - App opened from notification
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      print('Notification tapped (background)');
      _handleNotificationTap(message.data);
    });

    // Check if app was opened from notification (terminated state)
    _fcm.getInitialMessage().then((RemoteMessage? message) {
      if (message != null) {
        print('App opened from notification (terminated)');
        _handleNotificationTap(message.data);
      }
    });
  }

  // Show local notification in foreground
  Future<void> _showLocalNotification(RemoteMessage message) async {
    const androidDetails = AndroidNotificationDetails(
      'default_channel',
      'Default Notifications',
      channelDescription: 'Default notification channel',
      importance: Importance.high,
      priority: Priority.high,
      showWhen: true,
    );

    const iosDetails = DarwinNotificationDetails(
      presentAlert: true,
      presentBadge: true,
      presentSound: true,
    );

    const details = NotificationDetails(
      android: androidDetails,
      iOS: iosDetails,
    );

    await _localNotifications.show(
      message.hashCode,
      message.notification?.title ?? 'New Notification',
      message.notification?.body ?? '',
      details,
      payload: json.encode(message.data),
    );
  }

  // Handle notification tap
  void _handleNotificationTap(Map<String, dynamic> data) {
    final notificationType = data['notification_type'] ?? '';

    switch (notificationType) {
      case 'profile_view':
        _navigateToProfileViewers(data);
        break;
      case 'new_message':
        _navigateToChat(data);
        break;
      case 'job_application':
        _navigateToJobApplications(data);
        break;
      case 'connection_request':
        _navigateToConnectionRequests(data);
        break;
      default:
        _navigateToNotifications();
    }
  }

  // Local notification tap handler
  void _onNotificationTapped(NotificationResponse response) {
    if (response.payload != null) {
      final data = json.decode(response.payload!);
      _handleNotificationTap(data);
    }
  }

  // Navigation methods (implement according to your app structure)
  void _navigateToProfileViewers(Map<String, dynamic> data) {
    // TODO: Navigate to profile viewers screen
    // Example: Get.toNamed('/profile-viewers', arguments: data);
    print('Navigate to profile viewers: $data');
  }

  void _navigateToChat(Map<String, dynamic> data) {
    // TODO: Navigate to chat screen
    print('Navigate to chat: $data');
  }

  void _navigateToJobApplications(Map<String, dynamic> data) {
    // TODO: Navigate to job applications screen
    print('Navigate to job applications: $data');
  }

  void _navigateToConnectionRequests(Map<String, dynamic> data) {
    // TODO: Navigate to connection requests screen
    print('Navigate to connection requests: $data');
  }

  void _navigateToNotifications() {
    // TODO: Navigate to notifications screen
    print('Navigate to notifications');
  }

  // Clear token on logout
  Future<void> clearToken() async {
    await _fcm.deleteToken();
    _fcmToken = null;
  }
}
```

### Step 4: Use in Your App

```dart
// After user login
class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final FCMService _fcmService = FCMService();

  Future<void> _handleLoginSuccess(String userToken) async {
    // Initialize FCM after login
    await _fcmService.initialize();

    // Get and register FCM token
    String? fcmToken = await _fcmService.getToken();
    if (fcmToken != null) {
      await _fcmService.registerTokenOnServer(fcmToken);
    }

    // Navigate to home
    Navigator.pushReplacementNamed(context, '/home');
  }

  @override
  Widget build(BuildContext context) {
    // Your login UI
    return Scaffold(
      // ...
    );
  }
}

// On logout
Future<void> _handleLogout() async {
  final FCMService fcmService = FCMService();

  // Clear FCM token
  await fcmService.clearToken();

  // Clear user session
  // ...

  // Navigate to login
  Navigator.pushReplacementNamed(context, '/login');
}
```

---

## 4. React Native Integration

### Step 1: Install Dependencies

```bash
npm install @react-native-firebase/app @react-native-firebase/messaging
# or
yarn add @react-native-firebase/app @react-native-firebase/messaging
```

### Step 2: Create FCM Service

```javascript
// services/FCMService.js
import messaging from '@react-native-firebase/messaging';
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

class FCMService {
  constructor() {
    this.fcmToken = null;
  }

  // Initialize FCM
  async initialize(navigation) {
    try {
      // Request permission
      const authStatus = await messaging().requestPermission();
      const enabled =
        authStatus === messaging.AuthorizationStatus.AUTHORIZED ||
        authStatus === messaging.AuthorizationStatus.PROVISIONAL;

      if (enabled) {
        console.log('FCM: Permission granted');

        // Get token
        await this.getToken();

        // Setup message handlers
        this.setupMessageHandlers(navigation);

        // Listen for token refresh
        this.setupTokenRefreshListener();
      }
    } catch (error) {
      console.error('FCM initialization error:', error);
    }
  }

  // Get FCM token
  async getToken() {
    try {
      this.fcmToken = await messaging().getToken();
      console.log('FCM Token:', this.fcmToken);
      return this.fcmToken;
    } catch (error) {
      console.error('Error getting FCM token:', error);
      return null;
    }
  }

  // Register token on server
  async registerToken(token) {
    try {
      const userToken = await AsyncStorage.getItem('userToken');

      const response = await axios.post(
        'http://your-api.com/api/update-fcm-token',
        { fcm_token: token },
        {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${userToken}`,
            'Accept': 'application/json',
          },
        }
      );

      console.log('FCM: Token registered:', response.data);
      return true;
    } catch (error) {
      console.error('FCM: Error registering token:', error);
      return false;
    }
  }

  // Setup token refresh listener
  setupTokenRefreshListener() {
    messaging().onTokenRefresh(async (newToken) => {
      this.fcmToken = newToken;
      console.log('FCM: Token refreshed:', newToken);
      await this.registerToken(newToken);
    });
  }

  // Setup message handlers
  setupMessageHandlers(navigation) {
    // Foreground messages
    messaging().onMessage(async (remoteMessage) => {
      console.log('Foreground message:', remoteMessage);
      this.showLocalNotification(remoteMessage);
    });

    // Background/Quit - Notification opened
    messaging().onNotificationOpenedApp((remoteMessage) => {
      console.log('Notification opened (background):', remoteMessage);
      this.handleNotificationTap(remoteMessage.data, navigation);
    });

    // Check if app opened from notification (quit state)
    messaging()
      .getInitialNotification()
      .then((remoteMessage) => {
        if (remoteMessage) {
          console.log('App opened from notification (quit):', remoteMessage);
          this.handleNotificationTap(remoteMessage.data, navigation);
        }
      });
  }

  // Show local notification in foreground
  showLocalNotification(message) {
    // Use react-native-push-notification or similar library
    // For simplicity, showing an alert here
    if (message.notification) {
      Alert.alert(
        message.notification.title || 'Notification',
        message.notification.body || '',
      );
    }
  }

  // Handle notification tap
  handleNotificationTap(data, navigation) {
    const notificationType = data?.notification_type || '';

    switch (notificationType) {
      case 'profile_view':
        navigation.navigate('ProfileViewers', { viewerId: data.viewer_id });
        break;
      case 'new_message':
        navigation.navigate('Chat', { senderId: data.sender_id });
        break;
      case 'job_application':
        navigation.navigate('JobApplications', { jobId: data.job_id });
        break;
      case 'connection_request':
        navigation.navigate('ConnectionRequests', { requesterId: data.requester_id });
        break;
      default:
        navigation.navigate('Notifications');
    }
  }

  // Clear token on logout
  async clearToken() {
    await messaging().deleteToken();
    this.fcmToken = null;
  }
}

export default new FCMService();
```

### Step 3: Use in Your App

```javascript
// App.js or index.js
import messaging from '@react-native-firebase/messaging';
import FCMService from './services/FCMService';

// Background message handler (must be outside component)
messaging().setBackgroundMessageHandler(async (remoteMessage) => {
  console.log('Background message:', remoteMessage);
});

// In your main App component
function App() {
  const navigation = useNavigation();

  useEffect(() => {
    // Initialize FCM when app starts
    FCMService.initialize(navigation);
  }, []);

  return (
    <NavigationContainer>
      {/* Your app navigation */}
    </NavigationContainer>
  );
}

// After login
async function handleLoginSuccess(userToken) {
  // Save user token
  await AsyncStorage.setItem('userToken', userToken);

  // Get and register FCM token
  const fcmToken = await FCMService.getToken();
  if (fcmToken) {
    await FCMService.registerToken(fcmToken);
  }

  // Navigate to home
  navigation.navigate('Home');
}

// On logout
async function handleLogout() {
  // Clear FCM token
  await FCMService.clearToken();

  // Clear user data
  await AsyncStorage.clear();

  // Navigate to login
  navigation.navigate('Login');
}
```

---

## 5. Notification Data Structure

### What You'll Receive

**Notification Object:**
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

### Notification Types to Handle

| Type | Navigate To | Data Fields |
|------|-------------|-------------|
| `profile_view` | Profile Viewers Screen | `viewer_id`, `viewer_name` |
| `job_application` | Job Applications Screen | `applicant_id`, `job_id`, `job_title` |
| `new_message` | Chat Screen | `sender_id`, `sender_name`, `message_preview` |
| `connection_request` | Connections Screen | `requester_id`, `requester_name` |

---

## 6. Testing

### Test Steps

1. **Login to mobile app**
2. **Check console for FCM token**
   ```
   FCM Token: eA1B2C3D4...
   ```
3. **Verify token registered on server**
   - Check API response shows success
4. **Trigger a notification**
   - Example: Have another user view your profile at `/api/employee-profile/6`
5. **Check notification received**
   - Foreground: Should show local notification
   - Background: Should appear in notification tray
   - Tap notification: Should navigate to correct screen

### Debug Checklist

- [ ] Firebase config files added to project
- [ ] FCM dependencies installed
- [ ] App has notification permissions
- [ ] FCM token obtained successfully
- [ ] Token sent to server successfully
- [ ] Server has valid FCM token in database
- [ ] Notification appears in device
- [ ] Tapping notification navigates correctly

---

## 7. Common Issues

### Issue: Token not received
**Solution:** Check notification permissions and Firebase config files

### Issue: Token registration fails with 401
**Solution:** Ensure you're sending the Bearer token with the request

### Issue: Notifications not showing
**Solution:**
- Check notification permissions
- Verify token is registered on server
- Check server logs for errors

### Issue: App doesn't navigate on notification tap
**Solution:** Implement `handleNotificationTap()` function with proper navigation logic

---

## 8. Quick Reference

### When to Call Token Registration

✅ **Always call after:**
- User logs in
- FCM token refreshes (automatic)
- User grants notification permission

### When to Clear Token

✅ **Always call on:**
- User logs out
- User disables notifications in app

---

## Need Help?

- Check server logs for notification delivery status
- Verify token is saved in `users.fcm_token` column in database
- Test with manual API call using Postman
- Check Firebase Console for delivery reports

---

**Firebase Project:** `likewise-abdaf`
**Server Endpoint:** `POST /api/update-fcm-token`
**Authentication:** Bearer Token (Sanctum)
