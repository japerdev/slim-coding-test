<?php
/**
 * @package     Service\HttpClient
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace App\Service\HttpClient;

interface IHttpClient
{
	/**
	 * @return array
	 */
	public function send(): array;
}