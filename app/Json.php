<?php 

namespace App;

class Json {
    static function result($success,$payload = [])
    {
        return [
            'success' => $success,
            'payload' => $payload
        ];
    }
}