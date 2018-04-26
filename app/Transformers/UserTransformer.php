<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($user)
    {
        return [
            'id'            => $user->id,
            'first_name'    => $user->fname,
            'last_name'     => $user->lname,
            'avatar'        => $user->avatar,
            'email'         => $user->email,
            'about_me'      => $user->about_me
        ];
    }
}
