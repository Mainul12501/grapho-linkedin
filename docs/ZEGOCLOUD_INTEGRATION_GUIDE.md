# ZegoCloud Audio/Video Call Integration Guide

## Overview
This guide explains how to use the integrated ZegoCloud audio and video call system in your Laravel application.

## Features Implemented

✅ **Audio & Video Calls**: Support for both audio-only and video calls
✅ **Real-time Notifications**: Incoming call popups with ringtone
✅ **Auto Authentication**: Uses authenticated user information
✅ **Secure Room IDs**: Automatically generated secure room IDs
✅ **Responsive Design**: Works on all devices (mobile, tablet, desktop)
✅ **Broadcasting**: Real-time call status updates using Pusher
✅ **Call History**: Tracks all calls in the database

---

## Setup Instructions

### 1. Environment Configuration

The ZegoCloud credentials are already added to your `.env` file:

```env
ZEGOCLOUD_APP_ID=131228524
ZEGOCLOUD_SERVER_SECRET="a5f24ed44d428671e1b35d60c3bd87a4"
BROADCAST_CONNECTION=pusher
```

### 2. Install Pusher PHP SDK (if not already installed)

```bash
composer require pusher/pusher-php-server
```

### 3. Run Queue Worker (for broadcasting events)

```bash
php artisan queue:work
```

---

## How to Use

### Method 1: Include Incoming Call Popup in Your Layout

Add this to your main layout file (e.g., `resources/views/layouts/app.blade.php`):

```blade
<!DOCTYPE html>
<html>
<head>
    <!-- Your head content -->
</head>
<body>
    <!-- Your content -->

    @include('frontend.zegocloud.incoming-call-popup')
</body>
</html>
```

This will enable users to receive incoming call notifications on any page.

### Method 2: Add Call Buttons to User Profiles

Include the JavaScript helper in your page:

```html
<script src="{{ asset('js/zegocloud-caller.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
```

**Option A: Use the helper functions to create call buttons**

```javascript
// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Create and append video call button
const videoBtn = ZegoCloudCaller.createVideoCallButton(userId, csrfToken);
document.getElementById('call-buttons-container').appendChild(videoBtn);

// Create and append audio call button
const audioBtn = ZegoCloudCaller.createAudioCallButton(userId, csrfToken);
document.getElementById('call-buttons-container').appendChild(audioBtn);
```

**Option B: Create custom buttons**

```html
<button onclick="initiateVideoCall({{ $user->id }})">
    📹 Video Call
</button>

<button onclick="initiateAudioCall({{ $user->id }})">
    📞 Audio Call
</button>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function initiateVideoCall(userId) {
    ZegoCloudCaller.initiateCall(userId, 'video', csrfToken);
}

function initiateAudioCall(userId) {
    ZegoCloudCaller.initiateCall(userId, 'audio', csrfToken);
}
</script>
```

---

## Complete Example

Here's a complete example for a user profile page:

```blade
@extends('layouts.app')

@section('content')
<div class="user-profile">
    <h1>{{ $user->name }}</h1>
    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">

    <div id="call-buttons" class="call-actions">
        <!-- Call buttons will be added here -->
    </div>
</div>

<script src="{{ asset('js/zegocloud-caller.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const userId = {{ $user->id }};
    const container = document.getElementById('call-buttons');

    // Add video call button
    const videoBtn = ZegoCloudCaller.createVideoCallButton(userId, csrfToken);
    container.appendChild(videoBtn);

    // Add audio call button
    const audioBtn = ZegoCloudCaller.createAudioCallButton(userId, csrfToken);
    container.appendChild(audioBtn);
});
</script>
@endsection
```

---

## API Endpoints

