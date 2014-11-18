Shield
============

Maintenance manager for Nette Framework will help you set your website into maintenance mode whilst allowing access to provided IP addresses.

Add Shield configuration to your config file:
```php
// Build configuration
return array
(
	// Nette Framework extensions
	'extensions' => array
	(
		'shield' => \JuniWalk\Security\Shield\Extension::class,
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
