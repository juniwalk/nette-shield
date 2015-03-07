<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Bridge;

use JuniWalk\Shield\Shield;
use Tracy\Debugger;

class ShieldPanel extends \Nette\Object implements \Tracy\IBarPanel
{
    /**
     * Shield instance.
     * @var Shield
     */
    protected $shield;


    /**
     * Register this panel into Tracy.
     */
    public function __construct()
    {
        // Register debugger panel into the Tracy bar
        Debugger::getBar()->addPanel($this, 'shield.shield');
    }


    /**
     * Set new instance of Shield.
     * @param Shield  $shield  Shield instance
     */
    public function setShield(Shield $shield)
    {
        $this->shield = $shield;
    }


    /**
     * Renders HTML code for custom tab.
     * @return string
     */
    public function getTab()
    {
        // If there is no Shield instance
        if (empty($this->shield)) {
            return '';
        }

        // Get the current status of the Shield
        $enabled = $this->shield->isEnabled();
        return sprintf(
            '<span title="Shield %1$s"><span %3$s>%2$s</span> %1$s</span>',
            $enabled ? 'On' : 'Off',
            $this->getShieldIcon(),
            $enabled ? '' : 'style="opacity: .5;"'
        );
    }


    /**
     * Renders HTML code for custom panel.
     * @return string
     */
    public function getPanel()
    {
        return '';
    }


    /**
     * Get Shield icon as PNG or SVG.
     * @return string
     */
    public function getShieldIcon()
    {
        // Standard PNG icon
        $icon = 'shield.png';

        // If tracy is in version range of ~2.3
        if (defined('\Tracy\Debugger::VERSION')) {
            // Use new SVG icon
            $icon = 'shield.svg';
        }

        // Return contents of the Shield icon, PNG or SVG
        return file_get_contents(__DIR__.'/../../res/'.$icon);
    }
}
