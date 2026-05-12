<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Mail\userLogin;
use App\Mail\userRegister;
use App\Mail\welcomeemail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;

class AuthenticateController extends Controller
{
    use ResponseTrait;

    // Login blade return
    public function login()
    {
        return view('web.pages.login');
    }

    // Register blade return
    public function register()
    {
        return view('web.pages.register');
    }

    // Post login
    public function postLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|exists:users,email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $login = Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);

            if ($login) {
                $user = User::where('email', $request->email)->first();
                $user->update(['last_login_at' => now()]);

                // sent mail to admin welcome to admin panel
                Mail::to($request->email)->send(new userLogin($user));

                return $this->sendSuccess('Login successfully');
            }else{
                return $this->sendError('Invalid email or password');
            }
        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    // Register post
    public function registerPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'number' => 'nullable|numeric',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $param = $request->only(['name', 'email', 'number']);
            $param['password'] = Hash::make($request->password);
            $register = new User();
            $register->fill($param)->save();
            $user = $register;

            if ($user) {
                Mail::to($request->email)->send(new userRegister($user));
                return $this->sendSuccess('Register successfully');
            }else{
                return $this->sendError('Failed to register');
            }

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    // Google Login
    public function googleLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firebase' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $factory = (new Factory)->withServiceAccount(config_path('firebase.json'));

            try {
                $auth = $factory->createAuth();
                $verifiedIdToken = $auth->verifyIdToken($request->firebase);
                $verifiedIdToken->toString();
                $uid = $verifiedIdToken->claims()->get('sub');
                if (!User::where('social_id',$uid)->exists()) {
                    $user = $auth->getUser($uid);
                    $filename = "";
                    if (!empty($user->photoUrl)){
                        $filename = fileName('png');
                        if (!file_exists(public_path("upload"))){
                            mkdir(public_path("upload"), 0777, true);
                        }

                        file_put_contents(public_path("upload/$filename"),file_get_contents($user->photoUrl));
                    }
                    $params['social_id'] = $uid;
                    $params['email'] = $user->email;
                    $params['name'] = $user->displayName;
                    $params['profile_image'] = $filename;
                    $insert = new User();
                    $insert->fill($params)->save();
                }

                $user = User::where('social_id',$uid)->first();
                if(Auth::loginUsingId($user->id)){
                    Mail::to($request->email)->send(new userLogin($user));
                    return $this->sendSuccess("User logged in successfully");
                }else{
                    return $this->sendError("Failed to login !");
                }
            }catch (\Exception $exception){
                return $this->sendException($exception->getMessage());
            }
        }catch (\Exception $exception){
            return $this->sendException($exception->getMessage());
        }
    }

    // Facebook login
    public function facebookLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firebase' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $factory = (new Factory)->withServiceAccount(config_path('firebase.json'));

            try {
                $auth = $factory->createAuth();
                $verifiedIdToken = $auth->verifyIdToken($request->firebase);

                $uid = $verifiedIdToken->claims()->get('sub');

                $userRecord = $auth->getUser($uid);

                if (!User::where('social_id', $uid)->exists()) {

                    $filename = "";

                    // Facebook sometimes has no photoUrl
                    if (!empty($userRecord->photoUrl)) {
                        $filename = fileName('png');

                        if (!file_exists(public_path("upload"))) {
                            mkdir(public_path("upload"), 0777, true);
                        }

                        file_put_contents(
                            public_path("upload/$filename"),
                            file_get_contents($userRecord->photoUrl)
                        );
                    }

                    $params = [];
                    $params['social_id'] = $uid;
                    $params['email'] = $userRecord->email ?? null;
                    $params['name'] = $userRecord->displayName ?? 'Facebook User';
                    $params['profile_image'] = $filename;

                    $insert = new User();
                    $insert->fill($params)->save();
                }

                $user = User::where('social_id', $uid)->first();

                if (Auth::loginUsingId($user->id)) {
                    return $this->sendSuccess("User logged in successfully");
                }

                return $this->sendError("Failed to login !");

            } catch (\Exception $exception) {
                return $this->sendException($exception->getMessage());
            }

        } catch (\Exception $exception) {
            return $this->sendException($exception->getMessage());
        }
    }

    // Logout
    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
