<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/** @var App $app */
$app->group('/api/v1', function (RouteCollectorProxy $group){
    $group->group('/booking', function(RouteCollectorProxy $group){
        $group->get('/{hotel}/{room}','App\Controller\BookingController:findByHotelAndRoom');
    });

});