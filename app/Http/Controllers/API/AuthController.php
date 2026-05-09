<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    /**
     * Register user baru
     * POST /api/auth/register
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status'  => true,
            'message' => 'Registrasi berhasil',
            'data'    => [
                'user'  => $user,
                'token' => $this->buildTokenResponse($token),
            ],
        ], 201);
    }

    /**
     * Login user
     * POST /api/auth/login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('name', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Username atau password salah',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Tidak dapat membuat token, coba lagi nanti',
            ], 500);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Login berhasil',
            'data'    => [
                'user'  => Auth::user(),
                'token' => $this->buildTokenResponse($token),
            ],
        ]);
    }

    /**
     * Logout user (invalidate token)
     * POST /api/auth/logout
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status'  => true,
                'message' => 'Logout berhasil, token telah dinonaktifkan',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal logout, coba lagi',
            ], 500);
        }
    }

    /**
     * Ambil data user yang sedang login
     * GET /api/auth/me
     */
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Data user berhasil diambil',
                'data'    => [
                    'user' => $user,
                ],
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Token sudah kadaluarsa',
                'code'    => 'TOKEN_EXPIRED',
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Token tidak valid',
                'code'    => 'TOKEN_INVALID',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Token tidak ditemukan',
                'code'    => 'TOKEN_ABSENT',
            ], 401);
        }
    }

    /**
     * Check apakah token masih valid
     * GET /api/auth/check-token
     */
    public function checkToken(Request $request)
    {
        try {
            $token   = JWTAuth::getToken();
            $payload = JWTAuth::getPayload($token);
            $user    = JWTAuth::parseToken()->authenticate();

            $expiredAt = $payload->get('exp');
            $issuedAt  = $payload->get('iat');
            $now       = now()->timestamp;

            return response()->json([
                'status'  => true,
                'message' => 'Token valid',
                'data'    => [
                    'valid'      => true,
                    'user_id'    => $user->id,
                    'username'   => $user->username,
                    'issued_at'  => date('Y-m-d H:i:s', $issuedAt),
                    'expires_at' => date('Y-m-d H:i:s', $expiredAt),
                    'ttl_left'   => $expiredAt - $now . ' detik',
                ],
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Token sudah kadaluarsa',
                'data'    => [
                    'valid' => false,
                    'code'  => 'TOKEN_EXPIRED',
                ],
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Token tidak valid',
                'data'    => [
                    'valid' => false,
                    'code'  => 'TOKEN_INVALID',
                ],
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Token tidak ditemukan di header',
                'data'    => [
                    'valid' => false,
                    'code'  => 'TOKEN_ABSENT',
                ],
            ], 401);
        }
    }

    /**
     * Refresh token (dapatkan token baru)
     * POST /api/auth/refresh-token
     */
    public function refreshToken(Request $request)
    {
        try {
            $oldToken = JWTAuth::getToken();

            if (!$oldToken) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Token tidak ditemukan',
                    'code'    => 'TOKEN_ABSENT',
                ], 401);
            }

            // Refresh token (generate token baru & blacklist token lama)
            $newToken = JWTAuth::refresh($oldToken);

            return response()->json([
                'status'  => true,
                'message' => 'Token berhasil diperbarui',
                'data'    => [
                    'token' => $this->buildTokenResponse($newToken),
                ],
            ]);
        } catch (TokenExpiredException $e) {
            // Jika token expired terlalu lama (melewati refresh_ttl), tidak bisa di-refresh
            return response()->json([
                'status'  => false,
                'message' => 'Token sudah melewati masa refresh, silakan login kembali',
                'code'    => 'REFRESH_EXPIRED',
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Token tidak valid, tidak dapat di-refresh',
                'code'    => 'TOKEN_INVALID',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memperbarui token',
                'code'    => 'REFRESH_FAILED',
            ], 500);
        }
    }

    /**
     * Helper: build response token dengan metadata
     */
    private function buildTokenResponse(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => config('jwt.ttl') * 60, // dalam detik
            'expires_at'   => now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
        ];
    }
}
