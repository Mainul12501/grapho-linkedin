<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Firebase Cloud Messaging (FCM) Service
 *
 * This service handles sending push notifications to mobile devices using Firebase Cloud Messaging.
 * It uses the Firebase HTTP v1 API with OAuth2 authentication.
 *
 * @package App\Services
 */
class FirebaseNotificationService
{
    /**
     * @var string Path to Firebase service account JSON file
     */
    protected $credentialsPath = 'firebase/likewise-serviceAuthToken.json';

    /**
     * @var array Firebase service account credentials
     */
    protected $credentials;

    /**
     * @var string Firebase project ID
     */
    protected $projectId;

    /**
     * @var Client HTTP client instance
     */
    protected $httpClient;

    /**
     * @var int Token cache lifetime in seconds (55 minutes, tokens expire after 1 hour)
     */
    protected $tokenCacheLifetime = 3300;

    /**
     * Constructor
     * Load Firebase credentials from storage
     */
    public function __construct()
    {
        $this->httpClient = new Client();
        $this->loadCredentials();
    }

    /**
     * Load Firebase service account credentials from JSON file
     *
     * @return void
     * @throws \Exception
     */
    protected function loadCredentials()
    {
        if (!Storage::exists($this->credentialsPath)) {
            throw new \Exception("Firebase credentials file not found at: {$this->credentialsPath}");
        }

        $credentialsJson = Storage::get($this->credentialsPath);
        $this->credentials = json_decode($credentialsJson, true);

        if (!$this->credentials || !isset($this->credentials['project_id'])) {
            throw new \Exception("Invalid Firebase credentials file");
        }

        $this->projectId = $this->credentials['project_id'];
    }

    /**
     * Get OAuth2 access token for Firebase API
     * Uses JWT authentication with service account credentials
     *
     * @return string Access token
     * @throws \Exception
     */
    protected function getAccessToken()
    {
        // Check if token exists in cache
        $cachedToken = cache('firebase_access_token');
        if ($cachedToken) {
            return $cachedToken;
        }

        // Create JWT assertion
        $now = time();
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $claimSet = [
            'iss' => $this->credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ];

        $segments = [];
        $segments[] = $this->base64UrlEncode(json_encode($header));
        $segments[] = $this->base64UrlEncode(json_encode($claimSet));
        $signingInput = implode('.', $segments);

        // Sign JWT with private key
        $signature = '';
        $success = openssl_sign(
            $signingInput,
            $signature,
            $this->credentials['private_key'],
            'SHA256'
        );

        if (!$success) {
            throw new \Exception("Failed to sign JWT token");
        }

        $segments[] = $this->base64UrlEncode($signature);
        $jwt = implode('.', $segments);

        // Exchange JWT for access token
        try {
            $response = $this->httpClient->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $jwt,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $accessToken = $data['access_token'];

            // Cache the token
            cache(['firebase_access_token' => $accessToken], now()->addSeconds($this->tokenCacheLifetime));

            return $accessToken;
        } catch (GuzzleException $e) {
            Log::error('Firebase: Failed to get access token', [
                'error' => $e->getMessage(),
            ]);
            throw new \Exception("Failed to get Firebase access token: " . $e->getMessage());
        }
    }

    /**
     * Base64 URL encode
     *
     * @param string $data
     * @return string
     */
    protected function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Send notification to a single device
     *
     * @param string $fcmToken Device FCM token
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload (optional)
     * @param array $options Additional notification options (optional)
     * @return array Response from FCM
     * @throws \Exception
     */
    public function sendToDevice($fcmToken, $title, $body, $data = [], $options = [])
    {
        return $this->sendNotification($fcmToken, $title, $body, $data, $options);
    }

