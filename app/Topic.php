<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Topic extends Model
{

    protected $fillable = [
    	'title',
    	'content',
    	'user_id'
    ];

    // protected $hidden = ['deleted_at']
    use SoftDeletes;
    protected $date = ['deleted_at'];

    public function getAllTopics($paginator = 10)
    {
    	$topics = $this->join('users', 'topics.user_id', 'users.id')
                       ->select('topics.*', 'users.email', 'users.fname', 'users.lname')
                       ->orderBy('topics.id', 'DESC')
                       ->paginate($paginator);
        return $topics; 
    }

    public function getTopic($id)
    {
    	$topic = $this->join('users', 'topics.user_id', 'users.id')
                      ->where('topics.id', $id)
                      ->select('topics.*', 'users.email', 'users.fname', 'users.lname')
                      ->first();
    	return $topic;
    }

    public function getTopicsByUserId($id)
    {
    	$topics = $this->join('users', 'topics.user_id', 'users.id')
                       ->where('user_id', $id)
                       ->select('topics.*', 'users.email', 'users.fname', 'users.lname')
                       ->paginate(10);
    	return $topics;
    }

    public function getTopicByUser($user_id, $topic_id)
    {
        $topic = $this->join('users', 'topics.user_id', 'users.id')
                      ->where('users.id', $user_id)
                      ->where('topics.id', $topic_id)
                      ->select('topics.*', 'users.email', 'users.lname', 'users.fname')
                      ->first();
        return $topic;
    }

    public function getTopicsByCategory($id, $paginator = 10)
    {
        $topics = $this->where('category_id', $id)->paginate($paginator);
        return $topics;
    }

    public function saveNewTopic($data)
    {
        $this->fill($data);
        if($this->save()) {
            return TRUE;
        }

        return FALSE;
    }

    public function updateTopic($id, $data)
    {
        $topic = $this->find($id);
        if($topic->update($data)) {
            return TRUE;
        }

        return FALSE;
    }

    public function deleteTopic($id)
    {
        $topic = $this->find($id);
        if($topic->delete()) {
            return TRUE;
        }

        return FALSE;
    }

    public function findTopic($id)
    {
        $topic = $this->find($id);
        return $topic;
    }

}
