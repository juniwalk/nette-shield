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

class ShieldPanelTest extends \PHPUnit_Framework_TestCase
{
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
    }
}
