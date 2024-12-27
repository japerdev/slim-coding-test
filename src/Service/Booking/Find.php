<?php
/**
 * @package     Service\Booking
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace App\Service\Booking;

use App\Repository\BookingRepository;
use App\Entity\Booking;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

final class Find
{
	/**
	 * @param   BookingRepository  $bookingRepository
	 */
	public function __construct(protected BookingRepository $bookingRepository) {
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
	 * @since version
	 */
	public function getOne(string $hotel, string $room): Booking
	{
		return $this->bookingRepository->getBooking($hotel, $room);
	}
}