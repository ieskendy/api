<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Reply extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
    	'topic_id',
    	'user_id',
    	'content'

    ];

    protected $date = ['deleted_at'];

    public function getAllReply($paginator = 10)
    {
        $replies = $this->join('users', 'replies.user_id', 'users.id')
                        ->paginate($paginator);
        return $replies;
    }

    public function getAllReplyByTopic($id, $paginator = 10)
    {
    	$replies = $this->join('users', 'replies.user_id', 'users.id')
    					->where('replies.topic_id', $id)
                        ->orderBy('replies.id', 'asc')
                        ->select('replies.*', 'users.email')
    					->get();
    	return $replies;
    }

    public function saveNewReply($data)
    {
    	$this->fill($data);
    	if($this->save()) {
    		return TRUE;
    	}
    	return FALSE;
    }

    public function updateReply($id, $data)
    {
    	$reply = $this->find($id);
    	if($reply->update($data)) {
    		return TRUE;
    	}

    	return FALSE;
    }

    public function deleteReply($id)
    {
    	$reply = $this->find($id);
    	if($reply->delete()) {
    		return TRUE;
    	}
    	return FALSE;
    }

    public function findReply($id)
    {
        $topic = $this->find($id);
        return $topic;
    }

}
