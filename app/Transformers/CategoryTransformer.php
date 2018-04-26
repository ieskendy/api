<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($category)
    {
        return [
            'category_id' => $category->id,
            'name' => $category->category_name
        ];
    }
}
