<?php

namespace App\Service\Pms;

use App\Entity\Booking;
use App\Entity\Guest;
use App\Exceptions\HotelChainException;
use App\Service\HttpClient\IHttpClient;
use DateTime;
use Exception;

class HotelChainPmsService implements IPmsService
{
	private array $hotelIds = [
		'70ce8358-600a-4bad-8ee6-acf46e1fb8db' => '36001',
		'3cbcd874-a7e0-4bb3-987e-eb36f05b7e7a' => '28001',
		'ca385c3b-c2b1-4691-b433-c8cd51883d25' => '28003',
		'5ab1d247-19ea-4850-9242-2d3ffbbdb58d' => '49001'
	];
	private IHttpClient $httpClient;

	/**
	 * @param   IHttpClient  $httpClient
	 */
	public function __construct(IHttpClient $httpClient){
		$this->httpClient = $httpClient;
	}

	/**
	 * @param   string  $hotel
	 * @param   string  $room
	 *
	 * @return Booking
	 *
	 * @throws HotelChainException
	 */
	public function getBooking(string $hotel, string $room): Booking
	{
		if(!isset($this->hotelIds[$hotel])){
			throw new HotelChainException("Hotel not found");
		}

		$response = $this->httpClient->send();

		if(!isset($response['bookings'])){
			throw new HotelChainException("There are no bookings");
		}

		$hotelChainId = $this->hotelIds[$hotel];
		$hotelChainBooking = array_values(array_filter($response['bookings'], function($booking) use ($hotelChainId, $room){
			return $booking['hotel_id'] == $hotelChainId && $booking['booking']['room'] == $room;
		}));

		if(count($hotelChainBooking) == 0){
			throw new HotelChainException("There are no bookings for this hotel and this room");
		}

		return $this->createBooking($hotel, $room, $hotelChainBooking);
	}

	/**
	 * @param $hotel
	 * @param $room
	 * @param $hotelChainBooking
	 *
	 * @return Booking
	 *
	 * @throws Exception
	 */
	private function createBooking($hotel, $room, $hotelChainBooking) : Booking
	{
		$booking = new Booking();
		$booking->setHotel($hotel);
		$booking->setLocator($hotelChainBooking[0]['booking']['locator']);
		$booking->setRoom($room);
		$checkIn = new DateTime($hotelChainBooking[0]['booking']['check_in']);
		$booking->setCheckIn($checkIn);
		$checkOut = new DateTime($hotelChainBooking[0]['booking']['check_out']);
		$booking->setCheckOut($checkOut);
		$booking->setNumberOfNights($checkIn->diff($checkOut)->days);
		$booking->setTotalPax(array_sum(array_values($hotelChainBooking[0]['booking']['pax'])));
		$guest = new Guest();
		$guest->setName($hotelChainBooking[0]['guest']['name']);
		$guest->setLastname($hotelChainBooking[0]['guest']['lastname']);
		$birthdate = new DateTime($hotelChainBooking[0]['guest']['birthdate']);
		$guest->setBirthdate($birthdate);
		$guest->setPassport($hotelChainBooking[0]['guest']['passport']);
		$guest->setCountry($hotelChainBooking[0]['guest']['country']);
		$guest->setAge($birthdate->diff(new DateTime())->y);
		$booking->addGuest($guest);

		return $booking;
	}

}