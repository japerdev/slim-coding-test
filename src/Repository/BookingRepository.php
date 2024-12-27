<?php
/**
 * @package     Repository
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace App\Repository;

use App\Entity\Booking;
use App\Service\Pms\IPmsService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class BookingRepository
{
	private EntityManager $em;
	private IPmsService $pmsService;

	/**
	 * @param   IPmsService    $pmsService
	 * @param   EntityManager  $em
	 */
	public function __construct(IPmsService $pmsService, EntityManager $em){
		$this->pmsService = $pmsService;
		$this->em = $em;
	}

	/**
	 * @param   string  $hotel
	 * @param   string  $room
	 *
	 * @return Booking
	 *
	 * @throws NotSupported
	 * @throws ORMException
	 * @throws OptimisticLockException
	 */
	public function getBooking(string $hotel, string $room): Booking
	{
		//Search the booking from database
		$booking = $this->em->getRepository(Booking::class)->findOneBy(array('hotel' => $hotel, 'room' => $room));

		//If the booking doesn´t exist in database, request to PMS
		if(!isset($booking)){
			$booking = $this->pmsService->getBooking($hotel, $room);
			//Persist it in database
			$this->em->persist($booking);
			$this->em->flush();
		}

		return $booking;
	}
}