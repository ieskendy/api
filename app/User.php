<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'about_me',
        'password'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];


    protected $date = ['deleted_at'];

    public function getAllUser($paginate = 5)
    {
        $users = $this->paginate($paginate);
        return $users;
    }

    public function findTopic($id)
    {
        $user = $this->find($id);
        return $user;
    }

    public function saveNewUser($data)
    {
        $this->fill($data);
        
        if($this->save()) {
            return TRUE;
        }
        return FALSE;
    }

    public function updateUser($id, $data)
    {
        $user = $this->getUser($id);
        if($user->update($data)) {
            return TRUE;
        } 
        return FALSE;
    }

    public function deleteUser($id)
    {
        $user = $this->getUser($id);
        if($user->delete()) {
            return TRUE;
        }
        return FALSE;
    }
}
