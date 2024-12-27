<?php

namespace App\Handler;

use App\Exceptions\HotelChainException;
use Slim\Handlers\ErrorHandler;
use Psr\Http\Message\ResponseInterface as Response;

class HttpErrorHandler extends ErrorHandler
{
	/**
	 * @return Response
	 */
	protected function respond(): Response
	{
		$exception = $this->exception;
		$statusCode = $exception->getCode();

		if($exception instanceof HotelChainException){
			$message = $exception->getMessage();
		}else{
			$message = "An error has occurred. Please, contact your system administrator.";
		}

		$payload = array("message" => $message);
		$encodedPayload = json_encode($payload, JSON_PRETTY_PRINT);

		$response = $this->responseFactory->createResponse($statusCode);
		$response->getBody()->write($encodedPayload);

		return $response->withHeader('Content-Type', 'application/json');
	}
}