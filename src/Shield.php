<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield;

use JuniWalk\Shield\Bridges\ShieldPanel;
use \Tracy\Debugger;

class Shield
{
    /**
     * Shield action - Include file
     *
     * @var string
     */
    const INCLUDE_FILE = 'include';

    /**
     * Shield action - Url redirect
     *
     * @var string
     */
    const URL_REDIRECT = 'redirect';

    /**
     * Shield action - none
     *
     * @var string
     */
    const NONE = 'none';


    /**
     * Configuration
     *
     * @var array
     */
    protected $config = [];


    /**
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        // Merge the configuration into the instance holder
        $this->config = array_merge($this->config, $config);
/*
        // If the debbuger is enabled
        if ($this->config['debugger']) {
            // Register debugger panel into the Tracy bar
            Debugger::getBar()->addPanel($this, 'shield');
        }
*/
    }


    /**
     * Authorize access to the page
     *
     * @return  bool
     */
    protected function isAuthorized()
    {
        // Gather needed properties for check
        $hosts = $this->config['hosts'];
        $host = getenv('REMOTE_ADDR');

        // If the Shield is disabled
        if (!$this->config['enabled']) {
            return true;
        }

        // If the visitor is unauthorized
        return in_array($host, $hosts);
    }


    /**
     * Take action against unauthorized visitor
     */
    protected function takeAction()
    {
        // Get the action type and additional parameter
        list($type, $path) = $this->config['action'];

        // Send headers about undergoing maintenance mode
        header('HTTP/1.1 503 Service Unavailable');
        header('Retry-After: 300');

        // Which action should be taken?
        switch ($type) {
            // Action - Include file
            case staitc::INCLUDE_FILE:

                include $path;

                break;

            // Action - Url redirect
            case static::URL_REDIRECT:

                header('Location: '.$path, true, 503);

                break;

            // Action - None
            case static::NONE:
            default:
        }

        // Terminate
        exit(0);
    }
}
