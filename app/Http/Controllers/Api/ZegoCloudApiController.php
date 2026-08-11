<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ZegoTokenGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ZegoCloudApiController extends Controller
{
    /**
     * Get authentication token for ZegoCloud ZIM
     *
     * @group ZegoCloud Messaging API
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Token generated successfully",
     *   "data": {
     *     "app_id": 131228524,
     *     "token": "04a1b2c3d4e5f6...",
     *     "user_id": "123",
     *     "user_name": "John Doe",
     *     "expires_at": 1640000000
     *   }
     * }
     *
     * @response 401 {
     *   "success": false,
     *   "message": "Unauthorized. Please login first.",
     *   "data": null
     * }
     */
    public function getToken(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse('Unauthorized. Please login first.', 401);
            }

            $appId = (int) env('ZEGOCLOUD_APP_ID');
            $serverSecret = trim(env('ZEGOCLOUD_SERVER_SECRET'), '"');

            if (!$appId || !$serverSecret) {
                return $this->errorResponse('ZegoCloud configuration not found. Please contact administrator.', 500);
            }

            // Token expiration time (1 hour)
            $expirationSeconds = 3600;
            $expiresAt = time() + $expirationSeconds;

            // Generate token using official ZegoCloud implementation
            $result = ZegoTokenGenerator::generateToken04($appId, $user->id, $serverSecret, $expirationSeconds, '');

            if ($result->code !== ZegoTokenGenerator::ERROR_CODE_SUCCESS) {
                return $this->errorResponse('Token generation failed: ' . $result->message, 500);
            }

            return $this->successResponse('Token generated successfully', [
                'app_id' => $appId,
                'token' => $result->token,
                'user_id' => (string) $user->id,
                'user_name' => $user->name,
                'expires_at' => $expiresAt,
                'expires_in_seconds' => $expirationSeconds,
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to generate token: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get list of contacts/users for messaging
     *
     * @group ZegoCloud Messaging API
     * @authenticated
     *
     * @queryParam search string Filter contacts by name or email. Example: john
     * @queryParam limit int Number of contacts to return (default: 100, max: 500). Example: 50
     * @queryParam offset int Offset for pagination (default: 0). Example: 0
     * @queryParam user_type string Filter by user type (employee/employer). Example: employee
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Contacts retrieved successfully",
     *   "data": {
     *     "contacts": [
     *       {
     *         "id": 2,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "user_type": "employee",
     *         "profile_photo_url": "https://example.com/photo.jpg",
     *         "is_online": true,
     *         "last_seen": "2025-12-09T10:30:00Z"
     *       }
     *     ],
     *     "pagination": {
     *       "total": 150,
     *       "limit": 50,
     *       "offset": 0,
     *       "has_more": true
     *     }
     *   }
     * }
     */
    public function getContacts(Request $request)
    {
        try {
            $currentUser = Auth::user();

            if (!$currentUser) {
                return $this->errorResponse('Unauthorized. Please login first.', 401);
            }

            // Validation
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string|max:255',
                'limit' => 'nullable|integer|min:1|max:500',
                'offset' => 'nullable|integer|min:0',
                'user_type' => 'nullable|string|in:employee,employer',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed', 422, $validator->errors());
            }

            $search = $request->input('search');
            $limit = $request->input('limit', 100);
            $offset = $request->input('offset', 0);
            $userType = $request->input('user_type');

            // Build query - only show users who are not blocked and are approved
            $query = User::where('id', '!=', $currentUser->id)
                ->where('status', '!=', 'blocked')
                ->where('is_approved', 1);

            // Apply filters
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }

            if ($userType) {
                $query->where('user_type', $userType);
            }

            // Get total count
            $total = $query->count();

            // Get contacts with pagination
            $contacts = $query->select(
                    'id',
                    'name',
                    'email',
                    'user_type',
                    'profile_photo_path',
                    'is_online',
                    'last_seen'
                )
                ->orderBy('name', 'asc')
                ->offset($offset)
                ->limit($limit)
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'user_type' => $user->user_type,
                        'profile_photo_url' => $user->profile_photo_url ?? null,
                        'is_online' => $user->is_online ?? false,
                        'last_seen' => $user->last_seen ? $user->last_seen->toIso8601String() : null,
                    ];
                });

            return $this->successResponse('Contacts retrieved successfully', [
                'contacts' => $contacts,
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'offset' => $offset,
                    'has_more' => ($offset + $limit) < $total,
                ]
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to load contacts: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get user details by ID
     *
     * @group ZegoCloud Messaging API
     * @authenticated
     *
     * @urlParam user_id required The ID of the user. Example: 123
     *
     * @response 200 {
     *   "success": true,
     *   "message": "User details retrieved successfully",
     *   "data": {
     *     "id": 123,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "user_type": "employee",
     *     "profile_photo_url": "https://example.com/photo.jpg",
     *     "is_online": true,
     *     "last_seen": "2025-12-09T10:30:00Z",
     *     "created_at": "2025-01-01T00:00:00Z"
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "User not found",
     *   "data": null
     * }
     */
    public function getUserDetails(Request $request, $userId)
    {
        try {
            $currentUser = Auth::user();

            if (!$currentUser) {
                return $this->errorResponse('Unauthorized. Please login first.', 401);
            }

            $user = User::where('id', $userId)
                ->where('status', '!=', 'blocked')
                ->where('is_approved', 1)
                ->first();

            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'profile_photo_url' => $user->profile_photo_url ?? null,
                'is_online' => $user->is_online ?? false,
                'last_seen' => $user->last_seen ? $user->last_seen->toIso8601String() : null,
                'created_at' => $user->created_at ? $user->created_at->toIso8601String() : null,
            ];

            return $this->successResponse('User details retrieved successfully', $userData);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get user details: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update user online status
     *
     * @group ZegoCloud Messaging API
     * @authenticated
     *
     * @bodyParam is_online boolean required Online status. Example: true
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Online status updated successfully",
     *   "data": {
     *     "is_online": true,
     *     "last_seen": "2025-12-09T10:30:00Z"
     *   }
     * }
     */
    public function updateOnlineStatus(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse('Unauthorized. Please login first.', 401);
            }

            $validator = Validator::make($request->all(), [
                'is_online' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed', 422, $validator->errors());
            }

            $user->is_online = $request->input('is_online');
            $user->last_seen = now();
            $user->save();

            return $this->successResponse('Online status updated successfully', [
                'is_online' => $user->is_online,
                'last_seen' => $user->last_seen->toIso8601String(),
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update online status: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Search users
     *
     * @group ZegoCloud Messaging API
     * @authenticated
     *
     * @bodyParam query string required Search query (min 2 characters). Example: john
     * @bodyParam limit integer Number of results to return (default: 20, max: 100). Example: 20
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Search completed successfully",
     *   "data": {
     *     "results": [
     *       {
     *         "id": 2,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "user_type": "employee",
     *         "profile_photo_url": "https://example.com/photo.jpg"
     *       }
     *     ],
     *     "total": 5
     *   }
     * }
     */
    public function searchUsers(Request $request)
    {
        try {
            $currentUser = Auth::user();

            if (!$currentUser) {
                return $this->errorResponse('Unauthorized. Please login first.', 401);
            }

            $validator = Validator::make($request->all(), [
                'query' => 'required|string|min:2|max:255',
                'limit' => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed', 422, $validator->errors());
            }

            $query = $request->input('query');
            $limit = $request->input('limit', 20);

            $results = User::where('id', '!=', $currentUser->id)
                ->where('status', '!=', 'blocked')
                ->where('is_approved', 1)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%");
                })
                ->select('id', 'name', 'email', 'user_type', 'profile_photo_path')
                ->limit($limit)
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'user_type' => $user->user_type,
                        'profile_photo_url' => $user->profile_photo_url ?? null,
                    ];
                });

            return $this->successResponse('Search completed successfully', [
                'results' => $results,
                'total' => $results->count(),
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to search users: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get current user profile
     *
     * @group ZegoCloud Messaging API
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Profile retrieved successfully",
     *   "data": {
     *     "id": 1,
     *     "name": "Current User",
     *     "email": "user@example.com",
     *     "user_type": "employee",
     *     "profile_photo_url": "https://example.com/photo.jpg",
     *     "is_online": true,
     *     "created_at": "2025-01-01T00:00:00Z"
     *   }
     * }
     */
    public function getProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse('Unauthorized. Please login first.', 401);
            }

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'profile_photo_url' => $user->profile_photo_url ?? null,
                'is_online' => $user->is_online ?? false,
                'created_at' => $user->created_at ? $user->created_at->toIso8601String() : null,
            ];

            return $this->successResponse('Profile retrieved successfully', $userData);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to get profile: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Verify token validity
     *
     * @group ZegoCloud Messaging API
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Token is valid",
     *   "data": {
     *     "valid": true,
     *     "user_id": "123"
     *   }
     * }
     */
    public function verifyToken(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return $this->errorResponse('Invalid token', 401);
            }

            return $this->successResponse('Token is valid', [
                'valid' => true,
                'user_id' => (string) $user->id,
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse('Token verification failed: ' . $e->getMessage(), 500);
        }
    }

    // ==================== HELPER METHODS ====================

    /**
     * Success response helper
     */
    private function successResponse($message, $data = null, $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Error response helper
     */
    private function errorResponse($message, $statusCode = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'data' => null,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

}
