<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() ?? '' }}">
    <meta name="user-name" content="{{ auth()->user()?->name ?? 'User' }}">
    <title>ZegoCloud Messenger</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/zegochat/style.css') }}" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f0f2f5;
            overflow: hidden;
        }

        .messenger-container {
            display: flex;
            height: 100vh;
            max-width: 100%;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Sidebar Styles */
        .messenger-sidebar {
            width: 360px;
            border-right: 1px solid #e4e6eb;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .messenger-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e4e6eb;
            background: white;
        }

        .messenger-header h4 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #050505;
        }

        .messenger-search {
            padding: 12px 16px;
            border-bottom: 1px solid #e4e6eb;
        }

        .search-input {
            width: 100%;
            padding: 10px 16px;
            border: none;
            border-radius: 50px;
            background: #f0f2f5;
            font-size: 15px;
        }

        .search-input:focus {
            outline: none;
            background: #e4e6eb;
        }

        .contacts-list {
            flex: 1;
            overflow-y: auto;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid #f0f2f5;
        }

        .contact-item:hover {
            background: #f2f3f5;
        }

        .contact-item.active {
            background: #e7f3ff;
        }

        .contact-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
            background: #d0d0d0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            font-weight: 600;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-name {
            font-weight: 600;
            font-size: 15px;
            color: #050505;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-last-message {
            font-size: 13px;
            color: #65676b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-time {
            font-size: 12px;
            color: #65676b;
        }

        /* Chat Area Styles */
        .messenger-chat {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .chat-header {
            padding: 12px 16px;
            border-bottom: 1px solid #e4e6eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
            background: #d0d0d0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            font-weight: 600;
        }

        .chat-user-name {
            font-weight: 600;
            font-size: 15px;
            color: #050505;
        }

        .chat-status {
            font-size: 12px;
            color: #65676b;
        }

        .chat-status.online {
            color: #31a24c;
        }

        .chat-actions button {
            background: none;
            border: none;
            color: #0084ff;
            font-size: 20px;
            margin-left: 12px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
        }

        .chat-actions button:hover {
            background: #f2f3f5;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background: white;
        }

        .message-item {
            display: flex;
            margin-bottom: 8px;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-item.sent {
            justify-content: flex-end;
        }

        .message-content {
            max-width: 60%;
            padding: 8px 12px;
            border-radius: 18px;
            word-wrap: break-word;
        }

        .message-item.received .message-content {
            background: #e4e6eb;
            color: #050505;
        }

        .message-item.sent .message-content {
            background: #0084ff;
            color: white;
        }

        .message-time {
            font-size: 11px;
            color: #65676b;
            margin-top: 4px;
            padding: 0 12px;
        }

        .chat-input-container {
            padding: 12px 16px;
            border-top: 1px solid #e4e6eb;
            background: white;
        }

        .chat-input-form {
            display: flex;
            align-items: center;
            background: #f0f2f5;
            border-radius: 24px;
            padding: 8px 12px;
        }

        .chat-input-form button.emoji-btn,
        .chat-input-form button.attach-btn {
            background: none;
            border: none;
            color: #0084ff;
            font-size: 20px;
            cursor: pointer;
            padding: 4px 8px;
        }

        .chat-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 8px 12px;
            font-size: 15px;
            resize: none;
            max-height: 100px;
        }

        .chat-input:focus {
            outline: none;
        }

        .send-btn {
            background: none;
            border: none;
            color: #0084ff;
            font-size: 20px;
            cursor: pointer;
            padding: 4px 8px;
            transition: transform 0.2s;
        }

        .send-btn:hover {
            transform: scale(1.1);
        }

        .send-btn:disabled {
            color: #bcc0c4;
            cursor: not-allowed;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #65676b;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 16px;
            color: #bcc0c4;
        }

        .empty-state h5 {
            margin-bottom: 8px;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0084ff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .typing-indicator {
            display: none;
            padding: 8px 12px;
            margin-bottom: 8px;
        }

        .typing-indicator.active {
            display: block;
        }

        .typing-dots {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            background: #e4e6eb;
            border-radius: 18px;
        }

        .typing-dots span {
            height: 8px;
            width: 8px;
            background: #65676b;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
            animation: typing 1.4s infinite;
        }

        .typing-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: 0.7;
            }
            30% {
                transform: translateY(-10px);
                opacity: 1;
            }
        }

        .connection-status {
            padding: 8px 16px;
            text-align: center;
            font-size: 13px;
            display: none;
        }

        .connection-status.connecting {
            display: block;
            background: #fff3cd;
            color: #856404;
        }

        .connection-status.connected {
            display: block;
            background: #d4edda;
            color: #155724;
        }

        .connection-status.disconnected {
            display: block;
            background: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .messenger-sidebar {
                width: 100%;
            }

            .messenger-sidebar.chat-active {
                display: none;
            }

            .messenger-chat {
                width: 100%;
            }

            .message-content {
                max-width: 80%;
            }
        }
    </style>
