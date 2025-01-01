<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\VerifyPhoneRequest;
use App\Http\Resources\ProfileCollection;
use App\Http\Services\OtpService;
use App\Http\Shared\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        if ($request->role == UserRole::marketer) {
            $data['referral_code'] = $this->generateReferralCode();
        }
        $user = User::create($data);
        $otp = (new OtpService)->sendOtpPhone($user->id);
        return successResponse(data: ['otp' => $otp]);
    }

    public function send(Request $request)
    {
        if ($request->phone) {
            $type = 'phone';
        } elseif ($request->email) {
            $type = 'email';
        }
        $user = User::where('phone', $request->phone)->orWhere('email', $request->email)->first();
        if (!$user) {
            return failResponse(__('messages.user_not_found'));
        }

        $otpService = new OtpService();
        $otp = $otpService->clear($user->id, $type);
        switch ($type) {
            case 'phone':
                $otp = $otpService->sendOtpPhone($user->id);
                break;
            case 'email':
                $otp = $otpService->sendOtpEmail($user->id);
                break;
        }
        return successResponse(data: ['otp' => $otp]);
    }

    public function verify(Request $request)
    {
        $user = (new OtpService)->verify($request->otp);
        if (!$user) {
            return failResponse('Invalid or expired OTP.');
        }
        $token = JWTAuth::fromUser($user);
        return successResponse(data: $this->respondWithToken($token, $user));
    }

    public function login(LoginRequest $request)
    {
        if (!$token = auth('user')->attempt(request(['phone', 'password']))) {
            return failResponse(__('messages.wrong_user'));
        }
        $user = auth('user')->user();
        if (!$user->phone_verified_at) {
            return failResponse('user not verified');
        }
        return successResponse(data: $this->respondWithToken($token, $user));
    }

    public function verifyPhone(VerifyPhoneRequest $request)
    {
        $user = User::firstWhere('phone', $request->phone);
        if (!$user) {
            return failResponse('phone not found');
        }
        return successResponse();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = auth('user')->user();
        $user->update(['password' => $request->password]);
        return successResponse();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth('user')->user();

        if (Hash::check($request->old_password, $user->password)) {
            $password = Hash::make($request->new_password);
            $user->update(['password' => $password]);
        }
        return successResponse();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth('user')->user();
        $data = $request->validated();
        if ($request->old_password && Hash::check($request->old_password, $user->password)) {
            $data['password'] = $request->new_password;
        }
        $user->update($data);

        return successResponse();
    }

    public function deleteProfile()
    {
        $user = auth('user')->user();
        $user->delete();
        return successResponse();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return successResponse(data: ProfileCollection::make(auth('user')->user()));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('user')->logout();
        return successResponse();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $old_token = JWTAuth::getToken();
        if (!$old_token) {
            return failResponse('Token not provided');
        }
        try {
            $token = auth('user')->refresh();
            $user =  JWTAuth::setToken($token)->toUser();
            return successResponse(data: $this->respondWithToken($token, $user));
        } catch (\Throwable $th) {
            return failResponse('The token is invalid');
        }
    }


    private function generateReferralCode()
    {
        $new_referral_code = Str::random(10);
        while (User::where('referral_code', $new_referral_code)->exists()) {
            $new_referral_code = Str::random(10);
        }
        return $new_referral_code;
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return [
            'access_token' => $token,
            'user' => ProfileCollection::make($user),
        ];
    }
    //google
    public function redirectToGoogle(){
        return Socialite::driver('google')->stateless()->redirect();
    } 
    public function handleGoogleCallback(){
        $user=Socialite::driver('google')->stateless()->user();
        $findUser=User::where('social_id',$user->id)->orWhere('email',$user->email)->first();
        if($findUser){
            Auth::login($findUser);
            $token = auth()->guard('user')->tokenById(auth()->id());
            return $this->createNewToken($token,$findUser);
        }else{
            $newUser=User::create([
                'name'=>$user->name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'social_id'=>$user->id,
                'role'=>'store',
                'country_id'=>'1',
                'social_type'=>'google',
                'password'=>bcrypt('my-google'),
            ]);
            Auth::login($newUser);
            $token = auth()->guard('user')->tokenById(auth()->id());
            return $this->createNewToken($token,$newUser);
        }
    }

    //google react Api
    public function googleAuth(request $request){
    
        $findUser=User::where('social_id',$request->social_id)->orWhere('email',$request->email)->first();
        if($findUser){
            Auth::login($findUser);
            $token = auth()->guard('user')->tokenById(auth()->id());
            return response()->json([
                'message' => 'User already registered and logged in successfully.',
                'data' => $this->createNewToken($token, $findUser)
            ], 200);
        }else{
            $newUser=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'role'=>$request->role,
                'country_id'=>$request->country_id,
                'social_id'=>$request->social_id,
                'social_type'=>'google',
                'password'=>bcrypt('my-google'),
            ]);
            Auth::login($newUser);
            $token = auth()->guard('user')->tokenById(auth()->id());
            return $this->createNewToken($token,$newUser);
        }
    }
    public function createNewToken($token,$user)
    {
        return response()->json([
            'access_token' => $token,
            'token_tybe' => 'bearer',
            'expires_in' => auth()->guard('user')->factory()->getTTl() * 600000,
            'user' => $user,
            // 'user'=>userLoginResource::make(auth()->user())
        ]);
    }

}
