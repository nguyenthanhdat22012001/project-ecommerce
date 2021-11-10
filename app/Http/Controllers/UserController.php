<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function register(Request $request)
    {
    	//Validate data
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:user',
            'password' => 'required|string|min:6|max:50|confirmed',
            'phone' => 'regex:/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/|size:10',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        try {
            //Request is valid, create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            //User created, return success response
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|string|min:6|max:50'
            ],
        );

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ], 400);
        }

        //Request is validated
        //Crean token
        try {
            JWTAuth::factory()->setTTL(1);
            $token = JWTAuth::attempt($credentials);
            $user = User::where('email',$request->email)->first();
            if (! $token) {
                return response()->json([
                	'success' => false,
                	'message' => 'email hoặc mật khẩu không đúng',
                ], 200);
            }
            return response()->json([
                'success' => true,
                'message' => 'Đăng Nhập Thành Công',
                'access_token' => $token,
                'data' => $user,
                'expires_in' => auth()->factory()->getTTL() * 60,
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                	'success' => false,
                	'message' => $e->getMessage(),
                ], 500);
        }
    }

    public function logout(Request $request)
    {

		//Request is validated, do logout
        try {
            auth()->logout();

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function get_user(Request $request)
    {
        // $this->validate($request, [
        //     'token' => 'required'
        // ]);

        // $user = JWTAuth::authenticate($request->token);

        try {
            // $user = Auth::user();
            $user = auth()->user();
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $user,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
      

        return response()->json(['user' => $user]);
    }

    public function refreshToken() {
        try {
            JWTAuth::factory()->setTTL(1);
            return response()->json([
                'success' => true,
                'message' => 'refesh token Thành Công',
                'access_token' => auth()->refresh(),
                'expires_in' => auth()->factory()->getTTL() * 60,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    
    }

    public function change_password(Request $request){
        //Validate data
        $data = $request->all();
        $validator = Validator::make($data, [
            'password' => 'required|string|min:6|max:50|confirmed',
            'password_confirmation' => 'required',
        ],
        [
            'password.required' => 'Nhập Mật khẩu',
            'password.min' => 'Mật Khẩu ít nhất 8 kí tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
         ],
    );
     //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ], 400);
        }
      
        try {
            $idUser = Auth::id();
            $user = User::findOrFail($idUser);

            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password'=> Hash::make($request->password)
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'mật khẩu đã được cập nhật',
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'mật khẩu cũ không đúng',
                ], 200);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }


    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }

        return response([
            'message'=> __($status)
        ], 500);

    }

    public function loginWithGoogle(Request $request)
    {
        $user = $request->user();
        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            return response()->json([
                'success' => true,
                'message' => 'User login succesfully',
                'data' => $existingUser,
            ], 200);
        } else {
            $newUser                    = new User;
            $newUser->google_id         = $user->googleId;
            $newUser->name              = $user->name;
            $newUser->email             = $user->email;
            $newUser->email_verified_at = now();
            $newUser->avatar            = $user->avatar;
            $newUser->save();

            return response()->json([
                'success' => true,
                'message' => 'User login succesfully',
                'data' => $newUser
            ], 200);
        }
    }

}
