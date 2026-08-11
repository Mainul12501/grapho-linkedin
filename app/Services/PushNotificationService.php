<?php

namespace App\Services;

use App\Models\Backend\Call;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    /**
     * Send call notification to user's device
     *
     * @param User $receiver The user receiving the notification
     * @param User $sender The user initiating the action
     * @param Call $call The call object
     * @param string $type Type of notification: 'incoming', 'accepted', 'rejected', 'ended'
     */
    public function sendCallNotification(User $receiver, User $sender, Call $call, string $type)
    {
        if (!$receiver->device_token || !$receiver->device_platform) {
            return false;
        }

        $notificationData = $this->prepareNotificationData($receiver, $sender, $call, $type);

        try {
            if ($receiver->device_platform === 'ios') {
                return $this->sendApnNotification($receiver->device_token, $notificationData);
            } elseif ($receiver->device_platform === 'android') {
                return $this->sendFcmNotification($receiver->device_token, $notificationData);
            }
        } catch (\Exception $e) {
            Log::error('Push notification failed', [
                'receiver_id' => $receiver->id,
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            return false;
        }

        return false;
    }

    /**
     * Prepare notification data based on type
     */
    protected function prepareNotificationData(User $receiver, User $sender, Call $call, string $type): array
    {
        switch ($type) {
            case 'incoming':
                return [
                    'title' => 'Incoming Call',
                    'body' => "{$sender->name} is calling you...",
                    'call_id' => $call->id,
                    'room_id' => $call->room_id,
                    'call_type' => $call->call_type,
                    'caller_id' => $sender->id,
                    'caller_name' => $sender->name,
                    'caller_photo' => $sender->profile_photo_url,
                    'notification_type' => 'incoming_call',
                    'action' => 'call_initiated',
                ];

            case 'accepted':
                return [
                    'title' => 'Call Accepted',
                    'body' => "{$sender->name} accepted your call",
                    'call_id' => $call->id,
                    'room_id' => $call->room_id,
                    'notification_type' => 'call_accepted',
                    'action' => 'call_accepted',
                ];

            case 'rejected':
                return [
                    'title' => 'Call Declined',
                    'body' => "{$sender->name} declined your call",
                    'call_id' => $call->id,
                    'notification_type' => 'call_rejected',
                    'action' => 'call_rejected',
                ];

            case 'ended':
                return [
                    'title' => 'Call Ended',
                    'body' => "Call with {$sender->name} has ended",
                    'call_id' => $call->id,
                    'notification_type' => 'call_ended',
                    'action' => 'call_ended',
                ];

            default:
                return [
                    'title' => 'Call Notification',
                    'body' => "You have a notification from {$sender->name}",
                    'call_id' => $call->id,
                    'notification_type' => 'general',
                ];
        }
    }

    /**
     * Send notification via Firebase Cloud Messaging (FCM) for Android
     */
    protected function sendFcmNotification(string $deviceToken, array $data): bool
    {
        $fcmServerKey = config('services.fcm.server_key');

        if (!$fcmServerKey) {
            Log::warning('FCM server key not configured');
            return false;
        }

        $notification = [
            'title' => $data['title'],
            'body' => $data['body'],
            'sound' => 'default',
            'priority' => 'high',
        ];

        // For incoming calls, use data-only message for better control
        if ($data['notification_type'] === 'incoming_call') {
            $payload = [
                'to' => $deviceToken,
                'data' => $data,
                'priority' => 'high',
                'android' => [
                    'priority' => 'high',
                ],
            ];
        } else {
            $payload = [
                'to' => $deviceToken,
                'notification' => $notification,
                'data' => $data,
                'priority' => 'high',
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $fcmServerKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $payload);

        if ($response->successful()) {
            Log::info('FCM notification sent successfully', ['response' => $response->json()]);
            return true;
        }

        Log::error('FCM notification failed', ['response' => $response->body()]);
        return false;
    }

    /**
     * Send notification via Apple Push Notification service (APNs) for iOS
     */
    protected function sendApnNotification(string $deviceToken, array $data): bool
    {
        $apnKeyId = config('services.apn.key_id');
        $apnTeamId = config('services.apn.team_id');
        $apnBundleId = config('services.apn.bundle_id');
        $apnKeyPath = config('services.apn.key_path');

        if (!$apnKeyId || !$apnTeamId || !$apnBundleId || !$apnKeyPath) {
            Log::warning('APNs configuration incomplete');
            return false;
        }

        // For production implementation, you would use a proper APNs library
        // like edamov/pushok or similar. This is a placeholder for the structure.

        Log::info('APNs notification prepared', [
            'device_token' => $deviceToken,
            'data' => $data
        ]);

        // TODO: Implement actual APNs sending logic using a library like edamov/pushok
        // Example structure:
        // $client = new Pushok\Client(Pushok\AuthProvider\Token::create([
        //     'key_id' => $apnKeyId,
        //     'team_id' => $apnTeamId,
        //     'app_bundle_id' => $apnBundleId,
        //     'private_key_path' => $apnKeyPath,
        // ]));
        //
        // $notification = new Pushok\Notification($data['alert'], $deviceToken);
        // $notification->setSound('default');
        // $notification->setCustomValue('call_id', $data['call_id']);
        //
        // $responses = $client->push([$notification]);

        return true;
    }

    /**
     * Send bulk notifications to multiple users
     */
    public function sendBulkNotifications(array $users, array $notificationData): array
    {
        $results = [];

        foreach ($users as $user) {
            if ($user->device_token && $user->device_platform) {
                try {
                    if ($user->device_platform === 'ios') {
                        $results[$user->id] = $this->sendApnNotification($user->device_token, $notificationData);
                    } elseif ($user->device_platform === 'android') {
                        $results[$user->id] = $this->sendFcmNotification($user->device_token, $notificationData);
                    }
                } catch (\Exception $e) {
                    Log::error('Bulk notification failed for user', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage()
                    ]);
                    $results[$user->id] = false;
                }
            }
        }

        return $results;
    }
}
