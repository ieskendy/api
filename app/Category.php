<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable = [
    	'category_name'
    ];

    // protected $hidden = ['deleted_at']
    use SoftDeletes;
    protected $date = ['deleted_at'];

    public function saveCategory($data) {
    	$this->fill($data);
    	if($this->save()) {
    		return TRUE;
    	}
    	return FALSE;
    }

    public function findCategory($id)
    {
    	$category = $this->find($id);
        return $category;
    }

    public function getCategories($paginate = 5)
    {
        $categories = $this->paginate($paginate);
        return $categories;
    }

    public function updateCategory($data, $id)
    {
    	$edit = $this->find($id);
    	if($edit->update($data)) {
    		return $edit;
    	}

    	return FALSE;
    }

    public function deleteCategory($id)
    {
    	$destory = $this->find($id);
    	if($destory->delete()) {
    		return $destory;
    	}

    	return FALSE;
    }
}
