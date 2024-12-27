<?php

namespace Test\TestCase;

use Fig\Http\Message\StatusCodeInterface;

class BookingTest extends TestCase
{

	public function testGetBooking(): void
	{
		$request = $this->createRequest('GET', '/api/v1/booking/ca385c3b-c2b1-4691-b433-c8cd51883d25/170');;
		$response = $this->getAppInstance()->handle($request);

		$result = (string) $response->getBody();

		$this->assertEquals(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
		$this->assertStringContainsString('bookingId', $result);
		$this->assertStringContainsString('hotel', $result);
		$this->assertStringContainsString('room', $result);
		$this->assertStringNotContainsString('error', $result);
	}
}