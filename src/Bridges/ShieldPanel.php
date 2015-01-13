<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Bridges;

class ShieldPanel implements \Tracy\IBarPanel
{
    /**
     * Tracy Bar icon
     *
     * @var string
     */
    const ICON = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAmJJREFUeNp8U1tLVFEYXec2Nx0vaWZopWkjPSSUYuEglA++VOR7kdBLL/4C/4RQEYSTJb2FMVb2LHSjEmKyCVKkBh3NM87FyXEuZ+ac3be3HTFn6IPF/vbe61t77c23JcYYeEiSBDs2p/xtzDKXCYrYk2VTktXOwyPvIjbHrlNRISyzFK6/MKRoHWdp5kbxR1hJvX/6jSZVB7l7ArHH/TPMNK/BsuA5cQr5bAT5L2EY20nUdQ3B097j0SeKDLIKSdWeU8mwcGdbSc9eZbWDl8ibU+jmIh/gbvVBfzsDT1MLvJ03AG8bbVUjNnkdTbfmpX8cGMkUeWfQ56bE3NXYSuY5R4aRTiEZus8PR13/XTrEKr8CK5X4Swo0dvtpoK18ForDSXBD1jR6TOxyKr3BjmEtslS6S3VVo5TN0MEaVLNIgwsyiciKSu6bYcV/EheLdp1sJ9GEMV3Y1OE+2k4C2zDzOygRFFHsEA7UmpMwNr4TtzhdJjD+ci1QiK7B09IFQwhkSICuIBxoAuqhc8gtv8b47K9AmUDwY3wlGd1YMrcycNQ0i9PNXAaykwQ0B7Ta0zAT69jSV5Y4t0yA909wPjWWCYdQdawbppFHkQQUpxOF3ykoDT3YDr1AcH5rjHPtIulAK3uW7vXOHfcP9CkN9UgsvIKzpg7ejmEU40msvnn2yTf6mZoFWbtO9PTeZDd8+sM+Zq3fYZmF24RRZq5OMD3Qy0m+/X9B1FUQwM2LRy7HngwwS39AeMR4ztf2c/4rQOEYGWy+Eps8zzh4ztcqCUiVvrMtQjjzN//Ku/2gAI8/AgwAzY0uaVJ2oxEAAAAASUVORK5CYII=";

    /**
     *
     * Is shield enabled?
     *
     * @var bool
     */
    public $enabled;


    /**
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        // Walk through each config property
        foreach ($config as $key => $value) {
            // If there is no such property
            if (!property_exists($this, $key)) {
                continue;
            }

            // Assign value to instance
            $this->$key = $value;
        }

        // If the debbuger is enabled
        if ($this->debugger == true) {
            // Register debugger panel into the Tracy bar
            Debugger::getBar()->addPanel($this, 'shield');
        }
    }


    /**
     * Renders HTML code for custom tab.
     *
     * @return	string
     */
    public function getTab()
    {
        return '<span title="Shield '.( $this->enabled ? "enabled" : "disabled" ).'">
<img src="'.static::ICON.'" alt="shield" '.( $this->enabled ? '' : 'style="opacity: .5;"' ).' />'.
    ( $this->enabled ? 'On' : 'Off' ).
'</span>';
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
}
