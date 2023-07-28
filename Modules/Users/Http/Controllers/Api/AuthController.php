<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Modules\Users\Http\Requests\Api\auth\RegisterRequest;
use Modules\Users\Http\Requests\api\auth\SendVerificationCode;
use Modules\Users\Http\Requests\api\auth\emailActivationRequest;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $data['phone'] = ltrim($data['phone'], '0');
        $data['email_code'] = rand(00000, 99999);
        $data['phone_code'] = rand(00000, 99999);
        $user = User::create($data);
        event(new \Modules\Users\Providers\SendVerifyCode($user));
        $credentials = ['email' => $user->email, 'password' => $request->password];
        return $this->login($credentials);
    }


    public function login(array $creden = null)
    {
        $credentials = ['password' => request('password')];
        if (filter_var(request('account'), FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = request('account');
        } elseif (intval(request('account'))) {
            $credentials['phone'] = ltrim(request('account'), '0');
        }
        $attempt = !empty($creden) ? $creden : $credentials;
        if (!$token = authApi()->attempt($attempt)) {
            return sendResponse([], 'Unauthenticated', 401);
        }
        $data = [];
        $data['token'] = $this->respondWithToken($token)?->original;
        $data['need_phone_verification'] = authApi()->user()->phone_verified_at != null ? false : true;
        $data['need_email_verification'] = authApi()->user()->email_verified_at != null ? false : true;
        return sendResponse($data, 'Logged in Successfuly', 200);
    }

    public function resnedVerificationCode(SendVerificationCode $request)
    {
        $data = $request->validated();
        $user = User::findOrFail(authApi()->id());
        if ($data['code_type'] == 'email') {
            if ($user->email_code != null) {
                $user->email_code = rand(00000, 99999);
                $user->save();
                event(new \Modules\Users\Providers\SendVerifyCode($user));
                return sendResponse([], 'Activation Code sent  Successfuly');
            } else {
                return sendResponse([], 'Account Already Activated Successfuly');
            }

        }
    }

    public function emailActivation(emailActivationRequest $request)
    {
        $data = $request->validated();
        $user = authApi()->user();
        if ($data['code_type'] == 'email') {
            if ($data['code'] == $user->email_code) {
                $user->email_code = null;
                $user->email_verified_at = now();
                $user->save();
                return sendResponse([], 'Email Verified Successfuly');
            } else {
                return sendResponse([], 'Wrong Verification Code');
            }
        } elseif ($data['code_type'] == 'phone') {
            //
        }
    }

    public function me()
    {
        $data = authApi()->user();
        return sendResponse(authApi()->user(), 'Query Successfuly');
    }


    public function logout()
    {
        authApi()->logout();
        return sendResponse([], 'Logged out Successfully');
    }


    public function refresh()
    {
        $data = $this->respondWithToken(authApi()->refresh());
        return sendResponse($data, 'refreshed Successfuly');
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => authApi()->factory()->getTTL() * 60
        ]);
    }
}