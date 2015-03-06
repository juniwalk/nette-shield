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
        'enabled' => true,
        'debugger' => true,
        'autorun' => true,

        // Action to take
        'actions' => [],

        // Allowed hosts
        'hosts' => [
            '127.0.0.1',
        ],
    ];


    /**
     * Create symlinks for needed files.
     */
    protected function setUp()
    {
        // Prepare server properties in enviroment
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }


    /**
     * Case - Disabled Shield test.
     */
    public function testDisabled()
    {
        // Set localhost remote address for test
        $_SERVER['REMOTE_ADDR'] = '255.255.255.255';

        // Run disabled shield
        $shield = $this->getInstance([
            'enabled' => false,
        ]);

        // Assert that the Shield really is disabled
        $this->assertFalse($shield->isEnabled());
    }


    /**
     * Case - Authorized access test.
     */
    public function testAuthorized()
    {
        // Run enabled shield
        $shield = $this->getInstance();

        // Assert that the Shield really is disabled
        $this->assertTrue($shield->isEnabled());
        $this->assertTrue($shield->isAuthorized());
    }


    /**
     * Case - Unauthorized access test.
     * @expectedException JuniWalk\Shield\Exception\AbortException
     */
    public function testUnAuthorized()
    {
        // Set some custom IP address for test
        $_SERVER['REMOTE_ADDR'] = '192.168.0.1';

        // Run enabled shield
        $this->getInstance();
    }


    /**
     * Case - Callback action test.
     * @expectedException JuniWalk\Shield\Exception\AbortException
     */
    public function testActionCallback()
    {
        // Run enabled shield
        $this->getInstance([
            // Actions to take
            'actions' => [
                // Custom callback action, just assert enabled Shield
                'callback' => function(Shield $shield) {
                    $this->assertTrue($shield->isEnabled());
                },
            ],
        ]);
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
