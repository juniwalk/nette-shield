<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

use JuniWalk\Shield\Bridges\ShieldPanel;
use JuniWalk\Shield\Shield;

class ShieldPanelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test ShieldPanel - basics
     */
    public function testBasics()
    {
        // Create simple instance of the Shield
        $config = ['enabled' => true];
        $shield = new Shield($config);

        // Create instance of the ShieldPanel
        $panel = new ShieldPanel($shield);

        // Make sure that ShieldPanel implements IBarPanel
        $this->assertInstanceOf('\Tracy\IBarPanel', $panel);

        // Check that the Shield icon is returned
        $this->assertInternalType(
            'string',
            $panel->getShieldIcon()
        );
    }


    /**
     * Test ShieldPanel - tracy tab
     */
    public function testTab()
    {
        // Create simple instance of the Shield
        $config = ['enabled' => true];
        $shield = new Shield($config);

        // Create instance of the ShieldPanel
        $panel = new ShieldPanel($shield);

        // Just check first few characters
        $this->assertStringStartsWith(
            '<span title="Shield',
            $panel->getTab()
        );
    }


    /**
     * Test ShieldPanel - tracy panel
     */
    public function testPanel()
    {
        // Create simple instance of the Shield
        $config = ['enabled' => false];
        $shield = new Shield($config);

        // Create instance of the ShieldPanel
        $panel = new ShieldPanel($shield);

        // Just check first few characters
        $this->assertStringStartsWith(
            '<span title="Shield',
            $panel->getTab()
        );

        // Make sure that there is no panel code
        $this->assertSame('', $panel->getPanel());
    }
}
