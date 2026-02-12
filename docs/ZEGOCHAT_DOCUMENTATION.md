# ZegoCloud Messenger Integration Documentation

## Overview

This document describes the ZegoCloud ZIM (Zego Instant Messaging) integration for real-time messaging in your Laravel application. The implementation provides a complete messaging interface similar to Chatify, using ZegoCloud's powerful messaging infrastructure.

## Features

- ✅ Real-time one-to-one messaging
- ✅ Message history loading
- ✅ Online/offline status
- ✅ Contact list with search
- ✅ Typing indicators
- ✅ Connection status monitoring
- ✅ Modern, responsive UI with Bootstrap
- ✅ Chatify-like design and functionality
- ✅ Integration with existing ZegoCloud audio/video calls

## Files Created/Modified

### Views
- `resources/views/frontend/zegocloud/messager/index.blade.php` - Main messenger interface

### Controllers
- `app/Http/Controllers/Frontend/ZegoCloud/ZegoCloudMessagingController.php` - Handles messaging logic and API endpoints

### Routes
- `routes/web.php` - Added routes for messenger (line 95-99)

### Assets
- `public/js/zegochat/app.js` - Main JavaScript for ZegoCloud ZIM integration
- `public/css/zegochat/style.css` - Additional styling for messenger

## Configuration

### Environment Variables

Your `.env` file already contains the required ZegoCloud credentials:

```env
ZEGOCLOUD_APP_ID=131228524
ZEGOCLOUD_SERVER_SECRET="a5f24ed44d428671e1b35d60c3bd87a4"
```

### Routes

The following routes are available:

```php
// Main messenger interface
GET  /zego/chat

// API endpoints
POST /zego/get-token      // Get authentication token
GET  /zego/get-contacts   // Get list of contacts
```

## How It Works

### 1. Authentication Flow

```
User visits /zego/chat
    ↓
Frontend requests token from backend (/zego/get-token)
    ↓
Backend generates ZegoCloud Token04 using App ID + Server Secret
    ↓
Frontend initializes ZIM SDK with token
    ↓
User is logged into ZegoCloud messaging service
```

### 2. Token Generation

The system uses Token04 authentication (latest ZegoCloud standard):

```php
$token = generateToken04(
    appId: $appId,
    userId: $userId,
    secret: $serverSecret,
    effectiveTimeInSeconds: 3600  // 1 hour
);
```

Token structure:
- Version: '04'
- Signature: HMAC-SHA256 hash
- Payload: Base64-encoded user data (user_id, app_id, timestamps, nonce)

### 3. Messaging Flow

```
User A sends message
    ↓
JavaScript calls zimInstance.sendMessage()
    ↓
Message sent to ZegoCloud servers
    ↓
ZegoCloud delivers message to User B in real-time
    ↓
User B's client receives 'peerMessageReceived' event
    ↓
Message displayed in chat interface
```

### 4. Contact System

Currently loads all active users except the current user. You can customize the query in `ZegoCloudMessagingController::getContacts()`:

```php
// Example: Only show users from the same company
$contacts = User::where('id', '!=', $currentUserId)
    ->where('employer_company_id', auth()->user()->employer_company_id)
    ->where('status', 'active')
    ->get();
```

## API Endpoints

### POST /zego/get-token

Generate authentication token for ZegoCloud ZIM.

**Request:**
```json
{
    "user_id": 123
}
```

**Response:**
```json
{
    "success": true,
    "app_id": 131228524,
    "token": "04a1b2c3d4e5f6...",
    "user_id": 123
}
```

### GET /zego/get-contacts

Get list of available contacts for messaging.

**Response:**
```json
{
    "success": true,
    "contacts": [
        {
            "id": 2,
            "name": "John Doe",
            "email": "john@example.com",
            "profile_photo_url": "https://..."
        }
    ]
}
```

## JavaScript API

### Global Functions

The following functions are available globally:

```javascript
// Select a contact to chat with
selectContact(userId, userName, avatarUrl)

// Make video call (placeholder - integrate with your existing system)
makeVideoCall()

// Make audio call (placeholder - integrate with your existing system)
makeAudioCall()

// Show user info panel (placeholder)
showInfo()
```

### ZIM Instance

The ZIM instance is stored in `zimInstance` and provides these key methods:

```javascript
// Send a message
zimInstance.sendMessage(messageTextObj, toConversationID, conversationType, config, notification)

// Query message history
zimInstance.queryHistoryMessage(conversationId, conversationType, config)

// Logout
zimInstance.logout()
```

### Event Listeners

The system listens for these ZIM events:

- `peerMessageReceived` - Incoming one-to-one messages
- `connectionStateChanged` - Connection status changes
- `error` - Error events
- `conversationChanged` - Conversation updates

## Customization

### Modifying Contact List Query

Edit `ZegoCloudMessagingController::getContacts()`:

```php
public function getContacts(Request $request)
{
    $currentUserId = Auth::id();

    // Example: Only employees
    $contacts = User::where('id', '!=', $currentUserId)
        ->where('user_type', 'employee')
        ->where('status', 'active')
        ->select('id', 'name', 'email', 'profile_photo_path')
        ->get();

    return response()->json(['success' => true, 'contacts' => $contacts]);
}
```

### Changing UI Colors

Edit the CSS variables in `resources/views/frontend/zegocloud/messager/index.blade.php`:

