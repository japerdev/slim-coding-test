<?php
/**
 * @package     Entity
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'guests')]
class Guest
{
	#[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
	private int $id;

	#[Column(name: 'name', type: 'string', nullable: false)]
	private string $name;

	#[Column(name: 'lastname', type: 'string', nullable: false)]
	private string $lastname;

	#[Column(name: 'birthdate', type: 'datetime', nullable: false)]
	private DateTime $birthdate;

	#[Column(name: 'passport', type: 'string', unique: true, nullable: false)]
	private string $passport;

	#[Column(name: 'country', type: 'string', nullable: false)]
	private string $country;

	#[Column(name: 'age', type: 'integer', nullable: false)]
	private int $age;

	#[ManyToOne(targetEntity: Booking::class, inversedBy: 'guests')]
	private Booking $booking;

	/**
	 * @return object
	 */
	public function toJson(): object
	{
		$json = json_decode((string) json_encode(get_object_vars($this)), false);
		$json->birthdate = date("Y-m-d", strtotime($json->birthdate->date));
		unset($json->id);
		unset($json->booking);
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
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param   string  $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getLastname(): string
	{
		return $this->lastname;
	}

	/**
	 * @param   string  $lastname
	 */
	public function setLastname(string $lastname): void
	{
		$this->lastname = $lastname;
	}

	/**
	 * @return DateTime
	 */
	public function getBirthdate(): DateTime
	{
		return $this->birthdate;
	}

	/**
	 * @param   DateTime  $birthdate
	 */
	public function setBirthdate(DateTime $birthdate): void
	{
		$this->birthdate = $birthdate;
	}

	/**
	 * @return string
	 */
	public function getPassport(): string
	{
		return $this->passport;
	}

	/**
	 * @param   string  $passport
	 */
	public function setPassport(string $passport): void
	{
		$this->passport = $passport;
	}

	/**
	 * @return string
	 */
	public function getCountry(): string
	{
		return $this->country;
	}

	/**
	 * @param   string  $country
	 */
	public function setCountry(string $country): void
	{
		$this->country = $country;
	}

	/**
	 * @return int
	 */
	public function getAge(): int
	{
		return $this->age;
	}

	/**
	 * @param   int  $age
	 */
	public function setAge(int $age): void
	{
		$this->age = $age;
	}

	/**
	 * @return Booking
	 */
	public function getBooking(): Booking
	{
		return $this->booking;
	}

	/**
	 * @param   Booking|null  $booking
	 */
	public function setBooking(?Booking $booking): void
	{
		$this->booking = $booking;
	}

}