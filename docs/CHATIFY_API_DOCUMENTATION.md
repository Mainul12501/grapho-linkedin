# Chatify API Integration Documentation

> **Version:** 1.0
> **Last Updated:** December 2025
> **Base URL:** `http://127.0.0.1:8000`

---

## Table of Contents

1. [Overview](#overview)
2. [Authentication](#authentication)
3. [API Routes Reference](#api-routes-reference)
4. [Web Routes Reference](#web-routes-reference)
5. [Integration Flow & Wireframe](#integration-flow--wireframe)
6. [Step-by-Step Integration Guide](#step-by-step-integration-guide)
7. [Feature Implementation](#feature-implementation)
8. [Code Examples](#code-examples)
9. [Error Handling](#error-handling)
10. [Testing Guide](#testing-guide)

---

## Overview

Chatify is a real-time messaging system integrated with your Laravel application. This documentation provides a complete guide for mobile app integration using the API endpoints.

### Key Features

- ✅ Real-time messaging with Pusher
- ✅ File/Image attachments
- ✅ Message seen/unseen status
- ✅ Favorites/Star contacts
- ✅ Search contacts
- ✅ Delete for Me (Like Facebook Messenger)
- ✅ Dark/Light mode
- ✅ Typing indicators
- ✅ Shared photos

---

## Authentication

All API requests require authentication using Laravel Sanctum or your authentication system.

### Headers Required

```http
Authorization: Bearer YOUR_ACCESS_TOKEN
Content-Type: application/json
Accept: application/json
```

### CSRF Token (For Web Routes)

Web routes require CSRF token in the request body:

```json
{
  "_token": "csrf_token_value"
}
```

---

## API Routes Reference

### Base Path: `/api`

| Method | Endpoint | Name | Description |
|--------|----------|------|-------------|
| **Authentication & Setup** |
| POST | `/chat/auth` | api.pusher.auth | Authenticate Pusher private channel |
| POST | `/idInfo` | api.idInfo | Fetch user/contact information |
| POST | `/setActiveStatus` | api.activeStatus.set | Set user's active/inactive status |
| **Messaging** |
| POST | `/sendMessage` | api.send.message | Send a new message |
| POST | `/fetchMessages` | api.fetch.messages | Fetch messages with pagination |
| POST | `/makeSeen` | api.messages.seen | Mark messages as seen |
| **Contacts & Search** |
| GET | `/getContacts` | api.contacts.get | Get contact list (excludes deleted conversations) |
| GET | `/search` | api.search | Search users/contacts |
| **Favorites** |
| POST | `/star` | api.star | Add/remove from favorites |
| POST | `/favorites` | api.favorites | Get favorites list |
| **Media** |
| GET | `/download/{fileName}` | api.attachments.download | Download attachment |
| POST | `/shared` | api.shared | Get shared photos |
| **Conversation Management** |
| POST | `/deleteConversation` | api.conversation.delete | ⚠️ Hard delete (both users) |
| POST | `/deleteConversationForMe` | api.conversation.delete.for.me | ✅ Soft delete (current user only) |
| **Settings** |
| POST | `/updateSettings` | api.avatar.update | Update user settings/avatar |

---

## Web Routes Reference

### Base Path: `/chat`

| Method | Endpoint | Name | Description |
|--------|----------|------|-------------|
| GET | `/` | chat | Main chat view |
| GET | `/{id}` | user | Open chat with specific user |
| GET | `/group/{id}` | group | Open group chat |
| POST | `/chat/auth` | pusher.auth | Pusher authentication |
| POST | `/idInfo` | - | Fetch user info |
| POST | `/sendMessage` | send.message | Send message |
| POST | `/fetchMessages` | fetch.messages | Fetch messages |
| POST | `/makeSeen` | messages.seen | Mark as seen |
| GET | `/getContacts` | contacts.get | Get contacts |
| POST | `/updateContacts` | contacts.update | Update contact item |
| POST | `/star` | star | Toggle favorite |
| POST | `/favorites` | favorites | Get favorites |
| GET | `/search` | search | Search users |
| POST | `/shared` | shared | Shared photos |
| POST | `/deleteConversation` | conversation.delete | Hard delete |
| POST | `/deleteConversationForMe` | conversation.delete.for.me | Soft delete |
| POST | `/deleteMessage` | message.delete | Delete single message |
| POST | `/updateSettings` | avatar.update | Update settings |
| POST | `/setActiveStatus` | activeStatus.set | Set active status |
| GET | `/download/{fileName}` | attachments.download | Download file |

---

## Integration Flow & Wireframe

### Initial App Launch Flow

```
┌─────────────────────────────────────────────────────────────┐
│                     APP LAUNCH                              │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 1: User Authentication                                │
│  ─────────────────────────────────────────────────────────  │
│  Your app's login/register flow                            │
│  GET Bearer Token                                           │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 2: Set User Active Status                            │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/setActiveStatus                                  │
│  Body: { "status": 1 }                                      │
│  Purpose: Mark user as online                               │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 3: Initialize Pusher                                 │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/chat/auth                                        │
│  Body: {                                                    │
│    "socket_id": "pusher_socket_id",                        │
│    "channel_name": "private-chatify.{user_id}"             │
│  }                                                          │
│  Purpose: Authenticate Pusher private channel              │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 4: Load Contacts List                                │
│  ─────────────────────────────────────────────────────────  │
│  GET /api/getContacts?page=1                                │
│  Response: List of users with recent messages               │
│  Purpose: Show chat list screen                            │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 5: Load Favorites (Optional)                         │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/favorites                                        │
│  Purpose: Show favorite contacts                            │
└─────────────────────────────────────────────────────────────┘
```

---

### Opening a Chat Conversation Flow

```
┌─────────────────────────────────────────────────────────────┐
│              USER CLICKS ON A CONTACT                       │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 1: Fetch User Info                                   │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/idInfo                                           │
│  Body: { "id": "contact_user_id", "type": "user" }         │
│  Purpose: Get user details, avatar, favorite status        │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 2: Fetch Messages                                    │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/fetchMessages                                    │
│  Body: { "id": "contact_user_id", "page": 1 }              │
│  Purpose: Load conversation history                         │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 3: Subscribe to Pusher Events                        │
│  ─────────────────────────────────────────────────────────  │
│  Subscribe to: private-chatify.{current_user_id}           │
│  Listen for:                                                │
│    - messaging (new messages)                               │
│    - client-typing (typing indicator)                       │
│    - client-seen (message seen)                             │
│    - client-messageDelete (message deleted)                 │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 4: Mark Messages as Seen                             │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/makeSeen                                         │
│  Body: { "id": "contact_user_id" }                         │
│  Purpose: Update seen status                                │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 5: Get Shared Photos (Optional)                      │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/shared                                           │
│  Body: { "user_id": "contact_user_id" }                    │
│  Purpose: Show shared media gallery                         │
└─────────────────────────────────────────────────────────────┘
```

---

### Sending a Message Flow

```
┌─────────────────────────────────────────────────────────────┐
│              USER TYPES & SENDS MESSAGE                     │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 1: Trigger Typing Indicator (Optional)               │
│  ─────────────────────────────────────────────────────────  │
│  Pusher Client Event: client-typing                         │
│  Channel: private-chatify.{contact_id}                      │
│  Data: { "from_id": current_user, "typing": true }         │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 2: Send Message                                      │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/sendMessage                                      │
│  Body: {                                                    │
│    "id": "contact_user_id",                                │
│    "message": "Hello!",                                     │
│    "type": "user",                                          │
│    "temporaryMsgId": "temp_123",                            │
│    "file": (optional file upload)                           │
│  }                                                          │
│  Purpose: Send message to database & Pusher                │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 3: Update UI                                         │
│  ─────────────────────────────────────────────────────────  │
│  - Remove temporary message                                 │
│  - Add server message with ID                              │
│  - Scroll to bottom                                         │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 4: Listen for Seen Event                            │
│  ─────────────────────────────────────────────────────────  │
│  Pusher Event: client-seen                                  │
│  Update message status to "seen"                            │
└─────────────────────────────────────────────────────────────┘
```

---

### Delete Conversation Flow (Delete for Me)

```
┌─────────────────────────────────────────────────────────────┐
│         USER CLICKS "DELETE CONVERSATION"                   │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 1: Show Confirmation Dialog                          │
│  ─────────────────────────────────────────────────────────  │
│  "This will only delete for you.                           │
│   The other person will still see it."                     │
│  [Cancel] [Delete for Me]                                  │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 2: Call Delete API                                   │
│  ─────────────────────────────────────────────────────────  │
│  POST /api/deleteConversationForMe                          │
│  Body: { "id": "contact_user_id" }                         │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 3: Handle Response                                   │
│  ─────────────────────────────────────────────────────────  │
│  IF permanent = false:                                      │
│    - "Conversation deleted for you"                         │
│    - Remove from local contact list                         │
│    - Messages still in DB (other user can see)             │
│                                                             │
│  IF permanent = true:                                       │
│    - "Conversation permanently deleted"                     │
│    - Remove from local contact list                         │
│    - Messages deleted from DB (both users deleted it)      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  STEP 4: Refresh Contacts List                            │
│  ─────────────────────────────────────────────────────────  │
│  GET /api/getContacts                                       │
│  Purpose: Get updated contact list without deleted chat    │
└─────────────────────────────────────────────────────────────┘
```

---

## Step-by-Step Integration Guide

### Phase 1: Basic Setup

#### 1.1 Install Dependencies

**iOS (Swift):**
```swift
// Podfile
pod 'Pusher'
pod 'Alamofire'
```

**Android (Kotlin):**
```gradle
// build.gradle
implementation 'com.pusher:pusher-java-client:2.4.0'
implementation 'com.squareup.retrofit2:retrofit:2.9.0'
```

**React Native:**
```bash
npm install pusher-js axios
```

**Flutter:**
```yaml
# pubspec.yaml
dependencies:
  pusher_client: ^2.0.0
  dio: ^5.0.0
```

---

#### 1.2 Configure API Client

**Example (React Native):**
```javascript
import axios from 'axios';

const API_BASE_URL = 'http://127.0.0.1:8000/api';

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Add auth token interceptor
apiClient.interceptors.request.use((config) => {
  const token = getAuthToken(); // Your token storage
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default apiClient;
```

---

#### 1.3 Initialize Pusher

**Example (React Native):**
```javascript
import Pusher from 'pusher-js';

const initPusher = async (userId) => {
  const pusher = new Pusher('YOUR_PUSHER_KEY', {
    cluster: 'YOUR_CLUSTER',
    encrypted: true,
    authEndpoint: `${API_BASE_URL}/chat/auth`,
    auth: {
      headers: {
        Authorization: `Bearer ${getAuthToken()}`,
      },
    },
  });

  const channel = pusher.subscribe(`private-chatify.${userId}`);

  // Listen for new messages
  channel.bind('messaging', (data) => {
    console.log('New message:', data);
    handleNewMessage(data);
  });

  // Listen for typing indicator
  channel.bind('client-typing', (data) => {
    console.log('User typing:', data);
    handleTypingIndicator(data);
  });

  // Listen for seen event
  channel.bind('client-seen', (data) => {
    console.log('Message seen:', data);
    handleMessageSeen(data);
  });

  // Listen for message delete
  channel.bind('client-messageDelete', (data) => {
    console.log('Message deleted:', data);
    handleMessageDelete(data);
  });

  return pusher;
};
```

---

### Phase 2: Core Features Implementation

#### 2.1 Get Contacts List

```javascript
const getContacts = async (page = 1) => {
  try {
    const response = await apiClient.get('/getContacts', {
      params: { page, per_page: 30 }
    });

    return {
      contacts: response.data.contacts,
      totalPages: response.data.last_page,
      total: response.data.total
    };
  } catch (error) {
    console.error('Error fetching contacts:', error);
    throw error;
  }
};

// Usage
const loadContacts = async () => {
  const { contacts, totalPages } = await getContacts(1);
  setContactsList(contacts);
};
```

---

#### 2.2 Fetch Messages

```javascript
const fetchMessages = async (contactId, page = 1) => {
  try {
    const response = await apiClient.post('/fetchMessages', {
      id: contactId,
      page: page,
      per_page: 30
    });

    return {
      messages: response.data.messages,
      total: response.data.total,
      lastPage: response.data.last_page
    };
  } catch (error) {
    console.error('Error fetching messages:', error);
    throw error;
  }
};

// Usage
const loadMessages = async (contactId) => {
  const { messages } = await fetchMessages(contactId, 1);
  setMessages(messages);
  markAsSeen(contactId);
};
```

---

#### 2.3 Send Message

```javascript
const sendMessage = async (contactId, messageText, file = null) => {
  const tempId = `temp_${Date.now()}`;

  // Show temporary message in UI
  addTemporaryMessage({
    id: tempId,
    body: messageText,
    from_id: currentUserId,
    created_at: new Date().toISOString()
  });

  try {
    const formData = new FormData();
    formData.append('id', contactId);
    formData.append('message', messageText);
    formData.append('type', 'user');
    formData.append('temporaryMsgId', tempId);

    if (file) {
      formData.append('file', file);
    }

    const response = await apiClient.post('/sendMessage', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });

    // Replace temporary message with server message
    replaceTemporaryMessage(tempId, response.data.message);

    return response.data;
  } catch (error) {
    // Show error on temporary message
    markMessageAsError(tempId);
    throw error;
  }
};

// Usage
await sendMessage(contactId, 'Hello!');
```

---

#### 2.4 Mark Messages as Seen

```javascript
const markAsSeen = async (contactId) => {
  try {
    await apiClient.post('/makeSeen', {
      id: contactId
    });

    // Update UI - mark all messages as seen
    updateMessagesSeenStatus(contactId);
  } catch (error) {
    console.error('Error marking as seen:', error);
  }
};

// Call this when:
// 1. User opens a conversation
// 2. App comes to foreground with conversation open
// 3. New message arrives while conversation is open
```

---

#### 2.5 Search Contacts

```javascript
const searchContacts = async (searchQuery, page = 1) => {
  try {
    const response = await apiClient.get('/search', {
      params: {
        input: searchQuery,
        page: page,
        per_page: 30
      }
    });

    return {
      results: response.data.records,
      total: response.data.total,
      lastPage: response.data.last_page
    };
  } catch (error) {
    console.error('Error searching:', error);
    throw error;
  }
};

// Usage
const handleSearch = async (query) => {
  if (query.length > 0) {
    const { results } = await searchContacts(query);
    setSearchResults(results);
  }
};
```

---

#### 2.6 Delete Conversation (Delete for Me)

```javascript
const deleteConversationForMe = async (contactId) => {
  try {
    const response = await apiClient.post('/deleteConversationForMe', {
      id: contactId
    });

    if (response.data.deleted === 1) {
      // Remove from local contacts list
      removeContactFromList(contactId);

      // Show appropriate message
      if (response.data.permanent) {
        showToast('Conversation permanently deleted');
      } else {
        showToast('Conversation deleted for you');
      }

      // Refresh contacts
      await getContacts();
    }

    return response.data;
  } catch (error) {
    console.error('Error deleting conversation:', error);
    showToast('Failed to delete conversation');
    throw error;
  }
};

// Usage with confirmation
const handleDeleteConversation = (contactId) => {
  Alert.alert(
    'Delete this conversation?',
    'This will only delete for you. The other person will still see it.',
    [
      { text: 'Cancel', style: 'cancel' },
      {
        text: 'Delete for Me',
        style: 'destructive',
        onPress: () => deleteConversationForMe(contactId)
      }
    ]
  );
};
```

---

#### 2.7 Toggle Favorite

```javascript
const toggleFavorite = async (userId) => {
  try {
    const response = await apiClient.post('/star', {
      user_id: userId
    });

    const isFavorite = response.data.status === 1;
    updateContactFavoriteStatus(userId, isFavorite);

    return isFavorite;
  } catch (error) {
    console.error('Error toggling favorite:', error);
    throw error;
  }
};
```

---

#### 2.8 Get Favorites List

```javascript
const getFavorites = async () => {
  try {
    const response = await apiClient.post('/favorites');

    return {
      favorites: response.data.favorites,
      count: response.data.total
    };
  } catch (error) {
    console.error('Error fetching favorites:', error);
    throw error;
  }
};
```

---

#### 2.9 Get Shared Photos

```javascript
const getSharedPhotos = async (userId) => {
  try {
    const response = await apiClient.post('/shared', {
      user_id: userId
    });

    return response.data.shared || [];
  } catch (error) {
    console.error('Error fetching shared photos:', error);
    throw error;
  }
};
```

---

#### 2.10 Set Active Status

```javascript
const setActiveStatus = async (isActive) => {
  try {
    await apiClient.post('/setActiveStatus', {
      status: isActive ? 1 : 0
    });
  } catch (error) {
    console.error('Error setting active status:', error);
  }
};

// Call when app launches
setActiveStatus(true);

// Call when app goes to background
setActiveStatus(false);
```

---

### Phase 3: Real-time Features

#### 3.1 Handle Incoming Messages

```javascript
const handleNewMessage = (data) => {
  // data structure:
  // {
  //   from_id: "sender_user_id",
  //   to_id: "current_user_id",
  //   message: "HTML message content"
  // }

  const { from_id, message } = data;

  // If conversation is currently open
  if (currentConversationId === from_id) {
    // Add message to current conversation
    addMessageToConversation(message);

    // Mark as seen
    markAsSeen(from_id);

    // Scroll to bottom
    scrollToBottom();
  } else {
    // Update contact list item
    updateContactLastMessage(from_id, message);

    // Show notification
    showNotification(from_id, message);

    // Increment unread count
    incrementUnreadCount(from_id);
  }
};
```

---

#### 3.2 Typing Indicator

**Send typing event:**
```javascript
let typingTimeout;

const sendTypingIndicator = (contactId, isTyping) => {
  const channel = pusher.channel(`private-chatify.${contactId}`);

  channel.trigger('client-typing', {
    from_id: currentUserId,
    to_id: contactId,
    typing: isTyping
  });
};

// Usage in input field
const handleTextChange = (text, contactId) => {
  setMessageText(text);

  // Send typing=true
  sendTypingIndicator(contactId, true);

  // Clear previous timeout
  clearTimeout(typingTimeout);

  // Set typing=false after 1 second of no typing
  typingTimeout = setTimeout(() => {
    sendTypingIndicator(contactId, false);
  }, 1000);
};
```

**Receive typing event:**
```javascript
const handleTypingIndicator = (data) => {
  // data: { from_id, to_id, typing: true/false }

  if (data.from_id === currentConversationId) {
    if (data.typing) {
      showTypingIndicator();
    } else {
      hideTypingIndicator();
    }
  }
};
```

---

#### 3.3 Message Seen Status

**Send seen event:**
```javascript
const sendSeenEvent = (contactId) => {
  const channel = pusher.channel(`private-chatify.${contactId}`);

  channel.trigger('client-seen', {
    from_id: currentUserId,
    to_id: contactId,
    seen: true
  });
};

// Call after marking as seen via API
const markAsSeen = async (contactId) => {
  await apiClient.post('/makeSeen', { id: contactId });
  sendSeenEvent(contactId);
};
```

**Receive seen event:**
```javascript
const handleMessageSeen = (data) => {
  // data: { from_id, to_id, seen: true }

  if (data.from_id === currentConversationId) {
    // Update all sent messages to "seen"
    updateAllMessagesToSeen();
  }
};
```

---

## Feature Implementation

### 1. Pagination

**Contacts Pagination:**
```javascript
const [contactsPage, setContactsPage] = useState(1);
const [hasMoreContacts, setHasMoreContacts] = useState(true);

const loadMoreContacts = async () => {
  if (!hasMoreContacts) return;

  const nextPage = contactsPage + 1;
  const { contacts, totalPages } = await getContacts(nextPage);

  setContactsList(prev => [...prev, ...contacts]);
  setContactsPage(nextPage);
  setHasMoreContacts(nextPage < totalPages);
};
```

**Messages Pagination (Load Older):**
```javascript
const [messagesPage, setMessagesPage] = useState(1);
const [hasMoreMessages, setHasMoreMessages] = useState(true);

const loadOlderMessages = async (contactId) => {
  if (!hasMoreMessages) return;

  const nextPage = messagesPage + 1;
  const { messages, lastPage } = await fetchMessages(contactId, nextPage);

  setMessages(prev => [...messages, ...prev]); // Add to beginning
  setMessagesPage(nextPage);
  setHasMoreMessages(nextPage < lastPage);
};
```

---

### 2. File Upload

```javascript
const sendImageMessage = async (contactId, imageFile) => {
  try {
    // Show image preview immediately
    const tempId = `temp_${Date.now()}`;
    addTemporaryImageMessage(tempId, imageFile);

    const formData = new FormData();
    formData.append('id', contactId);
    formData.append('message', ''); // Empty message
    formData.append('type', 'user');
    formData.append('temporaryMsgId', tempId);
    formData.append('file', {
      uri: imageFile.uri,
      type: imageFile.type,
      name: imageFile.fileName
    });

    const response = await apiClient.post('/sendMessage', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });

    replaceTemporaryMessage(tempId, response.data.message);
  } catch (error) {
    markMessageAsError(tempId);
    throw error;
  }
};
```

---

### 3. Download Attachment

```javascript
const downloadAttachment = async (fileName) => {
  try {
    const response = await apiClient.get(`/download/${fileName}`);

    // response.data contains:
    // { file_name, download_path }

    const downloadUrl = response.data.download_path;

    // Open in browser or download
    Linking.openURL(downloadUrl);
  } catch (error) {
    console.error('Error downloading:', error);
  }
};
```

---

### 4. Dark Mode

```javascript
const updateDarkMode = async (isDarkMode) => {
  try {
    const formData = new FormData();
    formData.append('dark_mode', isDarkMode ? 'dark' : 'light');

    await apiClient.post('/updateSettings', formData);

    // Update local theme
    setTheme(isDarkMode ? 'dark' : 'light');
  } catch (error) {
    console.error('Error updating dark mode:', error);
  }
};
```

---

### 5. Update Avatar

```javascript
const updateAvatar = async (imageFile) => {
  try {
    const formData = new FormData();
    formData.append('avatar', {
      uri: imageFile.uri,
      type: imageFile.type,
      name: imageFile.fileName
    });

    const response = await apiClient.post('/updateSettings', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });

    if (response.data.status === 1) {
      // Avatar updated successfully
      updateUserAvatar(imageFile.uri);
    }
  } catch (error) {
    console.error('Error updating avatar:', error);
  }
};
```

---

## Code Examples

### Complete Chat Screen Implementation (React Native)

```javascript
import React, { useState, useEffect, useRef } from 'react';
import { View, FlatList, TextInput, TouchableOpacity } from 'react-native';
import apiClient from './apiClient';
import { initPusher } from './pusherConfig';

const ChatScreen = ({ route, navigation }) => {
  const { contactId, contactName } = route.params;

  const [messages, setMessages] = useState([]);
  const [messageText, setMessageText] = useState('');
  const [loading, setLoading] = useState(true);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);
  const [isTyping, setIsTyping] = useState(false);

  const pusherRef = useRef(null);
  const flatListRef = useRef(null);

  useEffect(() => {
    loadMessages();
    setupPusher();
    markAsSeen();

    return () => {
      // Cleanup
      if (pusherRef.current) {
        pusherRef.current.disconnect();
      }
    };
  }, []);

  const loadMessages = async () => {
    try {
      const response = await apiClient.post('/fetchMessages', {
        id: contactId,
        page: page,
        per_page: 30
      });

      setMessages(response.data.messages.reverse());
      setHasMore(page < response.data.last_page);
      setLoading(false);
    } catch (error) {
      console.error('Error loading messages:', error);
      setLoading(false);
    }
  };

  const setupPusher = async () => {
    const pusher = await initPusher(currentUserId);
    pusherRef.current = pusher;

    const channel = pusher.channel(`private-chatify.${currentUserId}`);

    channel.bind('messaging', (data) => {
      if (data.from_id === contactId) {
        setMessages(prev => [...prev, data.message]);
        markAsSeen();
        scrollToBottom();
      }
    });

    channel.bind('client-typing', (data) => {
      if (data.from_id === contactId) {
        setIsTyping(data.typing);
      }
    });

    channel.bind('client-seen', (data) => {
      if (data.from_id === contactId) {
        updateMessagesSeenStatus();
      }
    });
  };

  const markAsSeen = async () => {
    try {
      await apiClient.post('/makeSeen', { id: contactId });
    } catch (error) {
      console.error('Error marking seen:', error);
    }
  };

  const sendMessage = async () => {
    if (!messageText.trim()) return;

    const tempId = `temp_${Date.now()}`;
    const tempMessage = {
      id: tempId,
      body: messageText,
      from_id: currentUserId,
      to_id: contactId,
      created_at: new Date().toISOString(),
      seen: false
    };

    // Add to UI immediately
    setMessages(prev => [...prev, tempMessage]);
    setMessageText('');
    scrollToBottom();

    try {
      const response = await apiClient.post('/sendMessage', {
        id: contactId,
        message: messageText,
        type: 'user',
        temporaryMsgId: tempId
      });

      // Replace temp message with server message
      setMessages(prev =>
        prev.map(msg => msg.id === tempId ? response.data.message : msg)
      );
    } catch (error) {
      console.error('Error sending message:', error);
      // Mark temp message as error
      setMessages(prev =>
        prev.map(msg => msg.id === tempId ? { ...msg, error: true } : msg)
      );
    }
  };

  const scrollToBottom = () => {
    setTimeout(() => {
      flatListRef.current?.scrollToEnd({ animated: true });
    }, 100);
  };

  const renderMessage = ({ item }) => (
    <MessageBubble
      message={item}
      isSender={item.from_id === currentUserId}
    />
  );

  return (
    <View style={{ flex: 1 }}>
      <FlatList
        ref={flatListRef}
        data={messages}
        renderItem={renderMessage}
        keyExtractor={item => item.id}
        onEndReached={loadOlderMessages}
        onEndReachedThreshold={0.1}
      />

      {isTyping && <TypingIndicator />}

      <View style={styles.inputContainer}>
        <TextInput
          value={messageText}
          onChangeText={setMessageText}
          placeholder="Type a message..."
          style={styles.input}
        />
        <TouchableOpacity onPress={sendMessage}>
          <Text>Send</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
};

export default ChatScreen;
```

---

## Error Handling

### Common Error Responses

```javascript
// 401 Unauthorized
{
  "message": "Unauthenticated."
}

// 404 Not Found
{
  "message": "User not found"
}

// 422 Validation Error
{
  "message": "The given data was invalid.",
  "errors": {
    "id": ["The id field is required."]
  }
}

// 500 Server Error
{
  "message": "Server Error",
  "deleted": 0
}
```

### Error Handling Implementation

```javascript
const handleApiError = (error) => {
  if (error.response) {
    // Server responded with error
    switch (error.response.status) {
      case 401:
        // Token expired or invalid
        logout();
        navigation.navigate('Login');
        break;
      case 404:
        showToast('User not found');
        break;
      case 422:
        // Validation error
        const errors = error.response.data.errors;
        showValidationErrors(errors);
        break;
      case 500:
        showToast('Server error. Please try again later.');
        break;
      default:
        showToast('An error occurred');
    }
  } else if (error.request) {
    // No response received
    showToast('Network error. Check your connection.');
  } else {
    // Other errors
    showToast('An error occurred');
  }
};

// Usage
try {
  await sendMessage(contactId, text);
} catch (error) {
  handleApiError(error);
}
```

---

## Testing Guide

### 1. Testing with Postman

**Import this collection to test all endpoints:**

```json
{
  "info": {
    "name": "Chatify API",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "item": [
    {
      "name": "Get Contacts",
      "request": {
        "method": "GET",
        "header": [
          {
            "key": "Authorization",
            "value": "Bearer {{token}}"
          }
        ],
        "url": {
          "raw": "{{base_url}}/api/getContacts?page=1",
          "host": ["{{base_url}}"],
          "path": ["api", "getContacts"],
          "query": [
            { "key": "page", "value": "1" }
          ]
        }
      }
    },
    {
      "name": "Send Message",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Authorization",
            "value": "Bearer {{token}}"
          }
        ],
        "body": {
          "mode": "formdata",
          "formdata": [
            { "key": "id", "value": "2", "type": "text" },
            { "key": "message", "value": "Hello!", "type": "text" },
            { "key": "type", "value": "user", "type": "text" },
            { "key": "temporaryMsgId", "value": "temp_123", "type": "text" }
          ]
        },
        "url": {
          "raw": "{{base_url}}/api/sendMessage",
          "host": ["{{base_url}}"],
          "path": ["api", "sendMessage"]
        }
      }
    },
    {
      "name": "Delete Conversation For Me",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Authorization",
            "value": "Bearer {{token}}"
          },
          {
            "key": "Content-Type",
            "value": "application/json"
          }
        ],
        "body": {
          "mode": "raw",
          "raw": "{\n  \"id\": \"2\"\n}"
        },
        "url": {
          "raw": "{{base_url}}/api/deleteConversationForMe",
          "host": ["{{base_url}}"],
          "path": ["api", "deleteConversationForMe"]
        }
      }
    }
  ],
  "variable": [
    {
      "key": "base_url",
      "value": "http://127.0.0.1:8000"
    },
    {
      "key": "token",
      "value": "YOUR_AUTH_TOKEN_HERE"
    }
  ]
}
```

---

### 2. Test Scenarios

#### Scenario 1: Complete Chat Flow
1. Login and get auth token
2. GET `/api/getContacts` - Should return list
3. POST `/api/idInfo` with contact ID
4. POST `/api/fetchMessages` with contact ID
5. POST `/api/sendMessage` with message
6. POST `/api/makeSeen` with contact ID
7. Verify message appears in chat

#### Scenario 2: Delete for Me
1. User A sends messages to User B
2. User A: POST `/api/deleteConversationForMe` with User B's ID
3. User A: GET `/api/getContacts` - Should NOT show User B
4. User B: GET `/api/getContacts` - Should STILL show User A
5. User B: POST `/api/fetchMessages` with User A's ID - Messages still there
6. User B: POST `/api/deleteConversationForMe` with User A's ID
7. Check database - Messages should be DELETED

#### Scenario 3: Real-time Messaging
1. Connect to Pusher
2. Subscribe to `private-chatify.{user_id}`
3. User B sends message to User A
4. User A should receive Pusher event
5. Verify message appears without refreshing

---

### 3. Mobile App Testing Checklist

- [ ] App launches and connects to Pusher
- [ ] Contacts list loads
- [ ] Can open a conversation
- [ ] Messages load with pagination
- [ ] Can send text messages
- [ ] Can send image attachments
- [ ] Receive messages in real-time
- [ ] Typing indicator works
- [ ] Message seen status updates
- [ ] Can search contacts
- [ ] Can favorite/unfavorite
- [ ] Delete for me works correctly
- [ ] Works when both users delete
- [ ] App handles network errors
- [ ] App handles 401 (logout)
- [ ] Dark mode works
- [ ] Shared photos load
- [ ] Download attachment works
- [ ] Active status updates

---

## Best Practices

### 1. Performance Optimization

- Use pagination for all lists
- Implement lazy loading for images
- Cache contact list locally
- Debounce search input
- Optimize Pusher connection (disconnect when not needed)

### 2. Security

- Always use HTTPS in production
- Store auth tokens securely (KeyChain/Keystore)
- Validate all user inputs
- Handle file uploads securely
- Implement rate limiting

### 3. User Experience

- Show loading indicators
- Handle offline mode gracefully
- Show retry options on errors
- Implement optimistic UI updates
- Add haptic feedback for actions
- Show toast messages for success/errors

### 4. State Management

- Use Redux/MobX for complex state
- Keep Pusher instance in global state
- Sync local state with server regularly
- Handle app background/foreground states

---

## Support & Resources

### Documentation Links
- Laravel API: https://laravel.com/docs
- Pusher: https://pusher.com/docs
- Chatify Original: https://chatify.munafio.com

### Common Issues

**Issue: Messages not receiving in real-time**
- Check Pusher credentials
- Verify channel subscription
- Check auth endpoint

**Issue: 401 Unauthorized**
- Check Bearer token
- Verify token expiry
- Re-authenticate user

**Issue: File upload fails**
- Check file size limits
- Verify file extensions
- Check server PHP settings

---

## Changelog

### Version 1.0 (December 2025)
- Initial API documentation
- Added "Delete for Me" feature
- Complete integration guide
- Mobile app examples
- Testing guide

---

**End of Documentation**

For questions or issues, please contact the development team.
