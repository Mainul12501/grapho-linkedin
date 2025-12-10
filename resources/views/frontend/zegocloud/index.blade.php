<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $callType === 'audio' ? 'Audio' : 'Video' }} Call - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            overflow: hidden;
        }

        #root {
            width: 100vw;
            height: 100vh;
            background: #1a1a1a;
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            color: white;
        }

        .loading .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading p {
            font-size: 18px;
            margin-top: 10px;
        }

        .error-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ef4444;
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .error-message {
                left: 20px;
                right: 20px;
                top: 20px;
            }
        }
    </style>
</head>
<body>
    <div id="loading" class="loading">
        <div class="spinner"></div>
        <p>Initializing {{ $callType === 'audio' ? 'audio' : 'video' }} call...</p>
    </div>
    <div id="root"></div>

    <!-- Toastr CSS & JS for notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
    <script>
        // Configure toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };

        window.onload = function () {
            const appID = {{ config('services.zegocloud.app_id') }};
            const serverSecret = "{{ config('services.zegocloud.server_secret') }}";
            const roomID = "{{ $roomID }}";
            const userID = "{{ $user->id }}";
            const userName = "{{ $user->name }}";
            const callType = "{{ $callType }}";
            const urlParams = new URLSearchParams(window.location.search);
            const callId = urlParams.get('callId');
            const chatWith = urlParams.get('chatWith');
            const redirectUrl = chatWith ? `/chat/${chatWith}` : '/';

            if (!roomID) {
                showError('Invalid call. Room ID is missing.');
                return;
            }

            // Initialize Pusher for call status updates
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
            const channel = pusher.subscribe('private-user.' + userID);

            // Listen for call rejection
            channel.bind('call.rejected', function(data) {
                console.log('Call rejected:', data);
                if (callId && data.call_id == callId) {
                    toastr.error('Call was rejected by the receiver', 'Call Rejected');
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 2000);
                }
            });

            // Listen for call ended
            channel.bind('call.ended', function(data) {
                console.log('Call ended:', data);
                if (callId && data.call_id == callId) {
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 1000);
                }
            });

            try {
                const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                    appID,
                    serverSecret,
                    roomID,
                    userID,
                    userName
                );

                const zp = ZegoUIKitPrebuilt.create(kitToken);

                const callConfig = {
                    container: document.querySelector("#root"),
                    scenario: {
                        mode: callType === 'audio'
                            ? ZegoUIKitPrebuilt.OneONoneCall
                            : ZegoUIKitPrebuilt.OneONoneCall,
                    },
                    turnOnMicrophoneWhenJoining: true,
                    turnOnCameraWhenJoining: callType === 'video',
                    showMyCameraToggleButton: callType === 'video',
                    showMyMicrophoneToggleButton: true,
                    showAudioVideoSettingsButton: true,
                    showScreenSharingButton: callType === 'video',
                    showTextChat: false,
                    showUserList: false,
                    maxUsers: 2,
                    layout: "Auto",
                    showLayoutButton: false,
                    showLeavingView: true,
                    showPreJoinView: false,
                    onJoinRoom: () => {
                        console.log('Joined room successfully');
                        hideLoading();
                    },
                    onLeaveRoom: () => {
                        console.log('Left room');
                        endCall();
                        window.location.href = redirectUrl;
                    },
                    onUserJoin: (users) => {
                        console.log('User joined:', users);
                    },
                    onUserLeave: (users) => {
                        console.log('User left:', users);
                        setTimeout(() => {
                            endCall();
                            window.location.href = redirectUrl;
                        }, 2000);
                    }
                };

                zp.joinRoom(callConfig);

                setTimeout(hideLoading, 2000);

            } catch (error) {
                console.error('Error initializing call:', error);
                showError('Failed to initialize call. Please try again.');
                hideLoading();
            }
        };

        function endCall() {
            const urlParams = new URLSearchParams(window.location.search);
            const callId = urlParams.get('callId');

            if (callId) {
                fetch(`/call/${callId}/end`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).catch(err => console.error('Error ending call:', err));
            }
        }

        function hideLoading() {
            const loading = document.getElementById('loading');
            if (loading) {
                loading.style.opacity = '0';
                setTimeout(() => loading.remove(), 300);
            }
        }

        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            document.body.appendChild(errorDiv);

            setTimeout(() => {
                errorDiv.style.opacity = '0';
                setTimeout(() => errorDiv.remove(), 300);
            }, 5000);
        }

        window.addEventListener('beforeunload', endCall);
    </script>
</body>
</html>
