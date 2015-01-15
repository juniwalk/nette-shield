<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

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
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

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
     * Test authorized visitor
     */
    public function testAuthorized()
    {
        // Check that the visitor is authorized to continue
        $this->assertTrue($this->shield->isAuthorized());
    }


    /**
     * Test unauthorized visitor
     */
    public function testUnAuthorized()
    {
        // Override enviroment variable just for this test
        $_SERVER['REMOTE_ADDR'] = '255.255.255.255';

        // Check that the visitor is no longer authorized
        $this->assertFalse($this->shield->isAuthorized());
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
