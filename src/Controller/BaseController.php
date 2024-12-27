<?php

namespace App\Controller;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use App\Service\Booking\Find;
use Psr\Container\NotFoundExceptionInterface;

class BaseController
{
    protected ContainerInterface $container;

	/**
	 * @param   ContainerInterface  $c
	 */
    public function __construct(ContainerInterface $c){
        $this->container = $c;
    }

	/**
	 * @return Find
	 *
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	protected function getServiceFindBooking(): Find
	{
		return $this->container->get('find_booking_service');
	}
}