<?php

namespace App\Helpers;

use App\Models\User;
use App\Services\FirebaseNotificationService;
use Illuminate\Support\Facades\Log;

/**
 * Firebase Helper Functions
 *
 * Convenient helper functions to send Firebase push notifications
 *
 * @package App\Helpers
 */
class FirebaseHelper
{
    /**
     * Send push notification to a user by user ID
     *
     * @param int $userId User ID
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload (optional)
     * @param array $options Additional notification options (optional)
     * @return array|null Response from FCM or null if user has no FCM token
     */
    public static function sendToUser($userId, $title, $body, $data = [], $options = [])
    {
        $user = User::find($userId);

        if (!$user || !$user->fcm_token) {
            Log::info('Firebase: User has no FCM token', [
                'user_id' => $userId,
            ]);
            return null;
        }

        try {
            $firebaseService = new FirebaseNotificationService();
            return $firebaseService->sendToDevice($user->fcm_token, $title, $body, $data, $options);
        } catch (\Exception $e) {
            Log::error('Firebase: Failed to send notification to user', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send push notification to multiple users by user IDs
     *
     * @param array $userIds Array of user IDs
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload (optional)
     * @param array $options Additional notification options (optional)
     * @return array Response with success/failure counts
     */
    public static function sendToUsers($userIds, $title, $body, $data = [], $options = [])
    {
        $users = User::whereIn('id', $userIds)->whereNotNull('fcm_token')->get();

        if ($users->isEmpty()) {
            Log::info('Firebase: No users found with FCM tokens', [
                'user_ids' => $userIds,
            ]);
            return [
                'success' => 0,
                'failure' => 0,
                'no_tokens' => count($userIds),
            ];
        }

        $fcmTokens = $users->pluck('fcm_token')->toArray();

        try {
            $firebaseService = new FirebaseNotificationService();
            return $firebaseService->sendToMultipleDevices($fcmTokens, $title, $body, $data, $options);
        } catch (\Exception $e) {
            Log::error('Firebase: Failed to send notifications to users', [
                'user_ids' => $userIds,
                'error' => $e->getMessage(),
            ]);
            return [
                'success' => 0,
                'failure' => count($fcmTokens),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send push notification directly to FCM token
     *
     * @param string $fcmToken Device FCM token
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload (optional)
     * @param array $options Additional notification options (optional)
     * @return array Response from FCM
     */
    public static function sendToToken($fcmToken, $title, $body, $data = [], $options = [])
    {
        try {
            $firebaseService = new FirebaseNotificationService();
            return $firebaseService->sendToDevice($fcmToken, $title, $body, $data, $options);
        } catch (\Exception $e) {
            Log::error('Firebase: Failed to send notification to token', [
                'error' => $e->getMessage(),
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send data-only message to a user (no notification, silent push)
     * Useful for background data sync
     *
     * @param int $userId User ID
     * @param array $data Data payload
     * @return array|null Response from FCM or null if user has no FCM token
     */
    public static function sendDataToUser($userId, $data)
    {
        $user = User::find($userId);

        if (!$user || !$user->fcm_token) {
            Log::info('Firebase: User has no FCM token for data message', [
                'user_id' => $userId,
            ]);
            return null;
        }

        try {
            $firebaseService = new FirebaseNotificationService();
            return $firebaseService->sendDataMessage($user->fcm_token, $data);
        } catch (\Exception $e) {
            Log::error('Firebase: Failed to send data message to user', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send profile view notification
     * Used when someone views a user's profile
     *
     * @param int $viewedUserId User whose profile was viewed
     * @param string $viewerName Name of the person who viewed the profile
     * @param int $viewerId ID of the person who viewed the profile
     * @return array|null Response from FCM
     */
    public static function sendProfileViewNotification($viewedUserId, $viewerName, $viewerId)
    {
        $title = "Profile View";
        $body = "{$viewerName} viewed your profile";

        $data = [
            'notification_type' => 'profile_view',
            'viewer_id' => (string)$viewerId,
            'viewer_name' => $viewerName,
            'viewed_at' => now()->toIso8601String(),
        ];

        return self::sendToUser($viewedUserId, $title, $body, $data);
    }

    /**
     * Send job application notification
     * Used when someone applies for a job
     *
     * @param int $employerId Employer user ID
     * @param string $applicantName Name of the applicant
     * @param int $applicantId ID of the applicant
     * @param string $jobTitle Job title
     * @param int $jobId Job ID
     * @return array|null Response from FCM
     */
    public static function sendJobApplicationNotification($employerId, $applicantName, $applicantId, $jobTitle, $jobId)
    {
        $title = "New Job Application";
        $body = "{$applicantName} applied for {$jobTitle}";

        $data = [
            'notification_type' => 'job_application',
            'applicant_id' => (string)$applicantId,
            'applicant_name' => $applicantName,
            'job_id' => (string)$jobId,
            'job_title' => $jobTitle,
            'applied_at' => now()->toIso8601String(),
        ];

        return self::sendToUser($employerId, $title, $body, $data);
    }

    /**
     * Send message notification
     * Used when a user receives a new message
     *
     * @param int $recipientId Recipient user ID
     * @param string $senderName Sender name
     * @param int $senderId Sender ID
     * @param string $messagePreview Preview of the message
     * @return array|null Response from FCM
     */
    public static function sendMessageNotification($recipientId, $senderName, $senderId, $messagePreview)
    {
        $title = "New Message";
        $body = "{$senderName}: {$messagePreview}";

        $data = [
            'notification_type' => 'new_message',
            'sender_id' => (string)$senderId,
            'sender_name' => $senderName,
            'message_preview' => $messagePreview,
            'sent_at' => now()->toIso8601String(),
        ];

        return self::sendToUser($recipientId, $title, $body, $data);
    }

    /**
     * Send connection request notification
     * Used when someone sends a connection/follow request
     *
     * @param int $recipientId Recipient user ID
     * @param string $requesterName Requester name
     * @param int $requesterId Requester ID
     * @return array|null Response from FCM
     */
    public static function sendConnectionRequestNotification($recipientId, $requesterName, $requesterId)
    {
        $title = "New Connection Request";
        $body = "{$requesterName} wants to connect with you";

        $data = [
            'notification_type' => 'connection_request',
            'requester_id' => (string)$requesterId,
            'requester_name' => $requesterName,
            'requested_at' => now()->toIso8601String(),
        ];

        return self::sendToUser($recipientId, $title, $body, $data);
    }

    /**
     * Send custom notification with flexible data
     *
     * @param int|array $userIds Single user ID or array of user IDs
     * @param string $title Notification title
     * @param string $body Notification body
     * @param string $notificationType Type of notification (for mobile app routing)
     * @param array $customData Additional custom data
     * @param array $options Additional notification options
     * @return array|null Response from FCM
     */
    public static function sendCustomNotification($userIds, $title, $body, $notificationType, $customData = [], $options = [])
    {
        $data = array_merge([
            'notification_type' => $notificationType,
            'sent_at' => now()->toIso8601String(),
        ], $customData);

        if (is_array($userIds)) {
            return self::sendToUsers($userIds, $title, $body, $data, $options);
        } else {
            return self::sendToUser($userIds, $title, $body, $data, $options);
        }
    }

    /**
     * Validate FCM token
     *
     * @param string $fcmToken FCM token to validate
     * @return bool True if valid, false otherwise
     */
    public static function validateToken($fcmToken)
    {
        try {
            $firebaseService = new FirebaseNotificationService();
            return $firebaseService->validateToken($fcmToken);
        } catch (\Exception $e) {
            Log::error('Firebase: Token validation error', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send incoming call notification
     * Used when someone initiates an audio or video call
     *
     * @param int $receiverId User ID receiving the call
     * @param string $callerName Name of the person calling
     * @param int $callerId ID of the person calling
     * @param int $callId Call ID
     * @param string $roomId Room ID for the call
     * @param string $callType Call type: 'audio' or 'video'
     * @param string|null $callerPhoto URL of caller's profile photo
     * @return array|null Response from FCM
     */
    public static function sendIncomingCallNotification(
        $receiverId,
        $callerName,
        $callerId,
        $callId,
        $roomId,
        $callType,
        $callerPhoto = null
    ) {
        $title = $callType === 'audio' ? 'Incoming Audio Call' : 'Incoming Video Call';
        $body = "{$callerName} is calling you...";

        $data = [
            'notification_type' => 'incoming_call',
            'call_id' => (string)$callId,
            'room_id' => $roomId,
            'call_type' => $callType,
            'caller_id' => (string)$callerId,
            'caller_name' => $callerName,
            'caller_photo' => $callerPhoto ?? '',
            'action' => 'call_initiated',
            'timestamp' => now()->toIso8601String(),
        ];

        // Use high priority options for incoming calls
        $options = [
            'android' => [
                'priority' => 'high',
                'notification' => [
                    'sound' => 'default',
                    'priority' => 'high',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'channel_id' => 'likewise',
                ],
            ],
            'apns' => [
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                        'badge' => 1,
                        'category' => 'likewise',
                        'alert' => [
                            'title' => $title,
                            'body' => $body,
                        ],
                    ],
                ],
            ],
        ];

        return self::sendToUser($receiverId, $title, $body, $data, $options);
    }

    /**
     * Send call accepted notification
     * Used when a call is accepted
     *
     * @param int $callerId ID of the person who initiated the call
     * @param string $receiverName Name of the person who accepted
     * @param int $receiverId ID of the person who accepted
     * @param int $callId Call ID
     * @param string $roomId Room ID for the call
     * @return array|null Response from FCM
     */
    public static function sendCallAcceptedNotification(
        $callerId,
        $receiverName,
        $receiverId,
        $callId,
        $roomId
    ) {
        $title = 'Call Accepted';
        $body = "{$receiverName} accepted your call";

        $data = [
            'notification_type' => 'call_accepted',
            'call_id' => (string)$callId,
            'room_id' => $roomId,
            'receiver_id' => (string)$receiverId,
            'receiver_name' => $receiverName,
            'action' => 'call_accepted',
            'timestamp' => now()->toIso8601String(),
        ];

        return self::sendToUser($callerId, $title, $body, $data);
    }

    /**
     * Send call rejected notification
     * Used when a call is rejected/declined
     *
     * @param int $callerId ID of the person who initiated the call
     * @param string $receiverName Name of the person who rejected
     * @param int $receiverId ID of the person who rejected
     * @param int $callId Call ID
     * @return array|null Response from FCM
     */
    public static function sendCallRejectedNotification(
        $callerId,
        $receiverName,
        $receiverId,
        $callId
    ) {
        $title = 'Call Declined';
        $body = "{$receiverName} declined your call";

        $data = [
            'notification_type' => 'call_rejected',
            'call_id' => (string)$callId,
            'receiver_id' => (string)$receiverId,
            'receiver_name' => $receiverName,
            'action' => 'call_rejected',
            'timestamp' => now()->toIso8601String(),
        ];

        return self::sendToUser($callerId, $title, $body, $data);
    }

    /**
     * Send call ended notification
     * Used when a call ends
     *
     * @param int $userId ID of the user to notify
     * @param string $otherUserName Name of the other person in the call
     * @param int $otherUserId ID of the other person in the call
     * @param int $callId Call ID
     * @param int|null $duration Call duration in seconds
     * @return array|null Response from FCM
     */
    public static function sendCallEndedNotification(
        $userId,
        $otherUserName,
        $otherUserId,
        $callId,
        $duration = null
    ) {
        $title = 'Call Ended';
        $body = $duration
            ? "Call with {$otherUserName} ended. Duration: " . gmdate('H:i:s', $duration)
            : "Call with {$otherUserName} has ended";

        $data = [
            'notification_type' => 'call_ended',
            'call_id' => (string)$callId,
            'other_user_id' => (string)$otherUserId,
            'other_user_name' => $otherUserName,
            'duration' => $duration ? (string)$duration : '0',
            'action' => 'call_ended',
            'timestamp' => now()->toIso8601String(),
        ];

        return self::sendToUser($userId, $title, $body, $data);
    }
}
