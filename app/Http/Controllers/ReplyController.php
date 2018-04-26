<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use Validator;
use App\Transformers\ReplyTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ReplyController extends ApiController
{
    private $replyObject;

    public function __construct()
    {
    	$this->replyObject = new Reply;
    }

    private function collectionReplyTransformerPagination($data, $paginator)
    {
    	$data = fractal()
    			->collection($data, new ReplyTransformer())
    			->paginateWith(new IlluminatePaginatorAdapter($paginator))
    			->toArray();
    	return $data;
    }

    private function collectionReplyTransformer($data)
    {
    	$data = fractal()
    			->collection($data, new ReplyTransformer())
    			->toArray();
    	return $data;
    }
    
    private function singleReplyTransformer($data)
    {
    	$data = fractal()
    			->item($data, new ReplyTransformer())
    			->toArray();
    	return $data;
    }

    public function showReplies()
    {
    	$paginator = $this->replyObject->getAllReply();
    	$replies = $paginator->getCollection();
    	if(count($replies) > 0) {
    		$data = $this->collectionReplyTransformerPagination($replies, $paginator);
    		return $this->respond($data);
    	}
    	return $this->respondNotFound();
    }

    public function showRepliesByTopic($id)
    {
    	$replies = $this->replyObject->getAllReplyByTopic($id);
    	if(count($replies) > 0) {
    		$data = $this->collectionReplyTransformer($replies);
    		return $this->respond($data);
    	}
    	return $this->respondNotFound();
    }

    public function createNewReply(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'topic_id' => 'required|numeric',
            'content' => 'required'
        ]);

        if($validator->fails()) {
           return $this->respondFailedCondition($validator);
        }

        $data = [
    		'user_id' => $request->user_id,
    		'topic_id' => $request->topic_id,
    		'content' => $request->content
    	];

    	if($this->replyObject->saveNewReply($data)) {
    		return $this->respondCreated();
    	}

    	return $this->respondInternalError();
    }

    public function updateReplyData($id, Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'topic_id' => 'required|numeric',
            'content' => 'required'
        ]);

        if($validator->fails()) {
           return $this->respondFailedCondition($validator);
        }
        
        $data = [
    		'user_id' => $request->user_id,
    		'topic_id' => $request->topic_id,
    		'content' => $request->content
    	];
        
        $reply = $this->replyObject->findReply($id);
        if($reply) {
            if($this->replyObject->updateReply($id, $data)) {
                return $this->respondCreated();
            } else {
                return $this->respondInternalError();
            }
        } else {
            return $this->respondNotFound('Reply not Found');
        }
    }

    public function destroyReply($id)
    {
    	$reply = $this->replyObject->findReply($id);
        if($reply) {
            if($this->replyObject->deleteReply($id)) {
                return $this->respondCreated('Successfully deleted');
            } else {
                return $this->respondInternalError();
            }
        } else {
            return $this->respondNotFound('Reply not Found');
        }
    }
}
