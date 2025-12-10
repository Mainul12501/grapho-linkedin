# ZegoCloud Call System - Quick Start Guide

## ⚡ Quick Setup (3 Steps)

### Step 1: Include Popup in Your Layout

Add this line to your main layout file (e.g., `resources/views/layouts/app.blade.php`):

```blade
@include('frontend.zegocloud.incoming-call-popup')
```

Place it before the closing `</body>` tag.

### Step 2: Add Call Buttons to User Profile

In your user/employee/employer profile view:

```blade
<!-- Include the helper script -->
<script src="{{ asset('js/zegocloud-caller.js') }}"></script>

<!-- Add buttons container -->
<div id="call-buttons"></div>

<!-- Initialize buttons -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';
    const userId = {{ $user->id }};
    const container = document.getElementById('call-buttons');

    // Add video call button
    container.appendChild(
        ZegoCloudCaller.createVideoCallButton(userId, csrfToken)
    );

    // Add audio call button
    container.appendChild(
        ZegoCloudCaller.createAudioCallButton(userId, csrfToken)
    );
});
</script>
```

### Step 3: Start Queue Worker

```bash
php artisan queue:work
```

That's it! You're ready to make calls! 🎉

---

## 📞 How to Test

1. Open your site in **two different browsers** (or incognito mode)
2. Login as **two different users**
3. Go to a user profile page
4. Click the **Video Call** or **Audio Call** button
5. The other user will receive a **popup notification with ringtone**
6. Click **Accept** to join the call

---

## 🎯 Common Integration Points

### For Employer viewing Employee Profile:

```blade
{{-- resources/views/employer/employee-profile.blade.php --}}

@if(auth()->user()->user_type === 'employer' && auth()->id() !== $employee->id)
    <div class="contact-section">
        <h4>Contact {{ $employee->name }}</h4>
        <div id="employee-call-buttons"></div>
    </div>

    <script src="{{ asset('js/zegocloud-caller.js') }}"></script>
    <script>
        const container = document.getElementById('employee-call-buttons');
        const csrfToken = '{{ csrf_token() }}';

        container.appendChild(
            ZegoCloudCaller.createVideoCallButton({{ $employee->id }}, csrfToken)
        );
        container.appendChild(
            ZegoCloudCaller.createAudioCallButton({{ $employee->id }}, csrfToken)
        );
    </script>
@endif
```

### For Employee viewing Employer/Company:

```blade
{{-- resources/views/employee/company-profile.blade.php --}}

@if(auth()->user()->user_type === 'employee' && $company->user)
    <div class="contact-section">
        <h4>Contact Company</h4>
        <div id="company-call-buttons"></div>
    </div>

    <script src="{{ asset('js/zegocloud-caller.js') }}"></script>
    <script>
        const container = document.getElementById('company-call-buttons');
        const csrfToken = '{{ csrf_token() }}';

        container.appendChild(
            ZegoCloudCaller.createVideoCallButton({{ $company->user->id }}, csrfToken)
        );
        container.appendChild(
            ZegoCloudCaller.createAudioCallButton({{ $company->user->id }}, csrfToken)
        );
    </script>
@endif
```

---

## 🔧 Configuration

All ZegoCloud settings are in `.env`:

```env
ZEGOCLOUD_APP_ID=131228524
ZEGOCLOUD_SERVER_SECRET="a5f24ed44d428671e1b35d60c3bd87a4"
BROADCAST_CONNECTION=pusher

PUSHER_APP_KEY="3538fa3ad54285c4fd36"
PUSHER_APP_SECRET="c62b2fa5ef13b4c00ae5"
PUSHER_APP_ID="1511550"
PUSHER_APP_CLUSTER="ap2"
```

---

## 🎨 Custom Button Example

Want to create your own styled buttons?

```html
<button onclick="makeVideoCall({{ $user->id }})">
    📹 Start Video Call
</button>

<button onclick="makeAudioCall({{ $user->id }})">
    📞 Start Audio Call
</button>

<script src="{{ asset('js/zegocloud-caller.js') }}"></script>
<script>
const csrfToken = '{{ csrf_token() }}';

function makeVideoCall(userId) {
    ZegoCloudCaller.initiateCall(userId, 'video', csrfToken);
}

function makeAudioCall(userId) {
    ZegoCloudCaller.initiateCall(userId, 'audio', csrfToken);
}
</script>
```

---

## 📋 API Endpoints Reference

| Action | Endpoint | Method |
|--------|----------|--------|
| Initiate call | `/call/initiate` | POST |
| Accept call | `/call/{id}/accept` | POST |
| Reject call | `/call/{id}/reject` | POST |
| End call | `/call/{id}/end` | POST |
| Call page | `/call/call-page?roomID=xxx&type=video` | GET |

---

## ✅ Features Checklist

- ✅ Audio calls
- ✅ Video calls
- ✅ Real-time notifications
- ✅ Incoming call popup with ringtone
- ✅ Auto-authentication (no manual username input)
- ✅ Secure room IDs (no manual sharing needed)
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Call history tracking
- ✅ Security & authorization

---

## 🐛 Troubleshooting

### Issue: Popup not showing
**Solution:** Make sure you've included the popup component in your layout:
```blade
@include('frontend.zegocloud.incoming-call-popup')
```

### Issue: Calls not connecting
**Solution:** Verify queue worker is running:
```bash
php artisan queue:work
```

### Issue: Broadcasting errors
**Solution:** Install Pusher SDK:
```bash
composer require pusher/pusher-php-server
```

Then clear config:
```bash
php artisan config:clear
```

---

## 📚 More Information

- Full documentation: `ZEGOCLOUD_INTEGRATION_GUIDE.md`
- Usage examples: View `resources/views/frontend/zegocloud/example-usage.blade.php` in browser
- Example URL: `http://127.0.0.1:8000/call/example` (create a route for this)

---

## 🎓 Example Route

Add this to `routes/web.php` to view the example page:

```php
Route::get('/call/example', function () {
    return view('frontend.zegocloud.example-usage');
})->middleware('auth:sanctum');
```

---

## 🚀 Production Checklist

Before going live:

- [ ] Get production ZegoCloud credentials
- [ ] Update `.env` with production credentials
- [ ] Enable HTTPS (required for audio/video)
- [ ] Setup Supervisor for queue workers
- [ ] Configure Redis for better performance
- [ ] Test on multiple devices and browsers

---

**Ready to make your first call?** Just include the popup, add the buttons, and start the queue worker! 📞🎥

**Need help?** Check `ZEGOCLOUD_INTEGRATION_GUIDE.md` for detailed information.