The following endpoints are available:

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/call/initiate` | Initiate a new call |
| POST | `/call/{call}/accept` | Accept an incoming call |
| POST | `/call/{call}/reject` | Reject an incoming call |
| POST | `/call/{call}/end` | End an active call |
| GET | `/call/{call}/details` | Get call details |
| GET | `/call/call-page` | View call page |

---

## How It Works

### 1. **Initiating a Call**

When a user clicks a call button:
1. A POST request is sent to `/call/initiate` with `receiver_id` and `call_type`
2. Server creates a new call record with a unique `room_id`
3. Server broadcasts `CallInitiated` event to the receiver
4. Caller is redirected to the call page

### 2. **Receiving a Call**

When a call is initiated:
1. Receiver's browser receives the `CallInitiated` event via Pusher
2. Incoming call popup appears with caller's information
3. Ringtone starts playing automatically
4. Receiver can accept or reject the call

### 3. **Accepting a Call**

When receiver clicks "Accept":
1. POST request sent to `/call/{call}/accept`
2. Server updates call status to "accepted"
3. Server broadcasts `CallAccepted` event to caller
4. Both users are redirected to the call page with the same `room_id`

### 4. **During the Call**

- ZegoCloud UIKit handles all audio/video streaming
- Both users can toggle camera, microphone, and screen sharing
- Call page is responsive and works on all devices

### 5. **Ending a Call**

When a user leaves:
1. POST request sent to `/call/{call}/end`
2. Server updates call status and calculates duration
3. Server broadcasts `CallEnded` event to the other user
4. Both users are redirected to home page

---

## Database Schema

### `calls` Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| caller_id | bigint | ID of user initiating call |
| receiver_id | bigint | ID of user receiving call |
| room_id | string | Unique room identifier |
| call_type | enum | 'audio' or 'video' |
| status | enum | 'initiated', 'ringing', 'accepted', 'rejected', 'ended', 'missed' |
| started_at | timestamp | When call was accepted |
| ended_at | timestamp | When call ended |
| duration | integer | Call duration in seconds |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

---

## Security Features

1. **Authentication Required**: All call endpoints require authentication via `auth:sanctum` middleware
2. **User Authorization**: Users can only accept/reject calls directed to them
3. **Secure Room IDs**: Randomly generated unique room IDs prevent unauthorized access
4. **Private Channels**: Pusher uses private channels for broadcasting call events
5. **CSRF Protection**: All POST requests require CSRF tokens
6. **Environment Variables**: Sensitive credentials stored in `.env` file

---

## Customization

### Change Call Button Styles

Edit `public/js/zegocloud-caller.js` and modify the styles in the `<style>` block.

### Customize Incoming Call Popup

Edit `resources/views/frontend/zegocloud/incoming-call-popup.blade.php`:
- Modify HTML structure in the popup
- Change CSS styles
- Customize ringtone (base64 audio data)

### Customize Call Page

Edit `resources/views/frontend/zegocloud/index.blade.php`:
- Modify ZegoCloud configuration options
- Change loading screen appearance
- Add custom branding

---

## Troubleshooting

### Incoming call popup not showing

1. Make sure you've included the popup component in your layout
2. Check that Pusher is configured correctly in `.env`
3. Verify queue worker is running: `php artisan queue:work`
4. Check browser console for JavaScript errors

### Calls not connecting

1. Verify ZegoCloud credentials in `.env`
2. Check that both users are authenticated
3. Ensure room ID is being passed correctly
4. Check network connectivity

### No ringtone playing

1. Modern browsers require user interaction before playing audio
2. Check browser audio permissions
3. Verify audio element is not muted

### Broadcasting not working

1. Install Pusher SDK: `composer require pusher/pusher-php-server`
2. Verify Pusher credentials in `.env`
3. Check `config/broadcasting.php` exists and is configured
4. Run: `php artisan config:clear`
5. Ensure routes/channels.php exists

---

## Production Considerations

### Before Going Live:

1. **Get Production ZegoCloud Credentials**
   - Sign up at [zegocloud.com](https://www.zegocloud.com)
   - Get production APP ID and Server Secret
   - Update `.env` with production credentials

2. **Use Secure Token Generation**
   - Move from test tokens to production tokens
   - Implement server-side token generation

3. **Setup Queue Workers**
   - Use Supervisor to keep queue workers running
   - Configure Redis for better queue performance

4. **Enable HTTPS**
   - Audio/video calls require HTTPS in production
   - Configure SSL certificate

5. **Optimize Broadcasting**
   - Consider using Redis for broadcasting
   - Setup dedicated broadcasting server

6. **Monitor Call Quality**
   - Implement call quality monitoring
   - Track failed calls and connection issues

---

## Support

For issues related to:
- **ZegoCloud SDK**: [ZegoCloud Documentation](https://www.zegocloud.com/docs)
- **Laravel Broadcasting**: [Laravel Broadcasting Docs](https://laravel.com/docs/broadcasting)
- **Pusher**: [Pusher Documentation](https://pusher.com/docs)

---

## License

This integration is part of your Laravel application and follows the same license.

---

**Last Updated**: November 30, 2025
**Version**: 1.0.0
