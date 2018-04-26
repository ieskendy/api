<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ReplyTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($reply)
    {
        return [
            'id'         => $reply->id,
            'topic_id'      => $reply->topic_id,
            'user_id'       => $reply->user_id,
            'content'       => $reply->content,
            'email'         => $reply->email
        ];
    }
}
