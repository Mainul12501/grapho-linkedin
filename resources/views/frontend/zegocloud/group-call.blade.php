<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $callType === 'audio' ? 'Audio' : 'Video' }} Group Call - {{ config('app.name') }}</title>
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

        /* Add Participants Panel */
        .add-participants-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(102, 126, 234, 0.9);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .add-participants-btn:hover {
            background: rgba(102, 126, 234, 1);
            transform: scale(1.05);
        }

        .add-participants-panel {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.15);
            z-index: 10001;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .add-participants-panel.open {
            right: 0;
        }

        .panel-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-header h3 {
            margin: 0;
            font-size: 18px;
            color: #1f2937;
        }

        .close-panel-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
        }

        .users-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .user-item:hover {
            background: #f3f4f6;
        }

        .user-item.selected {
            background: #eef2ff;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #e5e7eb;
            margin-right: 12px;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
        }

        .user-email {
            font-size: 12px;
            color: #6b7280;
        }

        .user-checkbox {
            width: 22px;
            height: 22px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-item.selected .user-checkbox {
            background: #667eea;
            border-color: #667eea;
        }

        .user-item.selected .user-checkbox::after {
            content: '\2713';
            color: white;
            font-size: 14px;
        }

        .panel-footer {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .invite-btn {
            width: 100%;
            padding: 14px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .invite-btn:hover {
            background: #5a6fd6;
        }

        .invite-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .participant-count {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 14px;
            z-index: 1000;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        /* Mobile styles */
        @media (max-width: 576px) {
            .add-participants-panel {
                width: 100%;
                right: -100%;
            }

            .error-message {
                left: 20px;
                right: 20px;
                top: 20px;
            }

            .add-participants-btn {
                padding: 10px 16px;
                font-size: 12px;
                top: 20px;
            }
        }
    </style>
</head>
<body>
    <div id="loading" class="loading">
        <div class="spinner"></div>
        <p>Initializing group {{ $callType === 'audio' ? 'audio' : 'video' }} call...</p>
    </div>

    <div id="root"></div>

    @if($groupCall)
    <div class="participant-count" id="participantCount">
        <span id="participantNumber">{{ $groupCall->activeParticipants->count() }}</span> participants
    </div>

    <button class="add-participants-btn" onclick="openAddPanel()">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        Add People
    </button>

    <div class="overlay" id="overlay" onclick="closeAddPanel()"></div>

    <div class="add-participants-panel" id="addParticipantsPanel">
        <div class="panel-header">
            <h3>Add Team Members</h3>
            <button class="close-panel-btn" onclick="closeAddPanel()">&times;</button>
        </div>
        <div class="users-list" id="usersList">
            <p style="text-align: center; color: #6b7280; padding: 40px;">Loading team members...</p>
        </div>
        <div class="panel-footer">
            <button class="invite-btn" id="inviteBtn" onclick="inviteSelectedUsers()" disabled>
                Invite Selected (0)
            </button>
        </div>
    </div>
    @endif

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
            "positionClass": "toast-top-center",
            "timeOut": "5000"
        };

        let selectedUsers = new Set();
        let callableUsersLoaded = false;

        window.onload = function () {
            const appID = {{ config('services.zegocloud.app_id') }};
            const serverSecret = "{{ config('services.zegocloud.server_secret') }}";
            const roomID = "{{ $roomID }}";
            const userID = "{{ $user->id }}";
            const userName = "{{ $user->name }}";
            const callType = "{{ $callType }}";
            const groupCallId = "{{ $groupCall?->id ?? '' }}";
            const redirectUrl = '/';

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

            // Subscribe to group call channel
            if (groupCallId) {
                const groupChannel = pusher.subscribe('private-group-call.' + groupCallId);

                groupChannel.bind('participant.joined', function(data) {
                    console.log('Participant joined:', data);
                    toastr.success(data.user.name + ' joined the call');
                    updateParticipantCount(data.participant_count);
                });

                groupChannel.bind('participant.left', function(data) {
                    console.log('Participant left:', data);
                    toastr.info(data.user.name + ' left the call');
                    updateParticipantCount(data.participant_count);
                });

                groupChannel.bind('call.ended', function(data) {
                    console.log('Call ended:', data);
                    toastr.warning('The call has been ended by the host');
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 2000);
                });

                groupChannel.bind('invite.rejected', function(data) {
                    console.log('Invite rejected:', data);
                    toastr.info(data.user.name + ' declined the invitation');
                });
            }

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
                        mode: ZegoUIKitPrebuilt.GroupCall,
                    },
                    turnOnMicrophoneWhenJoining: true,
                    turnOnCameraWhenJoining: callType === 'video',
                    showMyCameraToggleButton: callType === 'video',
                    showMyMicrophoneToggleButton: true,
                    showAudioVideoSettingsButton: true,
                    showScreenSharingButton: callType === 'video',
                    showTextChat: true,
                    showUserList: true,
                    maxUsers: 10,
                    layout: "Auto",
                    showLayoutButton: true,
                    showLeavingView: true,
                    showPreJoinView: false,
                    onJoinRoom: () => {
                        console.log('Joined group room successfully');
                        hideLoading();
                    },
                    onLeaveRoom: () => {
                        console.log('Left room');
                        leaveCall();
                        window.location.href = redirectUrl;
                    },
                    onUserJoin: (users) => {
                        console.log('Users joined:', users);
                        users.forEach(user => {
                            toastr.success(user.userName + ' joined the call');
                        });
                    },
                    onUserLeave: (users) => {
                        console.log('Users left:', users);
                        users.forEach(user => {
                            toastr.info(user.userName + ' left the call');
                        });
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

        function updateParticipantCount(count) {
            const el = document.getElementById('participantNumber');
            if (el) {
                el.textContent = count;
            }
        }

        function leaveCall() {
            const groupCallId = "{{ $groupCall?->id ?? '' }}";

            if (groupCallId) {
                fetch(`/group-call/${groupCallId}/leave`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).catch(err => console.error('Error leaving call:', err));
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

        function openAddPanel() {
            document.getElementById('addParticipantsPanel').classList.add('open');
            document.getElementById('overlay').classList.add('show');
            loadCallableUsers();
        }

        function closeAddPanel() {
            document.getElementById('addParticipantsPanel').classList.remove('open');
            document.getElementById('overlay').classList.remove('show');
            selectedUsers.clear();
            updateInviteButton();
        }

        function loadCallableUsers() {
            const groupCallId = "{{ $groupCall?->id ?? '' }}";
            document.getElementById('usersList').innerHTML = '<p style="text-align: center; color: #6b7280; padding: 40px;">Loading team members...</p>';

            fetch(`/group-call/callable-users?group_call_id=${groupCallId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.users.length === 0) {
                    document.getElementById('usersList').innerHTML = '<p style="text-align: center; color: #6b7280; padding: 40px;">No team members available to add</p>';
                } else {
                    renderUsersList(data.users);
                }
            })
            .catch(err => {
                console.error('Load error:', err);
                document.getElementById('usersList').innerHTML = '<p style="text-align: center; color: #ef4444; padding: 40px;">Error loading team members</p>';
            });
        }

        function renderUsersList(users) {
            const container = document.getElementById('usersList');
            if (users.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #6b7280; padding: 40px;">No team members available</p>';
                return;
            }

            container.innerHTML = users.map(user => `
                <div class="user-item ${selectedUsers.has(user.id) ? 'selected' : ''}" data-user-id="${user.id}" onclick="toggleUser(${user.id})">
                    <img src="${user.profile_image ? '/backend/assets/uploaded-files/profile-image/' + user.profile_image : '/frontend/assets/images/default-avatar.png'}" alt="${user.name}" class="user-avatar" onerror="this.src='/frontend/assets/images/default-avatar.png'">
                    <div class="user-info">
                        <div class="user-name">${user.name}</div>
                        <div class="user-email">${user.email}</div>
                    </div>
                    <div class="user-checkbox"></div>
                </div>
            `).join('');
        }

        function toggleUser(id) {
            if (selectedUsers.has(id)) {
                selectedUsers.delete(id);
            } else {
                selectedUsers.add(id);
            }
            // Toggle selected class on the clicked item
            const item = document.querySelector(`.user-item[data-user-id="${id}"]`);
            if (item) {
                item.classList.toggle('selected');
            }
            updateInviteButton();
        }

        function updateInviteButton() {
            const btn = document.getElementById('inviteBtn');
            const count = selectedUsers.size;
            btn.textContent = `Invite Selected (${count})`;
            btn.disabled = count === 0;
        }

        function inviteSelectedUsers() {
            if (selectedUsers.size === 0) return;

            const groupCallId = "{{ $groupCall?->id ?? '' }}";
            const participantIds = Array.from(selectedUsers);

            fetch(`/group-call/${groupCallId}/add-participants`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ participant_ids: participantIds })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(`Invited ${data.added_count} member(s) to the call`);
                    selectedUsers.clear();
                    updateInviteButton();
                    loadCallableUsers(); // Reload list to remove already-invited users
                } else {
                    toastr.error(data.error || 'Failed to invite members');
                }
            })
            .catch(err => {
                console.error('Invite error:', err);
                toastr.error('Failed to invite members');
            });
        }

        window.addEventListener('beforeunload', leaveCall);
    </script>
</body>
</html>