```css
/* Primary color */
background: #0084ff;  /* Change to your brand color */

/* Hover states */
background: #f2f3f5;  /* Light gray hover */

/* Borders */
border: 1px solid #e4e6eb;
```

### Integrating Audio/Video Calls

Update the placeholder functions in `public/js/zegochat/app.js`:

```javascript
window.makeVideoCall = function() {
    if (!activeConversationId) return;

    // Call your existing ZegoCloud video call system
    ZegoCloudCaller.initiateCall(activeConversationId, 'video', csrfToken);
};

window.makeAudioCall = function() {
    if (!activeConversationId) return;

    // Call your existing ZegoCloud audio call system
    ZegoCloudCaller.initiateCall(activeConversationId, 'audio', csrfToken);
};
```

## Usage

### Accessing the Messenger

1. Login to your application
2. Navigate to: `http://127.0.0.1:8000/zego/chat`
3. You'll see a contact list on the left
4. Click any contact to start chatting
5. Type your message and press Enter or click the send button

### Keyboard Shortcuts

- **Enter**: Send message
- **Shift + Enter**: New line in message

### Search

Use the search bar at the top of the contact list to filter contacts by name.

## Troubleshooting

### "Failed to connect" Error

**Possible causes:**
1. Invalid ZegoCloud credentials
2. Network connectivity issues
3. Token generation failed

**Solutions:**
- Check `.env` file has correct `ZEGOCLOUD_APP_ID` and `ZEGOCLOUD_SERVER_SECRET`
- Check browser console for detailed errors
- Verify ZegoCloud account is active

### "Failed to load contacts" Error

**Possible causes:**
1. Database connection issues
2. No users in database with status 'active'

**Solutions:**
- Check database connection
- Verify users table has records with `status = 'active'`
- Check browser Network tab for API response

### Messages Not Sending

**Possible causes:**
1. Not connected to ZegoCloud
2. Invalid conversation ID
3. Token expired

**Solutions:**
- Check connection status at top of page
- Refresh the page to get a new token
- Check browser console for errors

### Contact List Empty

**Solutions:**
1. Remove or modify the `where('status', 'active')` condition if your users don't have a status field
2. Check if there are other users in the database
3. Modify the query in `getContacts()` method

## Database Requirements

The system uses your existing `users` table. Recommended fields:

- `id` - User ID (required)
- `name` - User name (required)
- `email` - Email address
- `profile_photo_path` - Profile photo path
- `status` - User status (active/inactive)
- `is_online` - Online status (optional)
- `last_seen` - Last seen timestamp (optional)

## Security Considerations

### Token Generation

✅ **DO:**
- Generate tokens on the server side
- Use environment variables for credentials
- Set appropriate token expiration times
- Validate user authentication before generating tokens

❌ **DON'T:**
- Expose Server Secret in frontend code
- Generate tokens in JavaScript
- Share tokens between users
- Use long expiration times (> 24 hours)

### Message Validation

The current implementation trusts ZegoCloud for message delivery. For additional security:

1. Implement message content filtering
2. Add rate limiting
3. Validate message recipients
4. Store message copies in your database for audit trails

## Performance Optimization

### Recommended Improvements

1. **Database Indexing:**
```sql
CREATE INDEX idx_users_status ON users(status);
CREATE INDEX idx_users_id_status ON users(id, status);
```

2. **Caching Contacts:**
```php
$contacts = Cache::remember('user_contacts_' . $currentUserId, 300, function() {
    return User::where('id', '!=', $currentUserId)->get();
});
```

3. **Lazy Loading Messages:**
Currently loads last 30 messages. Implement "Load More" button for older messages.

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Mobile Responsiveness

The interface is fully responsive and works on:
- Desktop (1920x1080 and above)
- Tablet (768px - 1024px)
- Mobile (320px - 767px)

On mobile devices:
- Contact list shows full screen
- Chat view shows full screen when a contact is selected
- Back button returns to contact list

## Future Enhancements

### Recommended Features to Add

1. **Group Messaging**
   - Modify conversation type from 0 (peer) to 2 (group)
   - Add group creation interface
   - Handle group message events

2. **File Sharing**
   - Implement file upload in message form
   - Use ZIM's image/file message types
   - Add file preview

3. **Message Status**
   - Show message sent/delivered/read status
   - Implement read receipts

4. **Notifications**
   - Desktop notifications for new messages
   - Browser push notifications
   - Email notifications for offline messages

5. **Message Search**
   - Search within conversation
   - Search across all conversations

6. **Emoji Picker**
   - Integrate emoji picker library
   - Add emoji reactions to messages

## ZegoCloud Documentation References

For detailed ZegoCloud documentation, refer to:

- [ZIM Web SDK Overview](https://www.zegocloud.com/docs/zim-web/introduction/overview)
- [Send and Receive Messages](https://www.zegocloud.com/docs/zim-web/send-and-receive-messages)
- [Authentication Guide](https://www.zegocloud.com/docs/zim-web/guides/users/authentication)
- [Token Generation Guide](https://docs.zegocloud.com/article/13971)

## Support

For issues specific to:
- **ZegoCloud SDK**: Contact ZegoCloud support
- **Implementation**: Check browser console and Laravel logs
- **Integration**: Review this documentation

## License

This integration follows your project's license terms.

---

**Created:** December 2025
**Last Updated:** December 2025
**Version:** 1.0.0
