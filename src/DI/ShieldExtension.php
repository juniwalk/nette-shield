<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\DI;

use JuniWalk\Shield\Shield;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Helpers;

class ShieldExtension extends \Nette\DI\CompilerExtension
{
    /**
     * DI Tag name
     *
     * @var string
     */
    const TAG = 'shield';

    /**
     * Default configuration
     *
     * @var array
     */
    public $defaults = [
        'enabled' => false,
        'debugger' => true,

        // Action to take
        'action' => [
            // No action will be taken
            'type' => Shield::NONE,
            'path' => null,
        ],

        // Allowed hosts
        'hosts' => [
            '127.0.0.1',  // Localhost IPv4
            '::1',        // Localhost IPv6
        ],
    ];


    /**
     * Register OAuth in Nette's DI constainer
     */
    public function loadConfiguration()
    {
        // Get the configuration values extending defaults
        $config = $this->getConfig($this->defaults);

        // Create new Shield service in the DI Container
        $this->getContainerBuilder()->addDefinition($this->prefix(static::TAG))
            ->setClass('\JuniWalk\Shield\Shield', [$config]);
    }

	/**
	 * TODO: Define documentation
	 */
    public function afterCompile(ClassType $class)
    {
        // Add authomatic Shield::isAuthorized() call
        $init = $class->methods['initialize'];
        $init->addBody(Helpers::format(
            '$this->getService(?)->isAuthorized();',
            $this->prefix(static::TAG)
        ));
    }
}
