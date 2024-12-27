<?php

use App\Service\Pms\HotelChainPmsService;
use DI\Container;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use App\Service\HttpClient\GuzzleHttpClient;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/** @var Container $container */

// PMS Service
$container->set('pms', function (){
	return new HotelChainPmsService(new GuzzleHttpClient());
});

//Entity Manager
$container->set(EntityManager::class, static function (Container $c): EntityManager {
	/** @var array $settings */
	$settings = $c->get('settings');

	// Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
	// You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
	$cache = $settings['doctrine']['dev_mode'] ?
		DoctrineProvider::wrap(new ArrayAdapter()) :
		DoctrineProvider::wrap(new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']));

	$config = Setup::createAttributeMetadataConfiguration(
		$settings['doctrine']['metadata_dirs'],
		$settings['doctrine']['dev_mode'],
		null,
		$cache
	);

	return EntityManager::create($settings['doctrine']['connection'], $config);
});