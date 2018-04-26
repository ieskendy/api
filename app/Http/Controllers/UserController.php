<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class UserController extends ApiController
{
    private $userObject;

    public function __construct()
    {
    	$this->userObject = new User;
    }

    private function collectionUserTransformerPagination($data, $paginator)
    {
    	$data = fractal()
    			->collection($data, new UserTransformer())
    			->paginateWith(new IlluminatePaginatorAdapter($paginator))
    			->toArray();
    	return $data;
    }

    private function collectionUserTransformer($data)
    {
    	$data = fractal()
    			->collection($data, new UserTransformer())
    			->toArray();
    	return $data;
    }
    
    private function singleUserTransformer($data)
    {
    	$data = fractal()
    			->item($data, new UserTransformer())
    			->toArray();
    	return $data;
    }

    public function showUsers()
    {
    	$paginator = $this->userObject->getAllUser();
    	$users = $paginator->getCollection();

    	if(count($users) > 0) {
    		$data = $this->collectionUserTransformerPagination($users, $paginator);
    		return $this->respond($data);
    	}

    	return $this->respondNotFound();
    }

    public function showUser($id)
    {
    	$user = $this->userObject->findUser($id);
    	if($user) {
    		$data = $this->singleUserTransformer($user);
    		return $this->respond($data);
    	}
    	return $this->respondNotFound();
    }

    public function updateUserData($id, Request $request)
    {
    	$data = [
    		'fname' => $request->fname,
    		'lname'	=> $request->lname,
    		'email'	=> $request->email,
    		'about_me'	=> $request->about_me,
    	];

        $user = $this->userObject->findUser($id);
        if($user) {
            if($this->userObject->updateUser($id, $data)) {
                return $this->respondCreated('Successfully updated');
            } else {
                return $this->respondInternalError();    
            }
        } else {
            return $this->respondNotFound('User Not Found');
        }

    	
    }

    public function destroyUser($id)
    {
        $user = $this->userObject->findUser($id);
        if($user) {
            if($this->userObject->deleteUser($id)) {
                return $this->respondCreated('Successfully deleted');
            } else {
                return $this->respondInternalError();    
            }
        } else {
            return $this->respondNotFound('Topic Not Found');
        }
    	
    }
}
