@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            {{-- Tabs --}}
            {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="show messenger-tab users-tab app-scroll" data-view="users">
               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title"><span>Favorites</span></p>
                <div class="messenger-favorites app-scroll-hidden"></div>
               </div>
               {{-- Saved Messages --}}
               <p class="messenger-title"><span>Your Space</span></p>
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
               {{-- Contact --}}
               <p class="messenger-title"><span>All Messages</span></p>
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
           </div>
             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>
    <style>
        .video-call-dropdown {
            position: relative;
            display: inline-block;
        }
        .video-call-btn {
            cursor: pointer;
            background: transparent;
        }
        .video-dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            min-width: 160px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            list-style: none;
            padding: 8px 0;
            z-index: 1000;
        }
        .video-dropdown-menu.show {
            display: block;
        }
        .video-dropdown-menu li a {
            display: block;
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.2s;
        }
        .video-dropdown-menu li a:hover {
            background: #f5f5f5;
        }
        .video-dropdown-menu li a i {
            margin-right: 10px;
            width: 16px;
            text-align: center;
        }
    </style>
    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                    </div>
                    <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    @if(auth()->user()->user_type == 'employer' || auth()->user()->user_type == 'sub_employer')
{{--                        <a href="{{ route('twilio.view') }}" target="_blank" class="bg-warning"><i class="fas fa-video"></i></a>--}}
                        <a href="javascript:void(0)"  onclick="makeAudioCall({{ $id }})" class="bg-warning"><i class="fas fa-phone"></i></a>
{{--                        <a href="javascript:void(0)"  onclick="makeVideoCall({{ $id }})" class="bg-warning"><i class="fas fa-video"></i></a>--}}
                        <div class="video-call-dropdown">
                            <a href="javascript:void(0)" class="bg-warning video-call-btn" onclick="toggleVideoDropdown(event)">
                                <i class="fas fa-video"></i>
                            </a>
                            <ul class="video-dropdown-menu" id="videoDropdownMenu">
                                <li><a href="javascript:void(0)" onclick="makeVideoCall({{ $id }}); closeVideoDropdown();"><i class="fas fa-user"></i> Single Call</a></li>
                                <li><a href="javascript:void(0)" onclick="initiateGroupCall({{ $id }}); closeVideoDropdown();"><i
                                            class="fas fa-users"></i> Group Call</a></li>
                            </ul>
                        </div>
{{--                        <a href="javascript:void(0)"  onclick="makeVideoCall({{ $id }})" class="bg-warning"><i class="fas fa-video"></i></a>--}}
                        <!-- Add buttons container -->
{{--                        <div id="call-buttons"></div>--}}
                    @endif
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
{{-- Include ZegoCloud incoming call popup --}}
@include('frontend.zegocloud.incoming-call-popup')

<!-- Include the helper script -->
<script src="{{ asset('js/zegocloud-caller.js') }}"></script>

<!-- Initialize buttons -->
<script>
    {{--const csrfToken = "{{ csrf_token() }}";--}}

    function makeVideoCall(userId) {
        ZegoCloudCaller.initiateCall(userId, 'video', csrfToken);
    }

    function makeAudioCall(userId) {
        ZegoCloudCaller.initiateCall(userId, 'audio', csrfToken);
    }
</script>

<script>

    // Video Call Dropdown Toggle
    function toggleVideoDropdown(event) {
        event.stopPropagation();
        var menu = document.getElementById('videoDropdownMenu');
        menu.classList.toggle('show');
    }

    function closeVideoDropdown() {
        var menu = document.getElementById('videoDropdownMenu');
        menu.classList.remove('show');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        var dropdown = document.querySelector('.video-call-dropdown');
        var menu = document.getElementById('videoDropdownMenu');
        if (dropdown && menu && !dropdown.contains(event.target)) {
            menu.classList.remove('show');
        }
    });

    // Initiate group call function
    function initiateGroupCall(userId) {
        if (!userId) {
            showGroupCallNotification('Please select a user to call', 'error');
            return;
        }

        // Show loading notification
        showGroupCallNotification('Initiating group video call...', 'info');

        fetch('/group-call/initiate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                receiver_id: userId,
                call_type: 'video'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showGroupCallNotification('Call initiated! Opening call window...', 'success');
                // Open group call page in new tab
                window.open(data.room_url, '_blank');
            } else {
                showGroupCallNotification(data.error || 'Failed to initiate group call', 'error');
            }
        })
        .catch(error => {
            console.error('Error initiating group call:', error);
            showGroupCallNotification('Failed to initiate group call. Please try again.', 'error');
        });
    }

    // Show notification for group call
    function showGroupCallNotification(message, type) {
        const existing = document.querySelector('.group-call-notification');
        if (existing) existing.remove();

        const notification = document.createElement('div');
        notification.className = 'group-call-notification';
        notification.textContent = message;

        const bgColor = type === 'error' ? '#ef4444' : type === 'success' ? '#10b981' : '#3b82f6';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            background: ${bgColor};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 100000;
            font-size: 14px;
            font-weight: 500;
            max-width: 400px;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

</script>
