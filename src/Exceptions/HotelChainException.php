<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class HotelChainException extends Exception
{
	/**
	 * @param   string          $message
	 * @param   int             $code
	 * @param   Throwable|null  $previous
	 */
	public function __construct(string $message = "", int $code = 404, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}