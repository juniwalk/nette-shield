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
     * Create symlinks for needed files.
     */
    protected function setUp()
    {
        // Prepare server properties in enviroment
        $_SERVER['REMOTE_ADDR'] = '255.255.255.255';
    }


    /**
     * Case - Basic Shield test.
     */
    public function testBasic()
    {
        $shield = $this->getInstance();
    }


    /**
     * Get configuration.
     * @return Shield
     */
    protected function getInstance()
    {
        $config = [
            'enabled' => true,
            'debugger' => true,
            'autorun' => false,

            // Actions to take
            'actions' => [],

            // Allowed hosts
            'hosts' => [
                '127.0.0.1',  // Localhost IPv4
                '::1',        // Localhost IPv6
            ],
        ];


        return new Shield($config, new ShieldPanel, new Response);
    }
}
