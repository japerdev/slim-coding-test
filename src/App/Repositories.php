<?php

use App\Repository\BookingRepository;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

/** @var Container $container */

// Booking Repository
$container->set('booking_repository', function (ContainerInterface $c){
	return new BookingRepository($c->get('pms'), $c->get(EntityManager::class));
});