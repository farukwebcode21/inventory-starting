<?php

namespace App\Helper;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

class JWTToken {

    // public static function createUserToken($userEmail): string {
    //     $key = env('SECRET_KEY');
    //     $payload = [
    //         'iss'       => 'inventory-project',
    //         'iat'       => time(),
    //         'exp'       => time() + 60 * 60,
    //         'userEmail' => $userEmail,
    //     ];
    //     return JWT::encode($payload, $key, 'HS256');

    // }

    // public static function createUserTokenForResetPassword($userEmail): string {
    //     $key = env('SECRET_KEY');
    //     $payload = [
    //         'iss'       => 'inventory-project',
    //         'iat'       => time(),
    //         'exp'       => time() + 60 * 30,
    //         'userEmail' => $userEmail,
    //     ];
    //     return JWT::encode($payload, $key, 'HS256');

    // }
    // public static function verifyUserToken($token) {
    //     try {
    //         $key = env('SECRET_KEY');
    //         $decode = JWT::decode($token, new Key($key, 'HS256'));
    //         return $decode->userEmail;
    //     } catch (Exception $e) {
    //         return 'unauthorized';
    //     }

    // }

    public static function createUserToken($userEmail, $expirationMinutes = 60): string {
        return self::generateToken($userEmail, $expirationMinutes);
    }

    public static function createUserTokenForResetPassword($userEmail, $expirationMinutes = 30): string {
        return self::generateToken($userEmail, $expirationMinutes);
    }

    private static function generateToken($userEmail, $expirationMinutes): string {
        $key = env('SECRET_KEY');
        $payload = [
            'iss'       => 'inventory-project',
            'iat'       => time(),
            'exp'       => time() + 60 * $expirationMinutes,
            'userEmail' => $userEmail,
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function verifyUserToken($token) {
        try {
            $key = env('SECRET_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode->userEmail;
        } catch (ExpiredException $e) {
            return 'token_expired';
        } catch (BeforeValidException $e) {
            return 'token_not_yet_valid';
        } catch (SignatureInvalidException $e) {
            return 'token_invalid_signature';
        } catch (\Exception $e) {
            return 'unauthorized';
        }
    }
}
