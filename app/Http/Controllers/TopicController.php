<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use Validator;
use App\Transformers\TopicTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TopicController extends ApiController
{
    private $topicObject;

    public function __construct()
    {
    	$this->topicObject = new Topic;
    }

    private function collectionTopicTransformerPagination($data, $paginator)
    {
    	$data = fractal()
    			->collection($data, new TopicTransformer())
    			->paginateWith(new IlluminatePaginatorAdapter($paginator))
    			->toArray();
    	return $data;
    }

    private function collectionTopicTransformer($data)
    {
    	$data = fractal()
    			->collection($data, new TopicTransformer())
    			->toArray();
    	return $data;
    }
    
    private function singleTopicTransformer($data)
    {
    	$data = fractal()
    			->item($data, new TopicTransformer())
    			->toArray();
    	return $data;
    }

    public function showTopics()
    {
    	$paginator = $this->topicObject->getAllTopics();
    	$topics = $paginator->getCollection();

    	if(count($topics) > 0) {
    		$data = $this->collectionTopicTransformerPagination($topics, $paginator);
    		return $this->respond($data);
    	}
    	return $this->respondNotFound('empty');
    	
    }

    public function showTopicByCategories($id)
    {
        $paginator = $this->topicObject->getTopicsByCategory($id);
        $topics = $paginator->getCollection();
        if(count($topics) > 0) {
            $data = $this->collectionTopicTransformerPagination($topics, $paginator);
            return $this->respond($data);
        }
        return $this->respondNotFound('empty');
    }

    public function showTopic($id)
    {
    	$topic = $this->topicObject->getTopic($id);
    	if($topic) {
    		$data = $this->singleTopicTransformer($topic);
    		return $this->respond($data);
    	}

    	return $this->respondNotFound('Topic not Found');
    }

    public function showUserTopics($user_id)
    {
    	$paginator = $this->topicObject->getTopicsByUserId($user_id);
        $topics = $paginator->getCollection();
    	if(count($topics) > 0) {
    		 $data = $this->collectionTopicTransformerPagination($topics, $paginator);
    		return $this->respond($data);
    	}

    	return $this->respondNotFound('empty');
    }

    public function showUserTopic($user_id, $topic_id)
    {
    	$topic = $this->topicObject->getTopicByUser($user_id, $topic_id);
    	if($topic) {
    		$data = $this->singleTopicTransformer($topic);
    		return $this->respond($data);
    	}

    	return $this->respondNotFound('Topic not found');
    }

    public function storeNewTopic(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'title' => 'required|max:255|min:3',
            'content' => 'required'
        ]);

        if($validator->fails()) {
           return $this->respondFailedCondition($validator);
        }

        $data = [
    		'user_id'	=> $request->user_id,
    		'content'	=> $request->content,
    		'title'		=> $request->title
    	];

    	if($this->topicObject->saveNewTopic($data)) {
    		return $this->respondCreated();
    	}

    	return $this->respondInternalError();
    }

    public function updateTopic(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'title' => 'required|max:255|min:3',
            'content' => 'required'
        ]);

        if($validator->fails()) {
           return $this->respondFailedCondition($validator);
        }

        $data = [
    		'user_id' 	=> $request->user_id,
    		'title'		=> $request->title,
    		'content'	=> $request->content
    	];

        $topic = $this->topicObject->findTopic($id);
        if($topic) {
            if($this->topicObject->updateTopic($id, $data)) {
                return $this->respondCreated('Topic successfully updated');
            } else {
                return $this->respondInternalError();    
            }
        } else {
            return $this->respondNotFound('Topic not Found');
        }
    }

    public function destroyTopic($id)
    {
    	$topic = $this->topicObject->findTopic($id);
        if($topic) {
            if($this->topicObject->deleteTopic($id)) {
                return $this->respondCreated('Topic successfully deleted');
            } else {
                return $this->respondInternalError();
            }
        } else {
            return $this->respondNotFound('Topic not Found');
        }
    }
}
