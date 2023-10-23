<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken {

    public static function createUserToken($userEmail): string {
        $key = env('SECRET_KEY');
        $payload = [
            'iss'       => 'inventory-project',
            'iat'       => time(),
            'exp'       => time() + 60 * 60,
            'userEmail' => $userEmail,
        ];
        return JWT::encode($payload, $key, 'HS256');

    }
    public static function verifyUserToken($token) {
        try {
            $key = env('SECRET_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode->userEmail;
        } catch (\Throwable $th) {
            return 'unauthorized';
        }

    }
}
