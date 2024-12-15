<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{

    public static function createToken($userEmail, $userId){
        $key = env('JWT_SECRET');
        $payload = [
            'iss' => 'Laravel-Token',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'email' => $userEmail,
            'id'=> $userId
        ];
        return JWT::encode($payload, $key , 'HS256');
    }
    public static function createTokenForPassword($userEmail,$userId){
        $key = env('JWT_SECRET');
        $payload = [
            'iss' => 'Laravel-Token',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'email' => $userEmail,
            'id'=> $userId
        ];
        return JWT::encode($payload, $key , 'HS256');
    }

    public static function verifyToken($token){
        if(empty($token)){
            return 'unauthorized';
        }
       try{
            $key = env('JWT_SECRET');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode;

       }catch(Exception $e){
            return 'unauthorized';
       }
    }
}
