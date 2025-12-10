/**
 * ZegoCloud Messenger Application
 * Main JavaScript file for handling ZegoCloud ZIM messaging
 */

(function() {
    'use strict';

    // Global variables
    let zimInstance = null;
    let currentUserId = null;
    let currentUserName = null;
    let activeConversationId = null;
    let conversations = {};
    let messageHistory = {};
    let contacts = [];

    // Configuration
    const CONFIG = {
        appId: null,
        token: null,
        apiBaseUrl: '/zego',
    };

    // DOM Elements
    const DOM = {
        connectionStatus: document.getElementById('connectionStatus'),
        contactsList: document.getElementById('contactsList'),
        searchInput: document.getElementById('searchInput'),
        emptyState: document.getElementById('emptyState'),
        chatContent: document.getElementById('chatContent'),
        chatAvatar: document.getElementById('chatAvatar'),
        chatUserName: document.getElementById('chatUserName'),
        chatStatus: document.getElementById('chatStatus'),
        chatMessages: document.getElementById('chatMessages'),
        typingIndicator: document.getElementById('typingIndicator'),
        messageForm: document.getElementById('messageForm'),
        messageInput: document.getElementById('messageInput'),
        sendBtn: document.getElementById('sendBtn'),
    };

    /**
     * Initialize the application
     */
    async function init() {
        try {
            console.log('Initializing ZegoCloud Messenger...');

            // Get current user info from meta tags
            currentUserId = document.querySelector('meta[name="user-id"]')?.content;
            currentUserName = document.querySelector('meta[name="user-name"]')?.content;

            if (!currentUserId) {
                throw new Error('User ID not found. Please login first.');
            }

            // Setup event listeners
            setupEventListeners();

            // Get authentication token from server
            await getAuthToken();

            // Initialize ZegoCloud ZIM SDK
            await initializeZIM();

            // Load contacts
            await loadContacts();

        } catch (error) {
            console.error('Initialization error:', error);
            showConnectionStatus('disconnected', 'Failed to connect: ' + error.message);
        }
    }

    /**
     * Get authentication token from server
     */
    async function getAuthToken() {
        try {
            // Add cache buster to ensure fresh token
            const cacheBuster = new Date().getTime();
            const response = await fetch(CONFIG.apiBaseUrl + '/get-token?_=' + cacheBuster, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache'
                },
                cache: 'no-store',
                body: JSON.stringify({
                    user_id: currentUserId
                })
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error('Failed to get authentication token: ' + response.status + ' - ' + errorText);
            }

            const data = await response.json();

            if (!data.success || !data.app_id || !data.token) {
                throw new Error(data.error || data.message || 'Invalid token response');
            }

            CONFIG.appId = Number(data.app_id);
            CONFIG.token = data.token;

            console.log('==== TOKEN RECEIVED ====');
            console.log('App ID:', CONFIG.appId);
            console.log('User ID:', data.user_id);
            console.log('Token length:', CONFIG.token.length);
            console.log('Token version:', CONFIG.token.substring(0, 2));
            console.log('Token (first 50 chars):', CONFIG.token.substring(0, 50) + '...');
            console.log('Expires in:', data.expires_in_seconds, 'seconds');
            console.log('Expires at:', new Date(data.expires_at * 1000).toLocaleString());
            console.log('Current time:', new Date().toLocaleString());
            console.log('=======================');
        } catch (error) {
            console.error('Error getting auth token:', error);
            throw error;
        }
    }

    /**
     * Initialize ZegoCloud ZIM SDK
     */
    async function initializeZIM() {
        try {
            console.log('Initializing ZIM SDK...');

            // Check if ZIM SDK is loaded
            if (typeof ZIM === 'undefined') {
                throw new Error('ZIM SDK not loaded. Please check your internet connection and reload the page.');
            }

            // Create ZIM instance
            try {
                zimInstance = ZIM.create({ appID: Number(CONFIG.appId) });
            } catch (createError) {
                // If create fails, try to get existing instance
                console.log('Creating new instance failed, attempting to get existing instance...');
                zimInstance = ZIM.getInstance();
            }

            if (!zimInstance) {
                throw new Error('Failed to create ZIM instance. App ID might be invalid.');
            }

            console.log('ZIM instance created successfully');

            // Set up event listeners
            setupZIMEventListeners();

            // Login to ZIM
            const userInfo = {
                userID: String(currentUserId),
                userName: currentUserName || 'User ' + currentUserId
            };

            console.log('Attempting to login to ZIM...', userInfo);
            await loginToZIM(userInfo);

            console.log('Successfully logged in to ZIM');
            showConnectionStatus('connected', 'Connected');

            // Auto-hide success message after 2 seconds
            setTimeout(() => {
                DOM.connectionStatus.style.display = 'none';
            }, 2000);

        } catch (error) {
            console.error('ZIM initialization error:', error);
            showConnectionStatus('disconnected', 'Connection failed: ' + error.message);
            throw error;
        }
    }

    /**
     * Setup ZIM event listeners
     */
    function setupZIMEventListeners() {
        // Listen for incoming messages
        zimInstance.on('peerMessageReceived', function(zim, { messageList, fromConversationID }) {
            console.log('Messages received:', messageList, 'from:', fromConversationID);
            handleIncomingMessages(messageList, fromConversationID);
        });

        // Listen for connection state changes
        zimInstance.on('connectionStateChanged', function(zim, { state, event, extendedData }) {
            console.log('Connection state changed:', state, event);

            if (state === 0 && event === 3) {
                // Disconnected, try to reconnect
                showConnectionStatus('connecting', 'Reconnecting...');
                const userInfo = {
                    userID: String(currentUserId),
                    userName: currentUserName
                };
                zimInstance.login(userInfo, CONFIG.token).catch(err => {
                    console.error('Re-login failed:', err);
                    showConnectionStatus('disconnected', `Reconnect failed (${err.code || ''}): ${err.message || 'Unknown'}`);
                });
            } else if (state === 1) {
                // Connected
                showConnectionStatus('connected', 'Connected');
            } else if (state === 2) {
                // Connecting
                showConnectionStatus('connecting', 'Connecting...');
            }
        });

        // Listen for errors
        zimInstance.on('error', function(zim, errorInfo) {
            console.error('ZIM error:', errorInfo.code, errorInfo.message);
            showConnectionStatus('disconnected', 'Error: ' + errorInfo.message);
        });

        // Listen for conversation changes
        zimInstance.on('conversationChanged', function(zim, { infoList }) {
            console.log('Conversations changed:', infoList);
            updateConversationsList(infoList);
        });

        // Refresh token before expiry
        zimInstance.on('tokenWillExpire', async function() {
            console.log('Token will expire soon, refreshing...');
            try {
                await getAuthToken();
                await zimInstance.renewToken(CONFIG.token);
            } catch (err) {
                console.error('Failed to renew token', err);
            }
        });
    }

    /**
     * Login helper with retry on token failure
     */
    async function loginToZIM(userInfo, hasRetried = false) {
        try {
            console.log('==== ATTEMPTING ZIM LOGIN ====');
            console.log('User Info:', userInfo);
            console.log('App ID:', CONFIG.appId);
            console.log('Token (first 30):', CONFIG.token.substring(0, 30) + '...');
            console.log('==============================');

            await zimInstance.login(userInfo, CONFIG.token);

            console.log('✅ ZIM LOGIN SUCCESSFUL!');
        } catch (error) {
            console.error('==== ZIM LOGIN FAILED ====');
            console.error('Error Code:', error.code);
            console.error('Error Message:', error.message);
            console.error('Full Error:', JSON.stringify(error, null, 2));
            console.error('=========================');

            if (!hasRetried && (error.code === 6000103 || error.code === 6000106)) {
                // Token invalid or expired; fetch a fresh token and retry once
                console.log('Attempting token refresh and re-login due to error ' + error.code + '...');
                await getAuthToken();
                return loginToZIM(userInfo, true);
            }
            showConnectionStatus('disconnected', `Login failed (${error.code || 'n/a'}): ${error.message || 'Unknown error'}`);
            throw error;
        }
    }

    /**
     * Setup DOM event listeners
     */
    function setupEventListeners() {
        // Message form submission
        DOM.messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage();
        });

        // Auto-resize textarea
        DOM.messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Search functionality
        DOM.searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterContacts(searchTerm);
        });

        // Enter key to send (Shift+Enter for new line)
        DOM.messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }

    /**
     * Load contacts from server
     */
    async function loadContacts() {
        try {
            const response = await fetch(CONFIG.apiBaseUrl + '/get-contacts', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                throw new Error('Failed to load contacts');
            }

            const data = await response.json();
            contacts = data.contacts || [];

            renderContacts();

        } catch (error) {
            console.error('Error loading contacts:', error);
            DOM.contactsList.innerHTML = '<div class="text-center p-4 text-danger">Failed to load contacts</div>';
        }
    }

    /**
     * Render contacts list
     */
    function renderContacts() {
        if (contacts.length === 0) {
            DOM.contactsList.innerHTML = '<div class="text-center p-4 text-muted">No contacts found</div>';
            return;
        }

        let html = '';
        contacts.forEach(contact => {
            const avatar = contact.profile_photo_url || getInitials(contact.name);
            const isAvatar = contact.profile_photo_url ? `<img src="${avatar}" alt="${contact.name}" class="contact-avatar">` :
                           `<div class="contact-avatar" style="background: ${getRandomColor(contact.id)}">${avatar}</div>`;

            html += `
                <div class="contact-item" data-user-id="${contact.id}" onclick="selectContact(${contact.id}, '${contact.name}', '${contact.profile_photo_url || ''}')">
                    ${isAvatar}
                    <div class="contact-info">
                        <div class="contact-name">${escapeHtml(contact.name)}</div>
                        <div class="contact-last-message">Click to start chatting</div>
                    </div>
                    <div class="contact-time"></div>
                </div>
            `;
        });

        DOM.contactsList.innerHTML = html;
    }

    /**
     * Filter contacts by search term
     */
    function filterContacts(searchTerm) {
        const contactItems = DOM.contactsList.querySelectorAll('.contact-item');

        contactItems.forEach(item => {
            const name = item.querySelector('.contact-name').textContent.toLowerCase();
            if (name.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    /**
     * Select a contact to chat with
     */
    window.selectContact = async function(userId, userName, avatarUrl) {
        activeConversationId = String(userId);

        // Update active state
        document.querySelectorAll('.contact-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelector(`[data-user-id="${userId}"]`)?.classList.add('active');

        // Show chat content
        DOM.emptyState.style.display = 'none';
        DOM.chatContent.style.display = 'flex';

        // Update chat header
        if (avatarUrl) {
            DOM.chatAvatar.innerHTML = `<img src="${avatarUrl}" alt="${userName}" style="width: 100%; height: 100%; border-radius: 50%;">`;
        } else {
            DOM.chatAvatar.style.background = getRandomColor(userId);
            DOM.chatAvatar.textContent = getInitials(userName);
        }
        DOM.chatUserName.textContent = userName;
        DOM.chatStatus.textContent = 'Online';
        DOM.chatStatus.classList.add('online');

        // Clear messages
        DOM.chatMessages.innerHTML = '';

        // Load message history
        await loadMessageHistory(activeConversationId);

        // Focus input
        DOM.messageInput.focus();
    };

    /**
     * Load message history for a conversation
     */
    async function loadMessageHistory(conversationId) {
        try {
            const config = {
                conversationID: conversationId,
                conversationType: 0, // 0 = peer (one-to-one)
                count: 30,
                nextMessage: null
            };

            const result = await zimInstance.queryHistoryMessage(config);

            if (result.messageList && result.messageList.length > 0) {
                // Reverse to show oldest first
                const messages = result.messageList.reverse();
                messages.forEach(message => {
                    displayMessage(message, false);
                });

                // Scroll to bottom
                scrollToBottom();
            }

        } catch (error) {
            console.error('Error loading message history:', error);
        }
    }

    /**
     * Send a message
     */
    async function sendMessage() {
        const messageText = DOM.messageInput.value.trim();

        if (!messageText || !activeConversationId) {
            return;
        }

        if (!zimInstance) {
            showConnectionStatus('disconnected', 'Not connected');
            return;
        }

        try {
            // Build a proper ZIM text message
            const textMessage = zimInstance.createTextMessage(messageText);

            const config = {
                priority: 2 // 2 = Medium priority
            };

            const notification = {
                onMessageAttached: function(message) {
                    // Message is being sent - show in UI immediately
                    displayMessage(message, true);
                    DOM.messageInput.value = '';
                    DOM.messageInput.style.height = 'auto';
                    scrollToBottom();
                }
            };

            // Send message
            const result = await zimInstance.sendMessage(
                textMessage,
                activeConversationId,
                0, // 0 = one-to-one conversation
                config,
                notification
            );

            console.log('Message sent successfully:', result);

        } catch (error) {
            console.error('Error sending message:', error);
            showConnectionStatus('disconnected', `Send failed (${error.code || 'n/a'}): ${error.message || 'Unknown error'}`);
            alert('Failed to send message. Please try again.');
        }
    }

    /**
     * Handle incoming messages
     */
    function handleIncomingMessages(messageList, fromConversationID) {
        messageList.forEach(message => {
            // Display message if it's from the active conversation
            if (fromConversationID === activeConversationId) {
                displayMessage(message, false);
                scrollToBottom();
            }

            // Update conversation in sidebar
            updateConversationInList(fromConversationID, message);
        });
    }

    /**
     * Display a message in the chat
     */
    function displayMessage(message, isSent) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message-item ${isSent ? 'sent' : 'received'}`;

        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        messageContent.textContent = message.message || message.text || '';

        messageDiv.appendChild(messageContent);

        // Add timestamp
        if (message.timestamp) {
            const timeDiv = document.createElement('div');
            timeDiv.className = 'message-time';
            timeDiv.textContent = formatMessageTime(message.timestamp);
            messageDiv.appendChild(timeDiv);
        }

        DOM.chatMessages.appendChild(messageDiv);
    }

    /**
     * Update conversation in the contacts list
     */
    function updateConversationInList(conversationId, message) {
        const contactItem = document.querySelector(`[data-user-id="${conversationId}"]`);
        if (contactItem) {
            const lastMessageEl = contactItem.querySelector('.contact-last-message');
            const timeEl = contactItem.querySelector('.contact-time');

            if (lastMessageEl) {
                const preview = message.message || message.text || '';
                lastMessageEl.textContent = preview.substring(0, 50) + (preview.length > 50 ? '...' : '');
            }

            if (timeEl && message.timestamp) {
                timeEl.textContent = formatMessageTime(message.timestamp);
            }

            // Move to top of list
            DOM.contactsList.insertBefore(contactItem, DOM.contactsList.firstChild);
        }
    }

    /**
     * Update conversations list
     */
    function updateConversationsList(infoList) {
        infoList.forEach(info => {
            conversations[info.conversationID] = info;
        });
    }

    /**
     * Show connection status
     */
    function showConnectionStatus(status, message) {
        DOM.connectionStatus.className = 'connection-status ' + status;

        const icons = {
            connecting: '<i class="fas fa-circle-notch fa-spin"></i>',
            connected: '<i class="fas fa-check-circle"></i>',
            disconnected: '<i class="fas fa-exclamation-circle"></i>'
        };

        DOM.connectionStatus.innerHTML = (icons[status] || '') + ' ' + message;
        DOM.connectionStatus.style.display = 'block';
    }

    /**
     * Scroll chat messages to bottom
     */
    function scrollToBottom() {
        setTimeout(() => {
            DOM.chatMessages.scrollTop = DOM.chatMessages.scrollHeight;
        }, 100);
    }

    /**
     * Format timestamp for display
     */
    function formatMessageTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diffInHours = (now - date) / (1000 * 60 * 60);

        if (diffInHours < 24) {
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        } else if (diffInHours < 48) {
            return 'Yesterday';
        } else {
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }
    }

    /**
     * Get initials from name
     */
    function getInitials(name) {
        if (!name) return '?';
        const parts = name.trim().split(' ');
        if (parts.length >= 2) {
            return (parts[0][0] + parts[1][0]).toUpperCase();
        }
        return name.substring(0, 2).toUpperCase();
    }

    /**
     * Get random color for avatar
     */
    function getRandomColor(seed) {
        const colors = [
            '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e',
            '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50',
            '#f39c12', '#e67e22', '#e74c3c', '#95a5a6', '#d35400'
        ];
        const index = Math.abs(parseInt(seed) || 0) % colors.length;
        return colors[index];
    }

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Placeholder functions for buttons
     */
    window.makeVideoCall = function() {
        if (!activeConversationId) return;
        alert('Video call feature - integrate with your existing ZegoCloud video call system');
        // You can integrate with your existing ZegoCloud video call implementation
    };

    window.makeAudioCall = function() {
        if (!activeConversationId) return;
        alert('Audio call feature - integrate with your existing ZegoCloud audio call system');
        // You can integrate with your existing ZegoCloud audio call implementation
    };

    window.showInfo = function() {
        if (!activeConversationId) return;
        alert('User info panel - to be implemented');
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
