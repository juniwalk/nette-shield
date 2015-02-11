<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Bridges;

use JuniWalk\Shield\Shield;
use Tracy\Debugger;

class ShieldPanel implements \Tracy\IBarPanel
{
    /**
     * Is shield enabled?
     *
     * @var Shield
     */
    public $shield;


    /**
     * @param  array  $config
     */
    public function __construct(Shield &$shield)
    {
        // Assign Shield instance
        $this->shield = $shield;

        // Register debugger panel into the Tracy bar
        Debugger::getBar()->addPanel($this, 'shield');
    }


    /**
     * Renders HTML code for custom tab.
     *
     * @return	string
     */
    public function getTab()
    {
        // Get the current status of the Shield
        $enabled = $this->shield->isEnabled();

        return sprintf(
            '<span title="Shield %1$s" %3$s>%2$s %1$s</span>',
            $enabled ? 'On' : 'Off',
            $this->getShieldIcon(),
            $enabled ?: 'style="opacity: .5;"'
        );
    }


    /**
     * Renders HTML code for custom panel.
     *
     * @return	string
     */
    public function getPanel()
    {
        return '';
    }


    /**
     * Get Shield icon as SVG
     *
     * @return	string
     */
    public function getShieldIcon()
    {
        // Return SVG of the Shield icon
        return file_get_contents(__DIR__.'/../../../resx/shield.svg');
    }
}
