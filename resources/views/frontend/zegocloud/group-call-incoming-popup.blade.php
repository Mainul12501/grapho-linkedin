@auth
<div id="group-call-incoming-popup" style="display: none;">
    <div class="group-call-overlay"></div>
    <div class="group-call-popup">
        <div class="group-call-popup-content">
            <div class="group-caller-avatar">
                <img id="group-caller-photo" src="" alt="Caller">
            </div>
            <h3 id="group-caller-name" class="group-caller-name"></h3>
            <p id="group-call-type-text" class="group-call-type"></p>
            <div class="group-call-actions">
                <button id="reject-group-call-btn" class="group-call-btn group-reject-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 1L1 23M1 1l22 22"/>
                    </svg>
                    <span>Reject</span>
                </button>
                <button id="accept-group-call-btn" class="group-call-btn group-accept-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>Join</span>
                </button>
            </div>
        </div>
    </div>
</div>

<audio id="group-call-ringtone" loop preload="auto">
    <source src="{{ asset('sounds/call-ringtone.mp3') }}" type="audio/mpeg">
</audio>

<style>
.group-call-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(10px);
    z-index: 99998;
    animation: groupCallFadeIn 0.3s ease-out;
}

.group-call-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 99999;
    animation: groupCallSlideUp 0.4s ease-out;
}

.group-call-popup-content {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 24px;
    padding: 40px 50px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    text-align: center;
    min-width: 350px;
    max-width: 90vw;
}

.group-caller-avatar {
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    animation: groupCallPulse 2s ease-in-out infinite;
}

.group-caller-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.group-caller-name {
    color: white;
    font-size: 28px;
    font-weight: 600;
    margin: 0 0 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.group-call-type {
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    margin: 0 0 30px;
}

.group-call-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.group-call-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
    width: 80px;
    height: 80px;
}

.group-call-btn:hover {
    transform: scale(1.1);
}

.group-call-btn:active {
    transform: scale(0.95);
}

.group-reject-btn {
    background: #ef4444;
    color: white;
}

.group-reject-btn:hover {
    background: #dc2626;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
}

.group-accept-btn {
    background: #10b981;
    color: white;
}

.group-accept-btn:hover {
    background: #059669;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

@keyframes groupCallFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes groupCallSlideUp {
    from {
        opacity: 0;
        transform: translate(-50%, -40%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

@keyframes groupCallPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@media (max-width: 480px) {
    .group-call-popup-content {
        padding: 30px 20px;
        min-width: 300px;
    }
    .group-caller-avatar {
        width: 100px;
        height: 100px;
    }
    .group-caller-name {
        font-size: 24px;
    }
    .group-call-btn {
        width: 70px;
        height: 70px;
        padding: 15px;
    }
    .group-call-actions {
        gap: 15px;
    }
}
</style>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userId = {{ auth()->id() }};
    let currentGroupCall = null;
    const ringtone = document.getElementById('group-call-ringtone');
    const popup = document.getElementById('group-call-incoming-popup');

    console.log('=== GROUP CALL POPUP INITIALIZED ===');
    console.log('User ID:', userId);

    // Enable Pusher logging for debugging
    Pusher.logToConsole = true;

    // Initialize Pusher for group calls
    const groupCallPusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    // Monitor connection state
    groupCallPusher.connection.bind('connected', function() {
        console.log('✅ Group Call Pusher connected!');
    });

    groupCallPusher.connection.bind('error', function(err) {
        console.error('❌ Group Call Pusher error:', err);
    });

    // Subscribe to user's private channel for group calls
    const groupChannel = groupCallPusher.subscribe('private-user.' + userId);

    groupChannel.bind('pusher:subscription_succeeded', function() {
        console.log('✅ Subscribed to group call channel: private-user.' + userId);
    });

    groupChannel.bind('pusher:subscription_error', function(error) {
        console.error('❌ Group call channel subscription error:', error);
    });

    // Listen for group call invitations
    groupChannel.bind('group.call.initiated', function(data) {
        console.log('📞 GROUP CALL INVITATION RECEIVED:', data);
        currentGroupCall = data;
        showGroupCallPopup(data);
    });

    function showGroupCallPopup(data) {
        console.log('=== SHOWING GROUP CALL POPUP ===', data);

        const photoUrl = data.host?.profile_photo_url || '/frontend/assets/images/default-avatar.png';
        const hostName = data.host?.name || 'Unknown';
        const callType = data.call_type || 'video';
        const callName = data.name || '';

        document.getElementById('group-caller-photo').src = photoUrl;
        document.getElementById('group-caller-name').textContent = hostName;
        document.getElementById('group-call-type-text').textContent =
            `Group ${callType} call${callName ? ': ' + callName : ''}`;

        popup.style.display = 'block';

        // Play ringtone
        if (ringtone) {
            ringtone.currentTime = 0;
            ringtone.play()
                .then(() => console.log('✅ Group call ringtone playing'))
                .catch(err => console.error('❌ Could not play ringtone:', err));
        }
    }

    function hideGroupCallPopup() {
        popup.style.display = 'none';
        if (ringtone) {
            ringtone.pause();
            ringtone.currentTime = 0;
        }
        currentGroupCall = null;
    }

    // Accept group call button
    document.getElementById('accept-group-call-btn').addEventListener('click', function() {
        if (!currentGroupCall) return;

        console.log('Accepting group call:', currentGroupCall.group_call_id);

        fetch(`/group-call/${currentGroupCall.group_call_id}/join`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Join response:', data);
            if (data.success) {
                hideGroupCallPopup();
                // Open group call in new tab
                window.open(data.room_url, '_blank');
            } else {
                alert(data.error || 'Failed to join group call');
                hideGroupCallPopup();
            }
        })
        .catch(error => {
            console.error('Error joining group call:', error);
            alert('Failed to join group call. Please try again.');
            hideGroupCallPopup();
        });
    });

    // Reject group call button
    document.getElementById('reject-group-call-btn').addEventListener('click', function() {
        if (!currentGroupCall) return;

        console.log('Rejecting group call:', currentGroupCall.group_call_id);

        fetch(`/group-call/${currentGroupCall.group_call_id}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Reject response:', data);
            hideGroupCallPopup();
        })
        .catch(error => {
            console.error('Error rejecting group call:', error);
            hideGroupCallPopup();
        });
    });
});
</script>
@endauth
