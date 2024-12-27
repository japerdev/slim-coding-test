<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\Uuid;

#[Entity, Table(name: 'bookings')]
class Booking
{
	#[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
	private int $id;

	#[Column(name: 'booking_uuid', type: 'string', unique: true, nullable: false)]
	private string $bookingId;

	#[Column(name: 'hotel', type: 'string', nullable: false)]
	private string $hotel;

	#[Column(name: 'locator', type: 'string', unique: true, nullable: false)]
	private string $locator;

	#[Column(name: 'room', type: 'string', nullable: false)]
	private string $room;

	#[Column(name: 'check_in', type: 'datetime', nullable: false)]
	private DateTime $checkIn;

	#[Column(name: 'check_out', type: 'datetime', nullable: false)]
	private DateTime $checkOut;

	#[Column(name: 'nights', type: 'integer', nullable: false)]
	private int $numberOfNights;

	#[Column(name: 'total_pax', type: 'integer', nullable: false)]
	private int $totalPax;

	#[OneToMany(mappedBy: 'booking', targetEntity: Guest::class, cascade: ['ALL'], indexBy: 'id')]
	private Collection $guests;

	public function __construct(){
		$this->bookingId = Uuid::uuid4()->toString();
		$this->guests = new ArrayCollection();
	}

	/**
	 * @return object
	 */
	public function toJson(): object
	{
		$guests = array();
		foreach($this->getGuests() as $guest){
			$guests[] = $guest->toJson();
		}
		$json = json_decode((string) json_encode(get_object_vars($this)), false);
		$json->checkIn = date("Y-m-d", strtotime($json->checkIn->date));
		$json->checkOut = date("Y-m-d", strtotime($json->checkOut->date));
		$json->guests = $guests;
		unset($json->id);
		return $json;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getBookingId(): string
	{
		return $this->bookingId;
	}

	/**
	 * @return string
	 */
	public function getHotel(): string
	{
		return $this->hotel;
	}

	/**
	 * @param   string  $hotel
	 */
	public function setHotel(string $hotel): void
	{
		$this->hotel = $hotel;
	}

	/**
	 * @return string
	 */
	public function getLocator(): string
	{
		return $this->locator;
	}

	/**
	 * @param   string  $locator
	 */
	public function setLocator(string $locator): void
	{
		$this->locator = $locator;
	}

	/**
	 * @return string
	 */
	public function getRoom(): string
	{
		return $this->room;
	}

	/**
	 * @param   string  $room
	 */
	public function setRoom(string $room): void
	{
		$this->room = $room;
	}

	/**
	 * @return DateTime
	 */
	public function getCheckIn(): DateTime
	{
		return $this->checkIn;
	}

	/**
	 * @param   DateTime  $checkIn
	 */
	public function setCheckIn(DateTime $checkIn): void
	{
		$this->checkIn = $checkIn;
	}

	/**
	 * @return DateTime
	 */
	public function getCheckOut(): DateTime
	{
		return $this->checkOut;
	}

	/**
	 * @param   DateTime  $checkOut
	 */
	public function setCheckOut(DateTime $checkOut): void
	{
		$this->checkOut = $checkOut;
	}

	/**
	 * @return int
	 */
	public function getNumberOfNights(): int
	{
		return $this->numberOfNights;
	}

	/**
	 * @param   int  $numberOfNights
	 */
	public function setNumberOfNights(int $numberOfNights): void
	{
		$this->numberOfNights = $numberOfNights;
	}

	/**
	 * @return int
	 */
	public function getTotalPax(): int
	{
		return $this->totalPax;
	}

	/**
	 * @param   int  $totalPax
	 */
	public function setTotalPax(int $totalPax): void
	{
		$this->totalPax = $totalPax;
	}

	/**
	 * @return Collection
	 */
	public function getGuests(): Collection
	{
		return $this->guests;
	}

	/**
	 * @param   Guest  $guest
	 *
	 * @return $this
	 */
	public function addGuest(Guest $guest): static
	{
		if (!$this->guests->contains($guest)) {
			$this->guests->add($guest);
			$guest->setBooking($this);
		}

		return $this;
	}

	/**
	 * @param   Guest  $guest
	 *
	 * @return $this
	 */
	public function removeOrder(Guest $guest): static
	{
		if ($this->guests->removeElement($guest)) {
			// set the owning side to null (unless already changed)
			if ($guest->getBooking() === $this) {
				$guest->setBooking(null);
			}
		}

		return $this;
	}
}