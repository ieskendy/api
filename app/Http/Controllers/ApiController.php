<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;

class ApiController extends Controller
{
    protected $statusCode = IlluminateResponse::HTTP_OK;
    
   /**
    * 	Set Status code
    * 	@param $statusCode
    *	@return $this
	*
	*/

    public function setStatusCode($statusCode)
    {
    	$this->statusCode = $statusCode;

    	return $this;
    }

    /**
    * 	get Status code
    * 
    *	@return $statusCode
	*
	*/

    public function getStatusCode()
    {
    	return $this->statusCode;
    }

     /**
    * 	Respond with the request
    * 	@param $data, $header
    *	@return $this
	*
	*/

    public function respond($data, $headers = [])
    {
    	return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
    *   Respond with invalid request
    *   @param $message
    *   @return $repond
    *
    */

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message'   => $message,
                'error'     => $this->getStatusCode()
            ]
        ]);
    }

    /**
    *   Respond with not found data
    *   @param $message
    *   @return $mixed
    *
    */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

     public function respondInternalError($message = 'Internal error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

   /**
    *   Respond with created object
    *   @param $message
    *   @return $mixed
    *
    */

    public function respondCreated($message = 'Successfully created')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond([
                'message' => $message 
        ]);
    }

   /**
    *   Respond with Invalid content of the request
    *   @param $message
    *   @return $mixed
    *
    */

    public function respondFailedCondition($message = 'Invalid Content')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    /**
    *   Respond with UNAUTHORIZED request
    *   @param $message
    *   @return $mixed
    *
    */
    
    public function respondUnauthorized($message = 'UNAUTHORIZED')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }
}