<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\UserToken;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
    private $user;
    private $userTokenObject;

    public function __construct()
    {
    	$this->user = new User;
    	$this->userTokenObject = new UserToken;
    }

    public function login(Request $request)
    {
    	try {
    		// get credentianl email and password
            $credentials = [
    			'email' => $request->email,
    			'password' => $request->password
    		];
    		// Attempt to login the user
    		if(Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                $token = [
                    'token' => $this->userTokenObject->generateToken(),
                    'user_id' => Auth::user()->id
                ];
                // Save user token
                if($this->userTokenObject->saveUserToken($token)) {
                    // return the generated token
                    return $this->respond(['token' => $token]);
                } else {
                    return $this->respondInternalError();
                }
                
    		} else {
    			return response()->json(['error' => 'invalid_credentials'], 401);
    		}
    	} catch (Exception $e) {
    		return $this->respondInternalError($e);
    	}
    }

    public function register(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'fname' => 'required|min:2|max:255',
            'lname' => 'required|min:2|max:255',
            'password' => 'required|min:7|max:255',
            'email' => 'required|unique:users,email|email|max:255'
        ]);

        if($validator->fails()) {
           return $this->respondFailedCondition($validator);
        }

        // Get all the data of the user
        $data = [
        	'fname' 	=> $request->fname,
        	'lname'		=> $request->lname,
            'avatar'    => "avatar.png",
        	'email'			=> $request->email,
        	'about_me'	=> $request->about_me,
        	'password'		=> bcrypt($request->password)
        ];
        // Save the user
        if($this->user->saveNewUser($data)) {
            $token = [
                'token' => $this->userTokenObject->generateToken(),
                'user_id' => $this->user->id
            ];
            if($this->userTokenObject->saveUserToken($token)) {
                    // return the generated token
                    return $this->respond(['token' => $token]);
                } else {
                    return $this->respondInternalError();
                }
        	return $this->respond(['token' => $token]);
        } else {
        	return $this->respondInternalError();
        }
    }

}
