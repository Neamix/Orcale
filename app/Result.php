<?php 

namespace App;

class Result {
    static function response(bool $message,array $payload)
    {
        return [
            'message' => $message,
            'payload' => $payload
        ];
    }
}