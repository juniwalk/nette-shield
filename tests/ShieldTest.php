<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

use JuniWalk\Shield\Bridge\ShieldPanel;
use JuniWalk\Shield\Shield;
use Nette\Http\Response;

class ShieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Shield instance holder.
     */
    protected $shield;

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
        'hosts' => [],
    ];


    /**
     * Create symlinks for needed files.
     */
    protected function setUp()
    {
        // Prepare server properties in enviroment
        $_SERVER['REMOTE_ADDR'] = '255.255.255.255';
    }


    /**
     * Case - Disabled Shield test.
     */
    public function testShieldDisabled()
    {
        $shield = $this->getInstance();
    }


    /**
     * Get configuration.
     * @param  array  $config  Custom config
     * @return Shield
     */
    protected function getInstance(array $config = [])
    {
        // Merge the config with default values
        $config = array_merge($this->defaults, $config);

        // Return instance of the Shield class with all it's dependencies
        return new Shield($config, new ShieldPanel, new Response);
    }
}