    /**
     * Send notification to multiple devices
     *
     * @param array $fcmTokens Array of device FCM tokens
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload (optional)
     * @param array $options Additional notification options (optional)
     * @return array Array of responses from FCM
     */
    public function sendToMultipleDevices($fcmTokens, $title, $body, $data = [], $options = [])
    {
        $results = [
            'success' => 0,
            'failure' => 0,
            'responses' => [],
        ];

        foreach ($fcmTokens as $token) {
            try {
                $response = $this->sendNotification($token, $title, $body, $data, $options);
                $results['success']++;
                $results['responses'][] = [
                    'token' => $token,
                    'status' => 'success',
                    'response' => $response,
                ];
            } catch (\Exception $e) {
                $results['failure']++;
                $results['responses'][] = [
                    'token' => $token,
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
                Log::error('Firebase: Failed to send notification to token', [
                    'token' => $token,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $results;
    }

    /**
     * Send notification using FCM HTTP v1 API
     *
     * @param string $fcmToken Device FCM token
     * @param string $title Notification title
     * @param string $body Notification body
     * @param array $data Additional data payload
     * @param array $options Additional notification options
     * @return array Response from FCM
     * @throws \Exception
     */
    protected function sendNotification($fcmToken, $title, $body, $data = [], $options = [])
    {
        $accessToken = $this->getAccessToken();
        $fcmEndpoint = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        // Build notification payload
        $notification = [
            'title' => $title,
            'body' => $body,
        ];

        // Add optional notification properties
        if (isset($options['image'])) {
            $notification['image'] = $options['image'];
        }

        // Build message payload
        $message = [
            'token' => $fcmToken,
            'notification' => $notification,
        ];

        // Add data payload if provided
        if (!empty($data)) {
            // Convert all data values to strings (FCM requirement)
            $message['data'] = array_map(function ($value) {
                return is_array($value) || is_object($value) ? json_encode($value) : (string)$value;
            }, $data);
        }

        // Add Android-specific configuration
        if (isset($options['android'])) {
            $message['android'] = $options['android'];
        } else {
            $message['android'] = [
                'priority' => 'high',
                'notification' => [
                    'sound' => 'default',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ],
            ];
        }

        // Add iOS-specific configuration
        if (isset($options['apns'])) {
            $message['apns'] = $options['apns'];
        } else {
            $message['apns'] = [
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                        'badge' => 1,
                    ],
                ],
            ];
        }

        $payload = [
            'message' => $message,
        ];

        try {
            $response = $this->httpClient->post($fcmEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info('Firebase: Notification sent successfully', [
                'token' => substr($fcmToken, 0, 20) . '...',
                'title' => $title,
                'response' => $responseData,
            ]);

            return [
                'success' => true,
                'data' => $responseData,
            ];
        } catch (GuzzleException $e) {
            $errorMessage = $e->getMessage();
            $errorBody = '';

            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
            }

            Log::error('Firebase: Failed to send notification', [
                'token' => substr($fcmToken, 0, 20) . '...',
                'title' => $title,
                'error' => $errorMessage,
                'error_body' => $errorBody,
            ]);

            throw new \Exception("Failed to send notification: {$errorMessage}. Response: {$errorBody}");
        }
    }

    /**
     * Send data-only message (no notification, silent push)
     * Useful for background data sync
     *
     * @param string $fcmToken Device FCM token
     * @param array $data Data payload
     * @return array Response from FCM
     * @throws \Exception
     */
    public function sendDataMessage($fcmToken, $data)
    {
        $accessToken = $this->getAccessToken();
        $fcmEndpoint = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        // Convert all data values to strings (FCM requirement)
        $dataPayload = array_map(function ($value) {
            return is_array($value) || is_object($value) ? json_encode($value) : (string)$value;
        }, $data);

        $message = [
            'token' => $fcmToken,
            'data' => $dataPayload,
            'android' => [
                'priority' => 'high',
            ],
        ];

        $payload = [
            'message' => $message,
        ];

        try {
            $response = $this->httpClient->post($fcmEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info('Firebase: Data message sent successfully', [
                'token' => substr($fcmToken, 0, 20) . '...',
                'data_keys' => array_keys($data),
                'response' => $responseData,
            ]);

            return [
                'success' => true,
                'data' => $responseData,
            ];
        } catch (GuzzleException $e) {
            $errorMessage = $e->getMessage();
            $errorBody = '';

            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
            }

            Log::error('Firebase: Failed to send data message', [
                'token' => substr($fcmToken, 0, 20) . '...',
                'error' => $errorMessage,
                'error_body' => $errorBody,
            ]);

            throw new \Exception("Failed to send data message: {$errorMessage}");
        }
    }

    /**
     * Validate if an FCM token is valid
     * Attempts to send a test message to validate the token
     *
     * @param string $fcmToken Device FCM token
     * @return bool True if valid, false otherwise
     */
    public function validateToken($fcmToken)
    {
        try {
            // Try sending with validate_only flag
            $accessToken = $this->getAccessToken();
            $fcmEndpoint = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

            $message = [
                'token' => $fcmToken,
                'notification' => [
                    'title' => 'Test',
                    'body' => 'Test',
                ],
            ];

            $payload = [
                'message' => $message,
                'validate_only' => true, // This won't actually send the message
            ];

            $response = $this->httpClient->post($fcmEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Log::warning('Firebase: Token validation failed', [
                'token' => substr($fcmToken, 0, 20) . '...',
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
