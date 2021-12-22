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
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNe;
use App\Models\Store;

class UserController extends Controller
{

    public function register(Request $request)
    {
    	//Validate data
        $data = $request->all();
        if($data){
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'email' => 'required|email|unique:user',
                'password' => 'required|string|min:6|max:50',
                'confirm_password' => 'required|same:password'
            ]);
        }


        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try {
            // return $data['password'];
            //Request is valid, create new user
            $user = User::create([
        	'name' => $data['name'],
        	'email' => $data['email'],
        	'password' => bcrypt($data['password'])
        ]);

           //User created, return success response
           return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);

        } catch (Exception $e) {
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
                'message' => $validator->errors()->first(),
            ], 200);
        }

        //Request is validated
        //Crean token
        try {
            JWTAuth::factory()->setTTL(5);
            $token = JWTAuth::attempt($credentials);
            if (! $token) {
                return response()->json([
                	'success' => false,
                	'message' => 'Email hoặc mật khẩu không đúng',
                ], 200);
            }
            else{
                $user = User::where('email',$request->email)->first();
                $store = Store::where('user_id',$user->id)->first();
                if($store == null){
                    $user['store_id'] = null;
                }else{
                    $user['store_id'] = $store['id'];
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng Nhập Thành Công',
                    'access_token' => $token,
                    'data' => $user,
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ], 200);
            }
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
                'message' => 'Đăng xuất thành công',
            ],200);
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
            $store = Store::where('user_id',$user->id)->first();
            if($store == null){
                $user['store_id'] = null;
            }else{
                $user['store_id'] = $store['id'];
            }
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
    }

    public function refreshToken() {
        try {
            JWTAuth::factory()->setTTL(5);
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
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try {
            $idUser = Auth::id();
            $user = User::findOrFail($idUser);

            if($user->password == null){
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản của bạn không được đổi mật khẩu',
                ], 200);
            }
            else{
                if (Hash::check($request->old_password, $user->password)) {
                    $user->update([
                        'password'=> Hash::make($request->password)
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Mật khẩu đã được cập nhật',
                    ], 200);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Mật khẩu cũ không đúng',
                    ], 200);
                }
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
        try {
            $user = User::where('email',$request->email)->first();
            if ($user) {
                $otp = rand(1000,9999);
                User::where('email',$request->email)->update(['otp' => $otp]);
                $mail_details = [
                    'subject' => 'Lấy Lại Mật Khẩu',
                    'body' => 'Mã OTP Của Bạn: '. $otp
                ];

                Mail::to($request->email)->send(new MailNe($mail_details));
                return response()->json([
                    'success' => true,
                    'message' => 'Gửi mail thành công, vui lòng kiểm tra email',
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'không đúng',
                ], 200);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function reset_password(Request $request)
    {
        try{
            $user  = User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
            if ($user) {
                $user->update([
                    'password'=> Hash::make($request->password)
                ]);
                User::where('email','=',$request->email)->update(['otp' => null]);
                return response()->json([
                    'success' => true,
                    'message' => 'Mật khẩu đã được cập nhật',
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Mã OTP không đúng hoặc user đã bị xóa',
                ], 200);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function loginWithGoogle(Request $request)
    {
        $data = $request->all();
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            $store = Store::where('user_id',$user->id)->first();
            if($store == null){
                $user['store_id'] = null;
            }else{
                $user['store_id'] = $store['id'];
            }
        } else {
            $data['password'] = bcrypt($data['googleId']);
            $user = User::create($data);
            $user['store_id'] = null;
        }
        $credentials=[
            "email" => $data['email'],
            "password" => $data['googleId'],
        ];
        JWTAuth::factory()->setTTL(5);
        $token = JWTAuth::attempt($credentials);
        return response()->json([
            'success' => true,
            'message' => 'Đăng Nhập Thành Công',
            'access_token' => $token,
            'data' => $user,
            'expires_in' => auth()->factory()->getTTL() * 60,
        ], 200);
    }

    /**
     * login admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginAdmin(Request $request)
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
                'message' => $validator->errors()->first(),
            ], 200);
        }

        //Request is validated
        //Crean token
        try {
            JWTAuth::factory()->setTTL(5);
            $token = JWTAuth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 1]);
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
}
