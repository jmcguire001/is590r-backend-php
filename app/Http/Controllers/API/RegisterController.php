<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Mail\forgotPassword;
use App\Mail\PasswordReset;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());     
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $user->tokens()->delete();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
    
        $user = User::find($request->id);
        $user->tokens()->where('id', $request->token)->delete();
        $success['id'] =  $request->id;

        return $this->sendResponse($success, 'User logout successfully. Token cleared.');
    }

    public function forgotPassword(Request $request): Response{
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email|min:3'
        ]);

        $success = [];
        if($validator->fails()){
            return $this->sendResponse(result: $success,message: '--Check your email for password reset.');
        }

        $user = User::where(column: 'email',operator: $request->email)->first();
        $user = User::findOrFail(id: $user->id);
        $user->remember_token = Str::random(length: 30);
        $user->save();

        Mail::to(users: $user->email)->send(mailable: new ForgotPassword(user: $user));

        $success['remember_token'] = $user->remember_token;
        return response('Success! Check your email for further instructions.', 200);
    }

    public function passwordReset(Request $request): Response|string{
        $validator = Validator::make(data: $request->all(), rules: [
            'remember_token' => 'required',
            'setPassword' => 'nullable|string',
        ]);

        if($validator->fails()){
            return $this->sendResponse(result: [],message: '--Check your email for password reset email.');
        }

        $remember_token = $request['remember_token'];

        if(!$remember_token) {
            return $this->sendError(error: 'Token expired or incorrect.', errorMessages: ['error'=>'Token expired or incorrect.']);
        }

        $user = User::where(column: 'remember_token',operator: $remember_token)->first();

        if(!$user){
            return $this->sendError(error: 'Token expired or incorrect.', errorMessages: ['error'=>'Token expired or incorrect.']);
        }

        $user = User::find(id: $user->id);
        $newPassword = $request['setPassword'];
        if(!$request['setPassword']){
            $newPassword = Str::random(length: 8);
        }

        $user->password = password_hash(password: $newPassword,algo:PASSWORD_BCRYPT);
        $user->remember_token = null;
        $user->save();
        
        if($request['setPassword']) {
            return $this->sendResponse(result: [], message: 'Password reset successfully.');
        }

        Mail::to(users: $user->email)->send(mailable: new PasswordReset(newPassword: $newPassword));

        return 'Password reset complete. Email sent with a temporary new password!';
    }
}
