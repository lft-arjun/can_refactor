<?php
namespace Language\Services;

use Language\Api\ApiCall;
use Language\Services\ApiResultCheckInterface;
/**
* 
*/
class ApiService
{
	
	public function __construct()
	{
		# code...
	}

	public function getResult($getParams = array(), $postParams = array(), ApiResultCheckInterface $apiresultchecker)
	{
		$result = ApiCall::call(
			'system_api',
			'language_api',
			$getParams,
			$postParams 
		);

		return $apiresultchecker->checkForApiErrorResult($result);
		
	}
}