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
                	'message' => 'Email ho???c m???t kh???u kh??ng ????ng',
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
                    'message' => '????ng Nh???p Th??nh C??ng',
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
                'message' => '????ng xu???t th??nh c??ng',
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
                'message' => 'refesh token Th??nh C??ng',
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
            'password.required' => 'Nh???p M???t kh???u',
            'password.min' => 'M???t Kh???u ??t nh???t 8 k?? t???',
            'password.confirmed' => 'M???t kh???u x??c nh???n kh??ng kh???p',
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
                    'message' => 'T??i kho???n c???a b???n kh??ng ???????c ?????i m???t kh???u',
                ], 200);
            }
            else{
                if (Hash::check($request->old_password, $user->password)) {
                    $user->update([
                        'password'=> Hash::make($request->password)
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'M???t kh???u ???? ???????c c???p nh???t',
                    ], 200);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message' => 'M???t kh???u c?? kh??ng ????ng',
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
                    'subject' => 'L???y L???i M???t Kh???u',
                    'body' => 'M?? OTP C???a B???n: '. $otp
                ];

                Mail::to($request->email)->send(new MailNe($mail_details));
                return response()->json([
                    'success' => true,
                    'message' => 'G???i mail th??nh c??ng, vui l??ng ki???m tra email',
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'kh??ng ????ng',
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
                    'message' => 'M???t kh???u ???? ???????c c???p nh???t',
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'M?? OTP kh??ng ????ng ho???c user ???? b??? x??a',
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
            'message' => '????ng Nh???p Th??nh C??ng',
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
                	'message' => 'email ho???c m???t kh???u kh??ng ????ng',
                ], 200);
            }
            return response()->json([
                'success' => true,
                'message' => '????ng Nh???p Th??nh C??ng',
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

    public function updateUser(Request $request,$id)
    {
        try {
            $data = User::find($id);    

            if($data != null){
                $update =  $request->all();
                $data->update( $update);

                return response()->json([
                    'success' => true,
                    'message' => 'C???p nh???t Th??nh C??ng',
                    'data' => $data,
                ], 200);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message'=>  'User kh??ng t???n t???i',
                    ]);
                }
            
        }catch (Throwable $e) {
            return response()->json([
                	'success' => false,
                	'message' => $e->getMessage(),
                ], 500);
        };
      
    }
}
