<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\DI;

use Nette\DI\Config\Helpers;
use Nette\InvalidStateException;

class ShieldExtension extends \Nette\DI\CompilerExtension
{
    /**
     * Default configuration.
     * @var array
     */
    public $defaults = [
        'enabled' => false,
        'debugger' => true,
        'autorun' => true,

        // Action to take
        'actions' => [],

        // Allowed hosts
        'hosts' => [
            '127.0.0.1',    // Localhost IPv4
            '::1',          // Localhost IPv6
        ],
    ];


    /**
    * Register all Shield classes into DI container.
    */
    public function beforeCompile()
    {
        // Get configuration with default values
        $config = $this->getConfig($this->defaults);

        // If validateConfig method is available for use
        if (method_exists($this, 'validateConfig')) {
            // Get the config validated for default values
            $config = $this->validateConfig($this->defaults);
        }

        // Create new ShieldPanel service in the DI Container
        $this->getContainerBuilder()
            ->addDefinition('juniwalk.shield.panel')
            ->setClass('JuniWalk\Shield\Bridge\ShieldPanel');

        // Create new Shield service in the DI Container
        $this->getContainerBuilder()
            ->addDefinition('juniwalk.shield')
            ->setClass('JuniWalk\Shield\Shield', [ $config ])
            ->addTag('run');
    }
}
