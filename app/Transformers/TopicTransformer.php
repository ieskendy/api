<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($topic)
    {
        return [
            'id'            => $topic->id,
            'user_id'       => $topic->user_id,
            'title'         => $topic->title,
            'content'       => $topic->content,
            'first_name'    => $topic->fname,
            'last_name'     => $topic->lname,
            'email'         => $topic->email
        ];
    }
}
