Shield
============

Maintenance manager for Nette Framework will help you set your website into maintenance mode whilst allowing access to provided IP addresses.

[![Travis](https://img.shields.io/travis/juniwalk/shield.svg?style=flat-square)](https://travis-ci.org/juniwalk/shield)
[![Latest Packagist Version](https://img.shields.io/packagist/v/juniwalk/shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/shield)
[![Total Donwloads](https://img.shields.io/packagist/dt/juniwalk/shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/shield)
[![Code Quality](https://img.shields.io/scrutinizer/g/juniwalk/shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/shield/)
[![License](https://img.shields.io/packagist/l/juniwalk/shield.svg?style=flat-square)](https://mit-license.org)

Add Shield configuration to your config file:
```php
// Build configuration
return array
(
	// Nette Framework extensions
	'extensions' => array
	(
		'shield' => \JuniWalk\Shield\DI\NetteExtension::class,
	),

	// Shield extension
	'shield' => array
	(
		'enabled' => true,  // Enable Shield
		'debugger' => true, // Display in Tracy bar
		'hosts' => array    // List of allowed IP addresses
		(
			'127.0.0.1',      // Localhost
			'231.200.103.14', // Random IP1
			'91.232.247.14',  // Random IP2
		),
	),
);
```

And then call Shield in your bootstrap.php file:
```php
// If there is Shield service enabled and visitor is not authorized to see this page right now
if ( $container->hasService('shield') AND !$container->getService('shield')->isAuthorized( ) )
{
	// Show maintenance page to the visitor
	include __DIR__ ."/../.maintenance.php"; exit;
}
```

**Beware!** Enabling Shield will also enable `\Tracy\Debugger` in strict mode.
