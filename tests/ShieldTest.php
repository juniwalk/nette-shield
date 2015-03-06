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
        // Set localhost remote address for test
        $_SERVER['REMOTE_ADDR'] = '255.255.255.255';
    }


    /**
     * Case - Disabled Shield test.
     */
    public function testDisabled()
    {
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
        // Set some custom IP address for test
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

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
        // Run enabled shield
        $this->getInstance();
    }


    /**
     * Case - Actions test, first pass.
     * @expectedException JuniWalk\Shield\Exception\AbortException
     */
    public function testActionsPass1()
    {
        // It should print '255' string
        $this->expectOutputString('255');

        // Run enabled shield
        $this->getInstance([
            // Actions to take
            'actions' => [
                // Test include action, load DI extension class
                'include' => __DIR__.'/../src/DI/ShieldExtension.php',
                // Test output
                'output' => 255,
                // Custom callback action, just assert enabled Shield
                'callback' => function(Shield $shield) {
                    $this->assertTrue($shield->isEnabled());
                },
            ],
        ]);
    }


    /**
     * Case - Actions test, second pass.
     * @expectedException JuniWalk\Shield\Exception\AbortException
     */
    public function testActionsPass2()
    {
        // Define redirect uri
        $uri = 'http://example.org/';

        // It should print redirect message from the nette/http/response class
        $this->expectOutputString("<h1>Redirect</h1>\n\n<p><a href=\"$uri\">Please click here to continue</a>.</p>");

        // Run enabled shield
        $this->getInstance([
            // Set redirect action with given Uri
            'actions' => [
                // No such action
                'noaction' => null,
                // Test include action, non-existent file
                'include' => '/there/is/no/such/file.xxx',
                // Test redirect action
                'redirect' => $uri,
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
