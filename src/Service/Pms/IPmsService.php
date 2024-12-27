<?php
/**
 * @package     Service\Pms
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace App\Service\Pms;

use App\Entity\Booking;

interface IPmsService
{
	/**
	 * @param   string  $hotel_id
	 * @param   string  $room
	 *
	 * @return Booking
	 */
	public function getBooking(string $hotel_id, string $room): Booking;
}