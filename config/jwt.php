<?php

/*
|--------------------------------------------------------------------------
| JWT Configuration - config/jwt.php
|--------------------------------------------------------------------------
|
| Jalankan: php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
| untuk generate file ini secara otomatis, lalu sesuaikan nilai di bawah.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Secret
    |--------------------------------------------------------------------------
    | Generate dengan: php artisan jwt:secret
    | Akan otomatis mengisi JWT_SECRET di .env Anda
    */
    'secret' => env('JWT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Keys (untuk algoritma RSA/ECDSA)
    |--------------------------------------------------------------------------
    | Kosongkan jika menggunakan HMAC (HS256)
    */
    'keys' => [
        'public'  => env('JWT_PUBLIC_KEY'),
        'private' => env('JWT_PRIVATE_KEY'),
        'passphrase' => env('JWT_PASSPHRASE'),
    ],

    /*
    |--------------------------------------------------------------------------
    | JWT time to live (TTL)
    |--------------------------------------------------------------------------
    | Durasi token valid dalam MENIT.
    | null = token tidak pernah expire (tidak direkomendasikan untuk production)
    */
    'ttl' => env('JWT_TTL', 60), // 60 menit = 1 jam

    /*
    |--------------------------------------------------------------------------
    | Refresh Time to Live
    |--------------------------------------------------------------------------
    | Durasi token masih bisa di-refresh dalam MENIT (dihitung dari waktu token dibuat).
    | Setelah melewati waktu ini, user harus login ulang.
    | null = token bisa di-refresh selamanya
    */
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160), // 20160 menit = 2 minggu

    /*
    |--------------------------------------------------------------------------
    | JWT Hashing Algorithm
    |--------------------------------------------------------------------------
    | Algoritma yang digunakan untuk sign token.
    | Pilihan: HS256, HS384, HS512, RS256, RS384, RS512, ES256, ES384, ES512
    */
    'algo' => env('JWT_ALGO', Tymon\JWTAuth\Providers\JWT\Provider::ALGO_HS256),

    /*
    |--------------------------------------------------------------------------
    | Required Claims
    |--------------------------------------------------------------------------
    | Klaim wajib yang harus ada di setiap token.
    */
    'required_claims' => [
        'iss', // issuer
        'iat', // issued at
        'exp', // expires at
        'nbf', // not before
        'sub', // subject (user ID)
        'jti', // JWT ID (unique identifier)
    ],

    /*
    |--------------------------------------------------------------------------
    | Persistent Claims
    |--------------------------------------------------------------------------
    | Klaim yang akan dipertahankan saat token di-refresh.
    */
    'persistent_claims' => [
        // 'foo',
        // 'bar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lock Subject
    |--------------------------------------------------------------------------
    | Jika true, subject hash akan di-lock ke token untuk keamanan ekstra.
    */
    'lock_subject' => true,

    /*
    |--------------------------------------------------------------------------
    | Leeway
    |--------------------------------------------------------------------------
    | Toleransi waktu (dalam detik) untuk mengatasi perbedaan jam antar server.
    */
    'leeway' => env('JWT_LEEWAY', 0),

    /*
    |--------------------------------------------------------------------------
    | Blacklist Enabled
    |--------------------------------------------------------------------------
    | Aktifkan blacklist agar token yang sudah logout tidak bisa digunakan lagi.
    | WAJIB aktif jika menggunakan refresh token!
    */
    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Blacklist Grace Period
    |--------------------------------------------------------------------------
    | Waktu toleransi (detik) untuk multiple request bersamaan saat refresh.
    */
    'blacklist_grace_period' => env('JWT_BLACKLIST_GRACE_PERIOD', 0),

    /*
    |--------------------------------------------------------------------------
    | Show Black List Exception
    |--------------------------------------------------------------------------
    */
    'show_black_list_exception' => env('JWT_SHOW_BLACKLIST_EXCEPTION', false),

    /*
    |--------------------------------------------------------------------------
    | Decrypt Cookie
    |--------------------------------------------------------------------------
    */
    'decrypt_cookies' => false,

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'jwt'   => Tymon\JWTAuth\Providers\JWT\Lcobucci::class,
        'auth'  => Tymon\JWTAuth\Providers\Auth\Illuminate::class,
        'storage' => Tymon\JWTAuth\Providers\Storage\Illuminate::class,
    ],

];
