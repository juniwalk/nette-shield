<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests\Bridge;

use JuniWalk\Shield\Bridge\ShieldPanel;
use JuniWalk\Shield\Shield;
use Nette\Http\Response;

class ShieldPanelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Add remote address to the enviroment.
     */
    protected function setUp()
    {
        // Set localhost remote address for test
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }


    /**
     * Case - Basic panel test.
     */
    public function testBasic()
    {
        // Get the panel instance
        $panel = new ShieldPanel;

        // Assert returned values from the methods
        $this->assertSame('', $panel->getTab());    // There is no Shield instance
        $this->assertSame('', $panel->getPanel());  // Always empty
        $this->assertInternalType(
            'string',
            $panel->getShieldIcon()
        );

        // Create instance of the Shield class - disabled
        new Shield([], $panel, new Response);

        // Just check first few characters
        $this->assertStringStartsWith(
            '<span title="Shield',
            $panel->getTab()
        );

        // Create instance of the Shield class - enabled
        new Shield(['enabled' => true], $panel, new Response);

        // Just check first few characters
        $this->assertStringStartsWith(
            '<span title="Shield',
            $panel->getTab()
        );
    }
}
