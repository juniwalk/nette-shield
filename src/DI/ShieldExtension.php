<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\DI;

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
    public $defaults = [];


    /**
     * Register Shield in Nette's DI constainer
     */
    public function loadConfiguration()
    {
        // Get the configuration values extending defaults
        $config = $this->getConfig($this->defaults);

        // Create new Shield service in the DI Container
        $this->getContainerBuilder()->addDefinition($this->prefix(static::TAG))
            ->setClass('JuniWalk\Shield\Shield', [ $config ]);
    }
}