</head>
<body>
    <div id="connectionStatus" class="connection-status connecting">
        <i class="fas fa-circle-notch fa-spin"></i> Connecting to ZegoCloud...
    </div>

    <div class="messenger-container">
        <!-- Sidebar with contacts -->
        <div class="messenger-sidebar" id="messengerSidebar">
            <div class="messenger-header">
                <h4>Chats</h4>
            </div>

            <div class="messenger-search">
                <input type="text" class="search-input" id="searchInput" placeholder="Search messages...">
            </div>

            <div class="contacts-list" id="contactsList">
                <!-- Contacts will be loaded here -->
                <div class="text-center p-4">
                    <div class="loading-spinner"></div>
                    <p class="mt-2 text-muted">Loading contacts...</p>
                </div>
            </div>
        </div>

        <!-- Chat area -->
        <div class="messenger-chat" id="messengerChat">
            <div class="empty-state" id="emptyState">
                <i class="far fa-comments"></i>
                <h5>Select a conversation</h5>
                <p>Choose a contact from the sidebar to start messaging</p>
            </div>

            <!-- Chat content (hidden by default) -->
            <div id="chatContent" style="display: none; flex-direction: column; flex: 1;">
                <div class="chat-header">
                    <div class="chat-header-info">
                        <div class="chat-avatar" id="chatAvatar"></div>
                        <div>
                            <div class="chat-user-name" id="chatUserName">User Name</div>
                            <div class="chat-status" id="chatStatus">Online</div>
                        </div>
                    </div>
                    <div class="chat-actions">
                        <button type="button" onclick="makeVideoCall()" title="Video Call">
                            <i class="fas fa-video"></i>
                        </button>
                        <button type="button" onclick="makeAudioCall()" title="Audio Call">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button type="button" onclick="showInfo()" title="Info">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <!-- Messages will be loaded here -->
                </div>

                <div class="typing-indicator" id="typingIndicator">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div class="chat-input-container">
                    <form class="chat-input-form" id="messageForm">
                        <button type="button" class="emoji-btn">
                            <i class="far fa-smile"></i>
                        </button>
                        <button type="button" class="attach-btn">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <textarea class="chat-input" id="messageInput" placeholder="Type a message..." rows="1"></textarea>
                        <button type="submit" class="send-btn" id="sendBtn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ZegoCloud ZIM SDK - Pinned to stable version -->
    <script src="https://unpkg.com/zego-zim-web@2.9.0/index.js"></script>

    <!-- Debug Mode: Add ?debug=1 to URL to enable -->
    @if(request()->has('debug'))
    <script src="{{ asset('js/zegochat/debug.js') }}?v={{ time() }}"></script>
    @else
    <!-- Custom JS -->
    <script src="{{ asset('js/zegochat/app.js') }}?v={{ time() }}"></script>
    @endif
</body>
</html>
