# ZegoCloud Messaging - Mobile Developer Quick Start Guide

## 🚀 Get Started in 5 Minutes

### Step 1: Import Postman Collection

1. Download `POSTMAN_COLLECTION.json`
2. Open Postman → Import → Select the file
3. Set `base_url` variable to your API endpoint
4. Test the `/auth/custom-login` endpoint to get your token

### Step 2: Install ZegoCloud SDK

**Flutter:**
```yaml
# pubspec.yaml
dependencies:
  zego_zim: ^2.x.x
```

**React Native:**
```bash
npm install zego-zim-react-native
```

**iOS (Swift):**
```ruby
# Podfile
pod 'ZIM'
```

**Android (Kotlin):**
```gradle
// build.gradle
implementation 'im.zego:zim:2.x.x'
```

### Step 3: Copy Integration Code

Choose your platform and copy the relevant code from `MOBILE_API_DOCUMENTATION.md`:
- **Flutter:** Section "Flutter/Dart"
- **React Native:** Section "React Native / JavaScript"
- **iOS:** Section "Swift (iOS)"
- **Android:** Section "Kotlin (Android)"

### Step 4: Initialize Messaging

```dart
// Flutter example
final service = ZegoMessagingService();
service.sanctumToken = 'your_token_from_login';

// Initialize ZIM
await service.initializeZIM();

// Load contacts
final contacts = await service.getContacts(limit: 50);

// Send message
await service.sendMessage('user_id', 'Hello!');
```

---

## 📋 API Endpoints Summary

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/auth/custom-login` | POST | Login (get Sanctum token) |
| `/zego/messaging/token` | POST | Get ZegoCloud token |
| `/zego/messaging/contacts` | GET | Get contact list |
| `/zego/messaging/users/{id}` | GET | Get user details |
| `/zego/messaging/search-users` | POST | Search users |
| `/zego/messaging/update-online-status` | POST | Update online status |
| `/zego/messaging/profile` | GET | Get current user profile |

**All endpoints require:** `Authorization: Bearer {sanctum_token}`

---

## 🔑 Authentication Flow

```
1. Login → Get Sanctum Token
   ↓
2. Use Sanctum Token → Get ZegoCloud Token
   ↓
3. Initialize ZIM SDK with ZegoCloud Token
   ↓
4. Start Messaging!
```

---

## 💬 Sending Messages

Messages are sent **directly through ZIM SDK** (not through our API):

```dart
// ZIM SDK handles actual messaging
final message = ZIMTextMessage(message: "Hello!");
await ZIM.getInstance()!.sendPeerMessage(
  message,
  toUserId,
  config,
);
```

**Our API provides:**
- ✅ Authentication tokens
- ✅ User lists
- ✅ User details
- ✅ Online status

**ZIM SDK provides:**
- ✅ Send/receive messages
- ✅ Message history
- ✅ Typing indicators
- ✅ Read receipts

---

## 🧪 Testing Checklist

- [ ] Login and get Sanctum token
- [ ] Get ZegoCloud token successfully
- [ ] Initialize ZIM SDK in app
- [ ] Load contacts list
- [ ] Send message to another user
- [ ] Receive message from another user
- [ ] Update online status
- [ ] Search users
- [ ] Handle token expiration

---

## 🐛 Common Issues

**Issue:** "Unauthorized (401)"
**Solution:** Token expired - call login again

**Issue:** "Failed to initialize ZIM"
**Solution:** Check if ZegoCloud token is correct, verify App ID

**Issue:** "Empty contacts list"
**Solution:** Check if users have `status = 'active'` in database

**Issue:** "Message not received"
**Solution:** Both users must be logged into ZIM SDK

---

## 📞 API Examples

### Get ZegoCloud Token
```bash
curl -X POST http://127.0.0.1:8000/api/zego/messaging/token \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

### Get Contacts
```bash
curl -X GET "http://127.0.0.1:8000/api/zego/messaging/contacts?limit=20" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

### Update Status
```bash
curl -X POST http://127.0.0.1:8000/api/zego/messaging/update-online-status \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"is_online":true}'
```

---

## 📚 Documentation Files

1. **MOBILE_API_DOCUMENTATION.md** - Complete API reference with code examples
2. **POSTMAN_COLLECTION.json** - Import to Postman for testing
3. **ZEGOCHAT_DOCUMENTATION.md** - Web implementation details
4. **This file** - Quick start guide

---

## 🎯 Minimum Implementation

**Required APIs:**
1. `POST /zego/messaging/token` - Get ZegoCloud token
2. `GET /zego/messaging/contacts` - Get user list

**Required ZIM SDK Methods:**
1. `ZIM.create()` - Initialize
2. `ZIM.login()` - Login with token
3. `ZIM.sendMessage()` - Send messages
4. Event listener for receiving messages

---

## 🔗 Useful Links

- Full API Docs: `MOBILE_API_DOCUMENTATION.md`
- ZIM Flutter SDK: https://pub.dev/packages/zego_zim
- ZIM React Native: https://www.npmjs.com/package/zego-zim-react-native
- ZIM iOS: https://www.zegocloud.com/docs/zim-ios/overview
- ZIM Android: https://www.zegocloud.com/docs/zim-android/overview

---

## 📞 Support

**Questions?** Check `MOBILE_API_DOCUMENTATION.md` for detailed examples

**App Configuration:**
- App ID: `131228524` (from backend)
- Server Secret: Managed by backend (never expose in app)

---

**Last Updated:** December 2025
**Version:** 1.0.0
