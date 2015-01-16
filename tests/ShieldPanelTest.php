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
     * Test ShieldPanel
     */
    public function testAllInOne()
    {
        // Create simple instance of the Shield
        $config = ['enabled' => true];
        $shield = new Shield($config);

        // Create instance of the ShieldPanel
        $panel = new ShieldPanel($shield);

        // Make sure that ShieldPanel implements IBarPanel
        $this->assertInstanceOf('\Tracy\IBarPanel', $panel);

        // Just check first few characters
        $this->assertStringStartsWith(
            '<span title="Shield',
            $panel->getTab()
        );

        // Make sure that there is no panel code
        $this->assertSame('', $panel->getPanel());

        // Check that the Shield icon is returned
        $this->$this->assertInternalType(
            'string',
            $panel->getShieldIcon()
        );
    }
}
