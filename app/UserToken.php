<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $fillable = [
    	'user_id',
    	'token'
    ];

    public function checkUserToken($token)
    {
    	$token = $this->where('token', $token)->first();
    	if(count($token) > 0) {
    		return TRUE;
    	} 
    	return FALSE;
    }

    public function saveUserToken($data)
    {
    	$this->fill($data);
    	if($this->save()) {
    		return TRUE;
    	}
    	return FALSE;
    }

    public function generateToken()
    {	
    	$token = str_random(10);
    	if($this->validateToken($token)) {
    		return $this->generateToken();
    	}
    	return $token;
    }

    private function validateToken($token) 
    {
    	$token = $this->where('token', $token)->first();
    	if(count($token) > 0) {
    		return TRUE;
    	} 
    	return FALSE;
    }
}
