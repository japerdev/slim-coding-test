<?php
/**
 * @package     Service\HttpClient
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace App\Service\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class GuzzleHttpClient implements IHttpClient
{

	const URI = "https://cluster-dev.acme-app.com/sta/pms-faker/acme/test/pms?ts=0";

	private Client $httpClient;

	public function __construct(){
		$this->httpClient = new Client();
	}

	/**
	 * @return array
	 *
	 * @throws GuzzleException
	 */
	public function send(): array
	{
		$request = new Request('GET', self::URI);

		return json_decode($this->httpClient->send($request)->getBody()->getContents(), true);
	}
}