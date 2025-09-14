@extends('frontend.employer.master')

@section('title')
    employer call
@endsection
@section('body')
    <div class="video-call-container">
        <!-- Top bar with caller info -->
        <div class="top-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="caller-info">
                    <div class="caller-avatar">
                        <img src="{{ isset(auth()->user()->profile_image) ? asset(auth()->user()->profile_image) : asset('/frontend/user-vector-img.jpg') }}" alt="Sarah Johnson">
{{--                        'https://randomuser.me/api/portraits/women/44.jpg'--}}
                    </div>
                    <div>
                        <div class="call-status text-white">{{ auth()->user()->name ?? 'Employer Name' }}</div>
                        <div class="call-timer text-light">00:00</div>
                    </div>
                </div>
                <div class="d-flex gap-3">
{{--                    <button class="control-btn">--}}
{{--                        <i class="fas fa-user-plus"></i>--}}
{{--                    </button>--}}
{{--                    <button class="control-btn">--}}
{{--                        <i class="fas fa-cog"></i>--}}
{{--                    </button>--}}
                </div>
            </div>
        </div>

        <!-- Main video area -->
        <div class="video-container">
            <div class="remote-video" id="remoteArea">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1488&q=80" alt="Remote video">
            </div>

            <div class="local-video" id="localArea">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Local video">
{{--                <img src="{{ asset('/frontend/user-vector-img.jpg') }}" alt="Local video">--}}
            </div>

            <!-- Participants list -->
{{--            <div class="participants">--}}
{{--                <h6>In call (3)</h6>--}}
{{--                <div class="participant">--}}
{{--                    <div class="participant-avatar">--}}
{{--                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Mike Ross">--}}
{{--                    </div>--}}
{{--                    <div>Mike Ross</div>--}}
{{--                </div>--}}
{{--                <div class="participant">--}}
{{--                    <div class="participant-avatar">--}}
{{--                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Jessica Pearson">--}}
{{--                    </div>--}}
{{--                    <div>Jessica Pearson</div>--}}
{{--                </div>--}}
{{--                <div class="participant">--}}
{{--                    <div class="participant-avatar">--}}
{{--                        <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Louis Litt">--}}
{{--                    </div>--}}
{{--                    <div>Louis Litt</div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <span id="inviteArea" class="small d-none" style=""></span>
            <!-- Effects panel -->
{{--            <div class="effects-panel">--}}
{{--                <button class="effect-btn"><i class="fas fa-magic"></i></button>--}}
{{--                <button class="effect-btn"><i class="fas fa-sun"></i></button>--}}
{{--                <button class="effect-btn active-effect"><i class="fas fa-video"></i></button>--}}
{{--                <button class="effect-btn"><i class="fas fa-microphone-alt"></i></button>--}}
{{--            </div>--}}

            <!-- Connection info -->
{{--            <div class="connection-info">--}}
{{--                <div class="connection-quality"></div>--}}
{{--                <span>Excellent</span>--}}
{{--            </div>--}}
        </div>

        <!-- Control bar -->
        <div class="controls">
            <button class="control-btn" {{--id="mic-btn"--}} id="toggleMicBtn">
                <i class="fas fa-microphone"></i>
            </button>
            <button class="control-btn" {{--id="video-btn"--}} id="toggleCamBtn">
                <i class="fas fa-video"></i>
            </button>
            <button class="control-btn" id="shareBtn">
                <i class="fas fa-desktop"></i>
            </button>
            <button class="control-btn d-none" id="stopShareBtn">
                <i class="fa-regular fa-eye-slash"></i>
            </button>
            <button class="control-btn end-call" {{--id="end-call-btn"--}} id="leaveBtn">
                <i class="fas fa-phone"></i>
            </button>
            <button class="control-btn" id="inviteBtn">
{{--                <i class="fas fa-ellipsis-h"></i>--}}
                <i class="fa-solid fa-share-nodes"></i>
            </button>
        </div>

        <!-- Incoming call modal -->
        <div class="incoming-call d-none" id="incoming-call">
            <div class="caller-avatar mb-3 mx-auto">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah Johnson" class="w-100">
            </div>
            <h4>Sarah Johnson</h4>
            <p>Incoming video call...</p>
            <div class="call-actions">
                <button class="call-action-btn decline-btn" id="decline-btn">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="call-action-btn accept-btn" id="accept-btn">
                    <i class="fas fa-video"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --messenger-blue: #0084ff;
            --messenger-dark: #1c1e21;
            --messenger-gray: #f0f2f5;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .video-call-container {
            background-color: var(--messenger-dark);
            height: 80vh;
            position: relative;
            overflow: hidden;
        }

        .top-bar {
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
            padding: 15px;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 100;
        }

        .caller-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .caller-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
        }

        .caller-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .call-status {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .video-container {
            display: flex;
            height: 100%;
            position: relative;
        }

        .remote-video {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000;
            position: relative;
        }

        .remote-video img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .local-video {
            position: absolute;
            bottom: 100px;
            right: 20px;
            width: 180px;
            height: 135px;
            border-radius: 8px;
            overflow: hidden;
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);*/
            z-index: 10;
            /*border: 2px solid white;*/
        }
        .local-video .tile video {height: 135px;}

        .local-video img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .controls {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            display: flex;
            justify-content: center;
            gap: 30px;
            z-index: 100;
        }

        .control-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .control-btn:hover {
            transform: scale(1.1);
        }

        .end-call {
            background-color: #ff3b30;
        }

        .active {
            background-color: white;
            color: var(--messenger-blue);
        }

        .participants {
            position: absolute;
            top: 80px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            padding: 10px;
            max-width: 250px;
            color: white;
            z-index: 50;
        }

        .participant {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .participant:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .participant-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            overflow: hidden;
        }

        .participant-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .call-timer {
            font-size: 1.1rem;
            margin-left: 10px;
        }

        .effects-panel {
            position: absolute;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 30px;
            padding: 10px 20px;
            display: flex;
            gap: 15px;
            z-index: 50;
        }

        .effect-btn {
            color: white;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 20px;
            transition: background 0.3s;
        }

        .effect-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .active-effect {
            background-color: var(--messenger-blue);
        }

        .connection-info {
            position: absolute;
            bottom: 100px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            z-index: 50;
        }

        .connection-quality {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #4cd964;
        }

        .incoming-call {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            z-index: 1000;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        .call-actions {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        .call-action-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            border: none;
        }

        .decline-btn {
            background-color: #ff3b30;
            color: white;
        }

        .accept-btn {
            background-color: #4cd964;
            color: white;
        }
        #inviteArea {
            position: absolute;
            bottom: 100px;
            color: black;
            font-size: 13px;
            background-color: lightsteelblue;
            text-align: center;
            left: 25%;
            right: 25%;
            border: 2px solid ghostwhite;
            padding: 5px 8px;
            border-radius: 13px;
        }
    </style>
@endpush

@push('script')
    <script src="https://media.twiliocdn.com/sdk/js/video/releases/2.26.0/twilio-video.min.js"></script>

    <script>
        /* ---------- config ---------- */
        const tokenEndpoint = "{{ route('video.token') }}";
        const inviteEndpoint = "{{ route('twilio.invite') }}";
        const kickEndpoint = "{{ route('twilio.kick') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        /* ---------- state ---------- */
        let room = null;
        let localVideoTrack = null;
        let localAudioTrack = null;
        let localDataTrack = null; // used by host to send commands
        let screenTrack = null;
        let isMicEnabled = true;
        let isCamEnabled = true;
        let amIHost = false;

        /* ----------- Custom code for joining room -------------*/
        $(document).ready(function () {
            // write codes to starts meeting here
            joinRoom();
        });

        /* ---------- helpers ---------- */
        function createVideoTile(identity) {
            const tile = document.createElement('div');
            tile.className = 'tile';
            const label = document.createElement('div');
            label.className = 'label';
            label.textContent = identity;
            tile.appendChild(label);
            return tile;
        }

        function attachTrack(track, container, label) {
            const tile = createVideoTile(label);
            const el = track.attach();
            if (track.kind === 'audio') {
                // hide audio element (still needs to be attached for playback)
                el.style.display = 'none';
                tile.appendChild(el);
                container.appendChild(tile);
                return tile;
            }
            tile.appendChild(el);
            container.appendChild(tile);
            return tile;
        }

        function updateParticipantsUI() {
            const list = $('#participantsList').empty();
            if (!room) return;
            list.append($('<div/>').text('You: ' + room.localParticipant.identity).addClass('hint'));
            // remote participants
            room.participants.forEach(p => {
                const div = $('<div/>').addClass('participant-item').attr('data-pid', p.sid);
                const left = $('<div/>').text(p.identity);
                const right = $('<div/>');

                if (amIHost) {
                    // host controls
                    const muteBtn = $('<button/>').addClass('btn-ghost').html('<i class="fa-solid fa-microphone-slash"></i>').on('click', () => {
                        // Host requests participant to mute via DataTrack issued to ALL participants with target identity
                        if (localDataTrack) localDataTrack.send(JSON.stringify({type:'mute-request', target: p.identity}));
                    });
                    const kickBtn = $('<button/>').addClass('btn-ghost danger').html('<i class="fa-solid fa-user-slash"></i>').on('click', () => {
                        // Kick via server endpoint (host only)
                        if (!confirm('Kick ' + p.identity + '?')) return;
                        $.ajax({
                            url: kickEndpoint,
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': csrfToken},
                            data: { room: room.name, participant: p.identity },
                            success(resp) {
                                alert('Kick request processed');
                            },
                            error(err) {
                                alert('Kick failed: ' + (err?.responseJSON?.message || 'server error'));
                            }
                        });
                    });
                    right.append(muteBtn).append(kickBtn);
                }

                div.append(left).append(right);
                list.append(div);
            });
        }

        /* ---------- devices ---------- */
        async function populateDevices() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const cams = devices.filter(d => d.kind === 'videoinput');
            const mics = devices.filter(d => d.kind === 'audioinput');
            const camSel = $('#cameraSelect').empty();
            const micSel = $('#micSelect').empty();
            cams.forEach((d,i) => camSel.append(new Option(d.label || `Camera ${i+1}`, d.deviceId)));
            mics.forEach((d,i) => micSel.append(new Option(d.label || `Mic ${i+1}`, d.deviceId)));
        }

        /* ---------- local tracks ---------- */
        async function createLocalTracks() {
            const camera = $('#cameraSelect').val() || undefined;
            const mic = $('#micSelect').val() || undefined;

            localVideoTrack = await Twilio.Video.createLocalVideoTrack({
                deviceId: camera ? { exact: camera } : undefined
            });
            localAudioTrack = await Twilio.Video.createLocalAudioTrack({
                deviceId: mic ? { exact: mic } : undefined
            });

            // Data track (for host commands)
            localDataTrack = new Twilio.Video.LocalDataTrack();

            // show local preview
            $('#localArea').empty();
            attachTrack(localVideoTrack, document.getElementById('localArea'), '');
            const audioTile = document.createElement('div'); audioTile.style.display='none';
            audioTile.appendChild(localAudioTrack.attach());
            document.getElementById('localArea').appendChild(audioTile);
        }

        /* ---------- join/leave ---------- */
        async function joinRoom() {
            // const name = $('#name').val() || '';
            const name = "{{ auth()->user()->name }}" || '';
            // const roomName = $('#room').val().trim();
            let dynamicRoomName = "{{ $roomName }}";
            const roomName = dynamicRoomName.trim();
            if (!roomName) return alert('Enter room name');

            await createLocalTracks();

            // fetch token from server
            const res = await fetch(tokenEndpoint, {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken},
                body: JSON.stringify({room: roomName, name})
            });
            const json = await res.json();
            const token = json.token;
            amIHost = !!json.is_host;

            // connect
            room = await Twilio.Video.connect(token, {
                name: roomName,
                tracks: [localVideoTrack, localAudioTrack, localDataTrack],
                dominantSpeaker: true,
                networkQuality: { local: 1, remote: 1 }
            });

            bindRoomEvents(room);
            $('#joinBtn').prop('disabled', true);
            $('#leaveBtn').prop('disabled', false);
            $('#toggleMicBtn, #toggleCamBtn, #shareBtn').prop('disabled', false);

            // If host: show host badge & ability to send DataTrack messages
            // if (amIHost) {
            //     $('#inviteArea').html('<span class="small hint">You are host</span>').removeClass('d-none');
            // }

            updateParticipantsUI();
        }

        function leaveRoom() {
            if (screenTrack) stopScreenShare();

            if (room) {
                room.localParticipant.tracks.forEach(pub => {
                    const t = pub.track;
                    if (t) t.stop();
                });
                room.disconnect();
            }

            if (localVideoTrack) localVideoTrack.stop();
            if (localAudioTrack) localAudioTrack.stop();
            if (localDataTrack) localDataTrack.stop();

            room = null;
            $('#remoteArea').empty();
            $('#participantsList').empty();
            $('#joinBtn').prop('disabled', false);
            $('#leaveBtn').prop('disabled', true);
            $('#toggleMicBtn, #toggleCamBtn, #shareBtn, #stopShareBtn').prop('disabled', true);
            isMicEnabled = true; isCamEnabled = true;
            $('#micLabel').text('Mic On'); $('#camLabel').text('Cam On');

        }

        /* ---------- event bindings ---------- */
        function bindRoomEvents(roomInstance) {
            // existing participants
            roomInstance.participants.forEach(p => attachParticipant(p));

            roomInstance.on('participantConnected', p => {
                attachParticipant(p);
                updateParticipantsUI();
            });

            roomInstance.on('participantDisconnected', p => {
                // remove participant tiles
                $(`[data-participant="${p.sid}"]`).remove();
                updateParticipantsUI();
            });

            roomInstance.on('disconnected', () => {
                $('#remoteArea').empty();
                updateParticipantsUI();
            });
        }

        function attachParticipant(participant) {
            const remoteArea = document.getElementById('remoteArea');

            // existing tracks
            participant.tracks.forEach(pub => {
                if (pub.isSubscribed) {
                    const track = pub.track;
                    const tile = attachTrack(track, remoteArea, participant.identity);
                    tile.dataset.participant = participant.sid;
                }
            });

            // future tracks
            participant.on('trackSubscribed', track => {
                const tile = attachTrack(track, remoteArea, participant.identity);
                tile.dataset.participant = participant.sid;
            });

            participant.on('trackUnsubscribed', track => {
                track.detach().forEach(el => el.remove());
            });

            // listen for data messages from any participant (used for host-to-others broadcast)
            participant.on('trackSubscribed', pub => {
                if (pub.track && pub.track.kind === 'data') {
                    pub.track.on('message', handleDataMessageFromRemote);
                }
            });
        }

        /* ---------- data track: receive and act ---------- */
        function handleDataMessageFromRemote(msg) {
            let payload;
            try { payload = JSON.parse(msg); } catch(e){ return; }

            if (payload.type === 'mute-request' && payload.target) {
                // if the message targets THIS user identity, then mute local mic (client must obey)
                if (room && room.localParticipant && room.localParticipant.identity === payload.target) {
                    if (localAudioTrack) {
                        localAudioTrack.enable(false);
                        isMicEnabled = false;
                        $('#micLabel').text('Mic Off');
                    }
                }
            }

            if (payload.type === 'global-mute' && payload.enable !== undefined) {
                // host controls globally — just mute local track when requested
                if (localAudioTrack) {
                    localAudioTrack.enable(!payload.enable ? true : false);
                    isMicEnabled = !payload.enable;
                    $('#micLabel').text(isMicEnabled ? 'Mic On' : 'Mic Off');
                }
            }

            if (payload.type === 'kick' && payload.target) {
                // If server instructs via data for client to leave, do it (defensive)
                if (room && room.localParticipant && room.localParticipant.identity === payload.target) {
                    leaveRoom();
                    alert('You were removed from the room by the host.');
                }
            }
        }

        /* ---------- mic / cam toggles ---------- */
        function toggleMic() {
            if (!localAudioTrack) return;
            isMicEnabled = !isMicEnabled;
            localAudioTrack.enable(isMicEnabled);
            // $('#micLabel').text(isMicEnabled ? 'Mic On' : 'Mic Off');
            $('#toggleMicBtn').html(isMicEnabled ? '<i class="fas fa-microphone"></i>' : '<i class="fas fa-microphone-slash"></i>');
        }

        function toggleCam() {
            if (!localVideoTrack) return;
            isCamEnabled = !isCamEnabled;
            localVideoTrack.enable(isCamEnabled);
            // $('#camLabel').text(isCamEnabled ? 'Cam On' : 'Cam Off');
            $('#localArea .tile video').toggleClass('muted', !isCamEnabled);
            $('#toggleCamBtn').html(isCamEnabled ? '<i class="fas fa-video"></i>' : '<i class="fas fa-video-slash"></i>');
            if (isCamEnabled)
                $('.local-video').fadeIn();
            else
                $('.local-video').fadeOut();
        }

        /* ---------- screen share ---------- */
        async function startScreenShare() {
            if (!room) return;
            try {
                const stream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: false });
                const [videoTrack] = stream.getVideoTracks();
                screenTrack = new Twilio.Video.LocalVideoTrack(videoTrack);
                await room.localParticipant.publishTrack(screenTrack);
                // attachTrack(screenTrack, document.getElementById('localArea'), 'l');
                attachTrack(screenTrack, document.getElementById('remoteArea'), '');
                $('#shareBtn').prop('disabled', true);
                $('#stopShareBtn').prop('disabled', false);
                videoTrack.addEventListener('ended', () => stopScreenShare());
            } catch (e) {
                console.warn('Screen share failed', e);
            }
        }

        function stopScreenShare() {
            if (!room || !screenTrack) return;
            try { room.localParticipant.unpublishTrack(screenTrack); } catch(e){}
            screenTrack.stop();
            screenTrack.detach().forEach(el => el.remove());
            screenTrack = null;
            $('#shareBtn').prop('disabled', false);
            $('#stopShareBtn').prop('disabled', true);
        }

        /* ---------- invite / host actions ---------- */
        async function generateInvite() {
            try {
                // const res = await fetch(inviteEndpoint, {
                //     method: 'POST',
                //     headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken},
                //     body: JSON.stringify({})
                // });
                // if (!res.ok) throw new Error('Invite creation failed');
                // const data = await res.json();
                // $('#inviteArea').html('<a class="small" href="'+data.invite_url+'">'+data.invite_url+'</a>');
                $('#inviteArea').html('<a class="small" href="{{ $invite_url }}">{{ $invite_url }}</a>').removeClass('d-none');
            } catch (e) {
                alert('Invite failed: ' + e.message);
            }
        }

        /* ---------- bootstrap ---------- */
        $(async function(){
            try { await populateDevices(); } catch(e){ console.warn('Device enumeration may need HTTPS to show labels', e); }

            $('#joinBtn').on('click', joinRoom);
            $(document).on('click', '#leaveBtn', function () {
                leaveRoom();
                window.location = "{{ $previousUrl }}";
            });
            $('#leaveBtn').on('click', leaveRoom);
            $('#toggleMicBtn').on('click', toggleMic);
            $('#toggleCamBtn').on('click', toggleCam);
            // $('#shareBtn').on('click', startScreenShare);
            $(document).on('click', '#shareBtn', function () {
                startScreenShare();
                $('#shareBtn').addClass('d-none');
                $('#stopShareBtn').removeClass('d-none');
            })
            // $('#stopShareBtn').on('click', stopScreenShare);
            $(document).on('click', '#stopShareBtn', function () {
                stopScreenShare();
                $('#stopShareBtn').addClass('d-none');
                $('#shareBtn').removeClass('d-none');
            })
            $('#inviteBtn').on('click', generateInvite);

            // Update devices on change
            navigator.mediaDevices?.addEventListener?.('devicechange', populateDevices);

            // Clean up on unload
            window.addEventListener('beforeunload', leaveRoom);
            window.addEventListener('unload', leaveRoom);
        });
    </script>

    <script>
        async function startAudioCall(roomName, userName) {
            // 1. Get the token from Laravel
            const res = await fetch('/audio/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ room: roomName, name: userName })
            });

            const { token } = await res.json();

            // 2. Connect to Twilio Video with only audio
            Twilio.Video.connect(token, {
                name: roomName,
                audio: true,     // Enable audio
                video: false     // Disable video
            }).then(room => {
                console.log(`Connected to room ${room.name}`);

                // Listen for participants joining
                room.on('participantConnected', participant => {
                    console.log(`Participant ${participant.identity} connected`);
                    participant.tracks.forEach(publication => {
                        if (publication.track) {
                            document.body.appendChild(publication.track.attach());
                        }
                    });

                    participant.on('trackSubscribed', track => {
                        document.body.appendChild(track.attach());
                    });
                });
            }).catch(err => {
                console.error('Unable to connect to Twilio:', err);
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            // Timer functionality
            let seconds = 0;
            let timer;

            function startTimer() {
                timer = setInterval(function() {
                    seconds++;
                    const minutes = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    $('.call-timer').text(`${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`);
                }, 1000);
            }

            // Toggle microphone
            $('#mic-btn').click(function() {
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).html('<i class="fas fa-microphone-slash"></i>');
                } else {
                    $(this).html('<i class="fas fa-microphone"></i>');
                }
            });

            // Toggle video
            $('#video-btn').click(function() {
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).html('<i class="fas fa-video-slash"></i>');
                    $('.local-video').fadeOut();
                } else {
                    $(this).html('<i class="fas fa-video"></i>');
                    $('.local-video').fadeIn();
                }
            });

            // End call button
            $('#end-call-btn').click(function() {
                clearInterval(timer);
                $('.incoming-call').removeClass('d-none');
                $('.top-bar, .controls, .local-video, .remote-video, .participants, .effects-panel, .connection-info').addClass('d-none');
            });

            // Accept call
            $('#accept-btn').click(function() {
                $('.incoming-call').addClass('d-none');
                $('.top-bar, .controls, .local-video, .remote-video, .participants, .effects-panel, .connection-info').removeClass('d-none');
                startTimer();
            });

            // Decline call
            $('#decline-btn').click(function() {
                $('.incoming-call').addClass('d-none');
                $('.remote-video').html('<div class="d-flex justify-content-center align-items-center h-100"><div class="text-center text-white"><h3>Call ended</h3><p>You declined the video call</p></div></div>');
                $('.local-video, .participants, .effects-panel').addClass('d-none');
                $('.controls').html('<button class="control-btn" id="call-again"><i class="fas fa-phone"></i> Call Again</button>');

                $('#call-again').click(function() {
                    location.reload();
                });
            });

            // Start the timer when page loads (simulating call in progress)
            startTimer();
        });
    </script>
@endpush
