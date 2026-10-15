<?php

namespace App\Helpers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class EncryptedRouteHelper
{
    /**
     * Encrypt an ID for safe URL usage.
     */
    public static function encrypt(int|string $id): string
    {
        return base64_encode(Crypt::encryptString((string) $id));
    }

    /**
     * Decrypt an encrypted ID from URL.
     */
    public static function decrypt(string $encryptedId): ?int
    {
        try {
            $decrypted = Crypt::decryptString(base64_decode($encryptedId));
            return (int) $decrypted;
        } catch (DecryptException $e) {
            return null;
        }
    }

    /**
     * Decrypt or abort with 404.
     */
    public static function decryptOrFail(string $encryptedId): int
    {
        $id = static::decrypt($encryptedId);
        
        if ($id === null) {
            abort(404);
        }
        
        return $id;
    }
}
