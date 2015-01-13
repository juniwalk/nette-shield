<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

use \JuniWalk\Shield\Shield;

class ShieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Basic Shield test
     */
    public function testBasic()
    {
        // Create instance with provided configuration
        $shield = new Shield(static::getConfig());

        // Assert this basic test case
        $this->assertTrue($shield->isEnabled());
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
            'action' => [
                // No action will be taken
                'type' => Shield::TASK_NONE,
                'path' => null,
            ],

            // Allowed hosts
            'hosts' => [
                '127.0.0.1',  // Localhost IPv4
                '::1',        // Localhost IPv6
            ],
        ];
    }
}
