<?php

namespace App\Controller;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BookingController extends BaseController
{
	/**
	 * @param   Request   $request
	 * @param   Response  $response
	 * @param             $args
	 *
	 * @return MessageInterface|Response
	 *
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 * @throws \Doctrine\ORM\Exception\NotSupported
	 * @throws \Doctrine\ORM\Exception\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
    public function findByHotelAndRoom(Request $request, Response $response, $args): MessageInterface|Response
    {
	    $jsonBooking = $this->getServiceFindBooking()->getOne($args['hotel'], $args['room']);
	    $response->getBody()->write(json_encode($jsonBooking->toJson()));
        return $response->withHeader('Content-Type', 'application/json');
    }
}