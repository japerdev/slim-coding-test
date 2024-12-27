<?php

use DI\Container;
use App\Service\Booking\Find;
use Psr\Container\ContainerInterface;

/** @var Container $container */

//Find Booking Service
$container->set('find_booking_service', function (ContainerInterface $c){
	return new Find($c->get('booking_repository'));
});
