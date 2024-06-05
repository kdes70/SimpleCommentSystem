<?php

namespace App\Services;

class CSRFToken
{
    public static function generate(): string
    {
        if (!session_id()) {
            session_start();
        }
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function check(string $token): bool
    {
        if (!session_id()) {
            session_start();
        }
        return $token === ($_SESSION['csrf_token'] ?? '');
    }
}
