@auth
<div id="incoming-call-popup" style="display: none;">
    <div class="call-overlay"></div>
    <div class="call-popup">
        <div class="call-popup-content">
            <div class="caller-avatar">
                <img id="caller-photo" src="" alt="Caller">
            </div>
            <h3 id="caller-name" class="caller-name"></h3>
            <p id="call-type-text" class="call-type"></p>
            <div class="call-actions">
                <button id="reject-call-btn" class="call-btn reject-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 1L1 23M1 1l22 22"/>
                    </svg>
                    <span>Reject</span>
                </button>
                <button id="accept-call-btn" class="call-btn accept-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                    </svg>
                    <span>Accept</span>
                </button>
            </div>
        </div>
    </div>
</div>

<audio id="ringtone" loop preload="auto">
    <source src="{{ asset('sounds/call-ringtone.mp3') }}" type="audio/mpeg">
</audio>



<style>
.call-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(10px);
    z-index: 99998;
    animation: fadeIn 0.3s ease-out;
}

.call-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 99999;
    animation: slideUp 0.4s ease-out;
}

.call-popup-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 24px;
    padding: 40px 50px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    text-align: center;
    min-width: 350px;
    max-width: 90vw;
}

.caller-avatar {
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    animation: pulse 2s ease-in-out infinite;
}

.caller-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.caller-name {
    color: white;
    font-size: 28px;
    font-weight: 600;
    margin: 0 0 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.call-type {
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    margin: 0 0 30px;
}

.call-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.call-btn {
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

.call-btn:hover {
    transform: scale(1.1);
}

.call-btn:active {
    transform: scale(0.95);
}

.reject-btn {
    background: #ef4444;
    color: white;
}

.reject-btn:hover {
    background: #dc2626;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
}

.accept-btn {
    background: #10b981;
    color: white;
}

.accept-btn:hover {
    background: #059669;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translate(-50%, -40%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@media (max-width: 480px) {
    .call-popup-content {
        padding: 30px 20px;
        min-width: 300px;
    }

    .caller-avatar {
        width: 100px;
        height: 100px;
    }

    .caller-name {
        font-size: 24px;
    }

    .call-btn {
        width: 70px;
        height: 70px;
        padding: 15px;
    }

    .call-actions {
        gap: 15px;
    }
}
</style>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userId = {{ auth()->id() }};
    let currentCall = null;
    const ringtone = document.getElementById('ringtone');
    const popup = document.getElementById('incoming-call-popup');

    // Initialize Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    // Subscribe to user's private channel
    const channel = pusher.subscribe('private-user.' + userId);

    // Listen for incoming calls
    channel.bind('call.initiated', function(data) {
        console.log('Incoming call:', data);
        currentCall = data;
        showIncomingCall(data);
    });

    // Listen for call accepted
    channel.bind('call.accepted', function(data) {
        console.log('Call accepted:', data);
        if (currentCall && currentCall.call_id === data.call_id) {
            hideIncomingCall();
            window.location.href = `/call/call-page?roomID=${data.room_id}&type=${data.call_type}&callId=${data.call_id}&chatWith=${data.caller_id}`;
        }
    });

    // Listen for call rejected
    channel.bind('call.rejected', function(data) {
        console.log('Call rejected:', data);
        if (currentCall && currentCall.call_id === data.call_id) {
            hideIncomingCall();
            showNotification('Call was rejected', 'error');
        }
    });

    // Listen for call ended
    channel.bind('call.ended', function(data) {
        console.log('Call ended:', data);
        if (currentCall && currentCall.call_id === data.call_id) {
            hideIncomingCall();
        }
    });

    // Listen for group call invitations
    channel.bind('group.call.initiated', function(data) {
        console.log('Group call invitation:', data);
        currentCall = {
            ...data,
            is_group_call: true,
            call_id: data.group_call_id
        };
        showIncomingGroupCall(data);
    });

    function showIncomingGroupCall(data) {
        console.log('=== INCOMING GROUP CALL ===', data);
        document.getElementById('caller-photo').src = data.host.profile_photo_url || '/frontend/assets/images/default-avatar.png';
        document.getElementById('caller-name').textContent = data.host.name;
        document.getElementById('call-type-text').textContent =
            `Group ${data.call_type} call invitation${data.name ? ': ' + data.name : ''}...`;

        popup.style.display = 'block';
        console.log('Group call popup displayed');

        if (ringtone) {
            ringtone.play()
                .then(() => console.log('Ringtone playing for group call'))
                .catch(err => console.error('Could not play ringtone:', err));
        }
    }

    function showIncomingCall(data) {
        console.log('=== INCOMING CALL ===', data);
        document.getElementById('caller-photo').src = data.caller.profile_photo_url;
        document.getElementById('caller-name').textContent = data.caller.name;
        document.getElementById('call-type-text').textContent =
            `Incoming ${data.call_type} call...`;

        popup.style.display = 'block';
        console.log('Popup displayed');

        // Play ringtone automatically
        console.log('Attempting to play ringtone...');
        if (ringtone) {
            ringtone.play()
                .then(() => console.log('✅ Ringtone playing successfully!'))
                .catch(err => console.error('❌ Could not play ringtone:', err));
        } else {
            console.error('❌ Ringtone element not found!');
        }
    }

    function hideIncomingCall() {
        popup.style.display = 'none';
        ringtone.pause();
        ringtone.currentTime = 0;
        currentCall = null;
    }

    // Accept call button
    document.getElementById('accept-call-btn').addEventListener('click', function() {
        if (!currentCall) return;

        // Handle group call
        if (currentCall.is_group_call) {
            fetch(`/group-call/${currentCall.group_call_id}/join`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideIncomingCall();
                    window.location.href = data.room_url;
                } else {
                    showNotification(data.error || 'Failed to join group call', 'error');
                }
            })
            .catch(error => {
                console.error('Error joining group call:', error);
                showNotification('Failed to join group call', 'error');
            });
            return;
        }

        // Handle one-to-one call
        fetch(`/call/${currentCall.call_id}/accept`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                hideIncomingCall();
                window.location.href = `/call/call-page?roomID=${data.call.room_id}&type=${data.call.call_type}&callId=${data.call.id}&chatWith=${data.call.caller_id}`;
            } else {
                showNotification('Failed to accept call', 'error');
            }
        })
        .catch(error => {
            console.error('Error accepting call:', error);
            showNotification('Failed to accept call', 'error');
        });
    });

    // Reject call button
    document.getElementById('reject-call-btn').addEventListener('click', function() {
        if (!currentCall) return;

        // Handle group call rejection
        if (currentCall.is_group_call) {
            fetch(`/group-call/${currentCall.group_call_id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                hideIncomingCall();
            })
            .catch(error => {
                console.error('Error rejecting group call:', error);
                hideIncomingCall();
            });
            return;
        }

        // Handle one-to-one call rejection
        fetch(`/call/${currentCall.call_id}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                hideIncomingCall();
            }
        })
        .catch(error => {
            console.error('Error rejecting call:', error);
            hideIncomingCall();
        });
    });

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            background: ${type === 'error' ? '#ef4444' : '#10b981'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 100000;
            animation: slideIn 0.3s ease-out;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>
@endauth
