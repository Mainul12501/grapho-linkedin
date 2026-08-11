<?php

namespace App\Http\Controllers\Frontend\ZegoCloud;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ZegoTokenGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ZegoCloudMessagingController extends Controller
{
    /**
     * Show the messenger interface
     */
    public function index()
    {
        return view('frontend.zegocloud.messager.index');
    }

    /**
     * Get authentication token for ZegoCloud ZIM
     */
    public function getToken(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                Log::error('ZegoCloud Token Generation Failed: User not authenticated');
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized. Please login first.',
                ], 401);
            }

            $appId = (int) config('services.zegocloud.app_id', env('ZEGOCLOUD_APP_ID'));
            $serverSecret = trim(config('services.zegocloud.server_secret', env('ZEGOCLOUD_SERVER_SECRET')), '"');

            // Log configuration (without exposing full secret)
            Log::info('ZegoCloud Token Generation Started', [
                'user_id' => $user->id,
                'app_id' => $appId,
                'secret_length' => strlen($serverSecret),
                'secret_preview' => substr($serverSecret, 0, 4) . '...' . substr($serverSecret, -4),
            ]);

            if (!$appId || !$serverSecret) {
                Log::error('ZegoCloud Configuration Missing', [
                    'app_id_present' => !empty($appId),
                    'secret_present' => !empty($serverSecret),
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'ZegoCloud configuration not found. Please contact administrator.',
                ], 500);
            }

            // Validate server secret length
            if (strlen($serverSecret) !== 32) {
                Log::error('ZegoCloud Server Secret Invalid Length', [
                    'expected' => 32,
                    'actual' => strlen($serverSecret),
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Server secret must be exactly 32 characters. Current length: ' . strlen($serverSecret),
                    'debug' => [
                        'secret_length' => strlen($serverSecret),
                        'expected_length' => 32,
                    ]
                ], 500);
            }

            // Token expiration time (24 hours to handle any time sync issues)
            $expirationSeconds = 86400; // 24 hours
            $expiresAt = time() + $expirationSeconds;

            // Generate token using official ZegoCloud implementation
            // IMPORTANT: userId must be passed as STRING, not integer
            $result = ZegoTokenGenerator::generateToken04($appId, (string)$user->id, $serverSecret, $expirationSeconds, '');

            // Add detailed logging
            Log::info('ZegoCloud Token Generated', [
                'user_id' => $user->id,
                'system_time' => date('Y-m-d H:i:s', time()),
                'expires_at' => date('Y-m-d H:i:s', $expiresAt),
                'token_length' => strlen($result->token),
            ]);

            if ($result->code !== ZegoTokenGenerator::ERROR_CODE_SUCCESS) {
                Log::error('ZegoCloud Token Generation Failed', [
                    'user_id' => $user->id,
                    'error_code' => $result->code,
                    'error_message' => $result->message,
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Token generation failed: ' . $result->message,
                    'debug' => [
                        'code' => $result->code,
                        'message' => $result->message,
                    ]
                ], 500);
            }

            Log::info('ZegoCloud Token Generated Successfully', [
                'user_id' => $user->id,
                'token_length' => strlen($result->token),
                'token_preview' => substr($result->token, 0, 20) . '...',
                'expires_at' => date('Y-m-d H:i:s', $expiresAt),
            ]);

            return response()->json([
                'success' => true,
                'app_id' => $appId,
                'token' => $result->token,
                'user_id' => (string) $user->id,
                'user_name' => $user->name,
                'expires_at' => $expiresAt,
                'expires_in_seconds' => $expirationSeconds,
                'debug' => [
                    'token_length' => strlen($result->token),
                    'token_version' => substr($result->token, 0, 2),
                    'generated_at' => date('Y-m-d H:i:s'),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ZegoCloud Token Generation Exception', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate token: ' . $e->getMessage(),
                'debug' => [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Get list of contacts/users for messaging
     */
    public function getContacts(Request $request)
    {
        try {
            $currentUserId = Auth::id();

            // Get all users except current user
            // Only show users who are not blocked and are approved
            // IMPORTANT: status can be NULL, so we need to handle it explicitly
            $contacts = User::where('id', '!=', $currentUserId)
                ->where(function($query) {
                    $query->where('status', '!=', 'blocked')
                          ->orWhereNull('status');
                })
                ->where('is_approved', 1)
                ->select('id', 'name', 'email', 'profile_photo_path')
                ->orderBy('name', 'asc')
                ->limit(100)
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'profile_photo_url' => $user->profile_photo_url ?? null,
                    ];
                });

            return response()->json([
                'success' => true,
                'contacts' => $contacts
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load contacts: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Diagnostic endpoint to test all ZegoCloud configuration
     */
    public function diagnostic(Request $request)
    {
        $results = [
            'timestamp' => date('Y-m-d H:i:s'),
            'user' => null,
            'configuration' => [],
            'token_test' => [],
            'overall_status' => 'unknown',
        ];

        // Check user authentication
        $user = Auth::user();
        if ($user) {
            $results['user'] = [
                'status' => 'authenticated',
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
        } else {
            $results['user'] = [
                'status' => 'not_authenticated',
                'message' => 'User must be logged in',
            ];
            $results['overall_status'] = 'failed';
            return response()->json($results, 401);
        }

        // Check configuration
        $appId = (int) config('services.zegocloud.app_id', env('ZEGOCLOUD_APP_ID'));
        $serverSecret = trim(config('services.zegocloud.server_secret', env('ZEGOCLOUD_SERVER_SECRET')), '"');

        $results['configuration'] = [
            'app_id' => [
                'present' => !empty($appId),
                'value' => $appId ?: 'NOT SET',
                'type' => gettype($appId),
            ],
            'server_secret' => [
                'present' => !empty($serverSecret),
                'length' => strlen($serverSecret),
                'valid_length' => strlen($serverSecret) === 32,
                'preview' => $serverSecret ? substr($serverSecret, 0, 4) . '...' . substr($serverSecret, -4) : 'NOT SET',
            ],
            'helper_class' => [
                'exists' => class_exists('App\\Helpers\\ZegoTokenGenerator'),
            ],
        ];

        if (!$appId || !$serverSecret) {
            $results['overall_status'] = 'configuration_missing';
            return response()->json($results, 500);
        }

        if (strlen($serverSecret) !== 32) {
            $results['overall_status'] = 'invalid_secret_length';
            return response()->json($results, 500);
        }

        // Test token generation
        try {
            $result = ZegoTokenGenerator::generateToken04($appId, $user->id, $serverSecret, 3600, '');

            $results['token_test'] = [
                'success' => $result->code === ZegoTokenGenerator::ERROR_CODE_SUCCESS,
                'code' => $result->code,
                'message' => $result->message,
                'token_generated' => isset($result->token),
                'token_length' => isset($result->token) ? strlen($result->token) : 0,
                'token_version' => isset($result->token) ? substr($result->token, 0, 2) : null,
                'token_preview' => isset($result->token) ? substr($result->token, 0, 30) . '...' : null,
            ];

            if ($result->code === ZegoTokenGenerator::ERROR_CODE_SUCCESS) {
                $results['overall_status'] = 'success';
                $results['message'] = 'All checks passed. Configuration is correct.';
                $results['next_steps'] = [
                    'If you still get error 6000103 in browser:',
                    '1. Clear browser cache completely (Ctrl+Shift+Delete)',
                    '2. Hard refresh the page (Ctrl+F5)',
                    '3. Or try in Incognito/Private mode',
                    '4. Check if ZIM service is enabled in ZegoCloud Console',
                    '5. Verify these exact credentials work at: https://console.zegocloud.com',
                ];
            } else {
                $results['overall_status'] = 'token_generation_failed';
            }

        } catch (\Exception $e) {
            $results['token_test'] = [
                'success' => false,
                'error' => $e->getMessage(),
                'exception' => get_class($e),
            ];
            $results['overall_status'] = 'exception';
        }

        return response()->json($results, $results['overall_status'] === 'success' ? 200 : 500);
    }

}
