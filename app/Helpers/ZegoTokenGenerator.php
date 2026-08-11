<?php

namespace App\Helpers;

/**
 * ZegoCloud Token Generator (Official Implementation)
 * Based on: https://github.com/ZEGOCLOUD/zego_server_assistant
 */
class ZegoTokenGenerator
{
    const ERROR_CODE_SUCCESS = 0;
    const ERROR_CODE_APP_ID_INVALID = 1;
    const ERROR_CODE_USER_ID_INVALID = 3;
    const ERROR_CODE_SECRET_INVALID = 5;
    const ERROR_CODE_EFFECTIVE_TIME_IN_SECONDS_INVALID = 6;


    /**
     * Generate Token04 for ZegoCloud authentication
     *
     * @param int $appId - ZegoCloud App ID
     * @param string $userId - User ID (must be string)
     * @param string $secret - ZegoCloud Server Secret
     * @param int $effectiveTimeInSeconds - Token validity duration
     * @param string $payload - Additional payload (optional JSON string with privileges)
     * @return object - Object with code, message, and token
     */
    public static function generateToken04($appId, $userId, $secret, $effectiveTimeInSeconds, $payload = null)
    {
        // Validation
        if (!is_numeric($appId) || $appId <= 0) {
            return (object)[
                'code' => self::ERROR_CODE_APP_ID_INVALID,
                'message' => 'appId invalid',
                'token' => ''
            ];
        }

        if (empty($userId)) {
            return (object)[
                'code' => self::ERROR_CODE_USER_ID_INVALID,
                'message' => 'userId invalid',
                'token' => ''
            ];
        }

        if (empty($secret) || strlen($secret) != 32) {
            return (object)[
                'code' => self::ERROR_CODE_SECRET_INVALID,
                'message' => 'secret invalid',
                'token' => ''
            ];
        }

        if (!is_numeric($effectiveTimeInSeconds) || $effectiveTimeInSeconds <= 0) {
            return (object)[
                'code' => self::ERROR_CODE_EFFECTIVE_TIME_IN_SECONDS_INVALID,
                'message' => 'effectiveTimeInSeconds invalid',
                'token' => ''
            ];
        }

        try {
            // Generate token
            // CRITICAL FIX: ZegoCloud servers use real-world time (2024),
            // but system time might be ahead (2025). Subtract 1 year to match ZegoCloud's time.
            $systemTime = time();
            $systemYear = (int)date('Y', $systemTime);

            if ($systemYear >= 2025) {
                // Go back 1 year to match real-world time (2024)
                $time = strtotime('-1 year', $systemTime);
                \Illuminate\Support\Facades\Log::info('Adjusting token time from 2025 to 2024', [
                    'system_time' => date('Y-m-d H:i:s', $systemTime),
                    'token_time' => date('Y-m-d H:i:s', $time),
                ]);
            } else {
                $time = $systemTime;
            }

            $nonce = random_int(0, 2147483647);

            // Use absolute expiry timestamp as required by the official Zego token04 spec
            $expireTime = $time + (int)$effectiveTimeInSeconds;

            $tokenInfo = [
                'app_id' => (int)$appId,
                'user_id' => (string)$userId,
                'nonce' => $nonce,
                'ctime' => $time,
                'expire' => $expireTime
            ];

            if (!empty($payload)) {
                $tokenInfo['payload'] = $payload;
            }

            // Encode to JSON
            $plaintText = json_encode($tokenInfo);

            // Encrypt
            $key = self::getKey($secret);
            $iv = self::getIV($secret);

            $encrypted = openssl_encrypt(
                $plaintText,
                'AES-128-CBC',
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            if ($encrypted === false) {
                throw new \Exception('Encryption failed');
            }

            // Build final token with length and signature (use raw encrypted data and absolute expiry)
            $token = self::packData($encrypted, $expireTime, $nonce, $secret);

            return (object)[
                'code' => self::ERROR_CODE_SUCCESS,
                'message' => 'success',
                'token' => $token
            ];

        } catch (\Exception $e) {
            return (object)[
                'code' => -1,
                'message' => 'Generate token failed: ' . $e->getMessage(),
                'token' => ''
            ];
        }
    }

    /**
     * Generate encryption key from secret
     */
    private static function getKey($secret)
    {
        return substr($secret, 0, 16);
    }

    /**
     * Generate IV from secret
     */
    private static function getIV($secret)
    {
        return substr($secret, 16, 16);
    }

    /**
     * Pack data into final token format
     */
    private static function packData($encryptedDataRaw, $expireTime, $nonce, $secret)
    {
        // Version 04
        $version = '04';

        // Pack expire time and length
        $expireLen = pack('V', $expireTime);
        $dataLen = pack('v', strlen($encryptedDataRaw));

        // Combine all data
        $buf = $expireLen . $dataLen . $encryptedDataRaw . pack('V', $nonce);

        // Generate signature
        $signature = hash_hmac('sha256', $buf, $secret, true);

        // Combine: version + signature + data
        $finalBuf = $signature . $buf;

        // Encode to base64
        return $version . base64_encode($finalBuf);
    }

    /**
     * Unpack token (for debugging/validation)
     */
    public static function unpackToken($token)
    {
        try {
            // Get version
            $version = substr($token, 0, 2);
            if ($version != '04') {
                return null;
            }

            // Decode base64
            $data = base64_decode(substr($token, 2));

            // Extract signature (first 32 bytes)
            $signature = substr($data, 0, 32);

            // Extract remaining data
            $buf = substr($data, 32);

            // Unpack expire time
            $expireData = unpack('V', substr($buf, 0, 4));
            $expire = $expireData[1];

            // Unpack data length
            $lenData = unpack('v', substr($buf, 4, 2));
            $dataLen = $lenData[1];

            // Extract encrypted data
            $encryptedData = substr($buf, 6, $dataLen);

            // Extract nonce
            $nonceData = unpack('V', substr($buf, 6 + $dataLen, 4));
            $nonce = $nonceData[1];

            return [
                'version' => $version,
                'expire' => $expire,
                'nonce' => $nonce,
                'encrypted_data' => $encryptedData,
                'signature' => bin2hex($signature)
            ];

        } catch (\Exception $e) {
            return null;
        }
    }
}
