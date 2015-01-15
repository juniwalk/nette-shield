<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield;

use JuniWalk\Shield\Bridges\TracyPanel;

class Shield
{
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

        // If the debbuger is enabled
        if ($this->config['debugger']) {
            // Register Shield into Tracy
            new ShieldPanel($this);
        }
    }


    /**
     * Is the Shield enabled?
     *
     * @return  bool
     */
    public function isEnabled()
    {
        // Return state of the Shield
        return (bool) $this->config['enabled'];
    }


    /**
     * Is the visitor authorized?
     *
     * @return  bool
     */
    public function isAuthorized()
    {
        // Gather needed properties for check
        $hosts = $this->config['hosts'];
        $host = $_SERVER['REMOTE_ADDR'];

        // If the Shield is disabled
        if (!$this->config['enabled']) {
            return true;
        }

        // If the visitor is unauthorized
        if (in_array($host, $hosts)) {
            return true;
        }

        // Unauthorized visitor
        return $this->takeAction();
    }


    /**
     * Take action against unauthorized visitor
     *
     * @return bool
     */
    protected function takeAction()
    {
        // Get action path value
        $value = $this->getAction('data');

        // Which action should be taken?
        switch ($this->getAction('task')) {
            // Shield action - File inclusion
            case static::TASK_INCLUDE:

                include $value;
                break;

            // Shield action - Text output
            case static::TASK_PRINT:

                print $value;
                break;

            // Shield action - Callback invoke
            case static::TASK_CALLBACK:

                call_user_func($value, $this);
                break;

            // Shield action - Redirect to url
            case static::TASK_REDIRECT:

                header('Location: '.$value, true, 503);
                break;
        }

        // Either way terminate script
        return (bool) static::terminate( );
    }


    /**
     * Get action type
     *
     * @param  string  $type  Needed type
     * @return string|null
     */
    protected function getAction($type)
    {
        // If there is no value for this value type
        if (!isset($this->config['action'][$type])) {
            return null;
        }

        // Return value of selected value type
        return $this->config['action'][$type];
    }


    /**
     * Terminate code flow
     */
    protected static function terminate()
    {
        // Send headers about undergoing maintenance mode
        header('HTTP/1.1 503 Service Unavailable');
        header('Retry-After: 300');

        // Terminate
        exit(0);
    }
}
