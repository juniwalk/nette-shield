<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

use JuniWalk\Shield\Tests\Helpers\Shield;

class ShieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Shield instance
     *
     * @var Shield
     */
    public $shield;


    /**
     * Prepare enviroment for the tests
     */
    protected function setUp()
    {
        // Prepare server properties in enviroment
        $_SERVER['REMOTE_ADDR'] = '255.255.255.255';

        // Create Shield instance
        $this->shield = new Shield(static::getConfig());
    }


    /**
     * Test Shield status
     */
    public function testEnabled()
    {
        // Check that the Shield is enabled
        $this->assertTrue($this->shield->isEnabled());
    }


    /**
     * Test Shield status
     */
    public function testDisabled()
    {
        // Create invalid configuration
        $config = static::getConfig();
        $config['enabled'] = false;

        // Create Shield instance
        $shield = new Shield($config);

        // Check that the Shield is enabled
        $this->assertFalse($shield->isEnabled());
        $this->assertTrue($shield->isAuthorized());
    }


    /**
     * Test authorized visitor
     */
    public function testAuthorized()
    {
        // Override enviroment variable just for this test
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        // Check that the visitor is authorized to continue
        $this->assertTrue($this->shield->isAuthorized());
    }


    /**
     * Test unauthorized visitor
     */
    public function testUnAuthorized()
    {
        // Check that the visitor is no longer authorized
        $this->assertFalse($this->shield->isAuthorized());
    }


    /**
     * Test invalid action list
     *
     * @expectedException JuniWalk\Common\Exceptions\ErrorException
     */
    public function testInvalidActions()
    {
        // Create invalid configuration
        $config = static::getConfig();
        $config['action'] = null;

        // Create Shield instance
        $shield = new Shield($config);
        $shield->isAuthorized();
    }


    /**
     * Test undefined action
     */
    public function testUndefinedAction()
    {
        // Create invalid configuration
        $config = static::getConfig();
        // Prepare our evil action for testing of undefined actions
        $config['action'] = [ 'evalCode' => 'exec("rmdir /srv");' ];

        // Create Shield instance
        $shield = new Shield($config);

        // Check that the visitor is no longer authorized
        $this->assertFalse($shield->isAuthorized());
    }


    /**
     * Test valid action
     */
    public function testValidAction()
    {
        // Prepare our output string for testing
        $output = 'Test output string';

        // Create invalid configuration
        $config = static::getConfig();
        $config['action'] = [ 'setOutput' => $output ];

        // Assign expected output string
        $this->expectOutputString($output);

        // Create Shield instance
        $shield = new Shield($config);
        $shield->isAuthorized();
    }


    /**
     * Get configuration
     *
     * @return array
     */
    public static function getConfig()
    {
        return [
            'enabled' => true,
            'debugger' => true,

            // Action to take
            'action' => [],

            // Allowed hosts
            'hosts' => [
                '127.0.0.1',  // Localhost IPv4
                '::1',        // Localhost IPv6
            ],
        ];
    }
}
