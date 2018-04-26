<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;
use App\Transformers\CategoryTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class CategoryController extends ApiController
{
    private $categoryObject;

    public function __construct()
    {
    	$this->categoryObject = new Category;
    }

    private function collectionCategoryTransformerPagination($data, $paginator)
    {
    	$data = fractal()
    			->collection($data, new CategoryTransformer())
    			->paginateWith(new IlluminatePaginatorAdapter($paginator))
    			->toArray();
    	return $data;
    }

    private function collectionCategoryTransformer($data)
    {
    	$data = fractal()
    			->collection($data, new CategoryTransformer())
    			->toArray();
    	return $data;
    }
    
    private function singleCategoryTransformer($data)
    {
    	$data = fractal()
    			->item($data, new CategoryTransformer())
    			->toArray();
    	return $data;
    }

    public function showCategories()
    {
    	$paginator = $this->categoryObject->getCategories();
    	$categories = $paginator->getCollection();

    	if(count($categories) > 0) {
    		$data = $this->collectionCategoryTransformerPagination($categories, $paginator);
    		return $this->respond($data);
    	}
    	return $this->respondNotFound('empty');
    }

    public function saveCategory(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories,category_name|max:255|min:3',
        ]);

        if($validator->fails()) {
           return $this->respondFailedCondition($validator);
        }

        $data = [
        	'category_name' => $request->category_name
        ];

        if($this->categoryObject->saveCategory($data)) {
        	return $this->respondCreated('Category successfully created');
        } else {
        	return $this->respondInternalError();
        }
    }

    public function updateCategory($id, Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'category_name' => 'required|max:255|min:3',
        ]);

        if($validator->fails()) {
           return $this->respondFailedCondition($validator);
        }
        $category = $this->categoryObject->findCategory($id);
        $data = [
        	'category_name' => $request->category_name
        ];
        if($category) {
            if($this->categoryObject->updateCategory($data, $id)) {
	        	return $this->respondCreated('Successfully updated');
	        } else {
	        	return $this->respondInternalError();
	        }
        } else {
            return $this->respondNotFound('Topic not Found');
        }
    }

    public function destroyCategory($id)
    {
    	$category = $this->categoryObject->findCategory($id);
    	if($category) {
    		if($this->categoryObject->deleteCategory($id)){
    			return $this->respondCreated('Successfully deleted');
    		} else {
    			return $this->respondInternalError();
    		}
    	} else {
    		return $this->respondNotFound('Topic not Found');
    	}
    }
}
