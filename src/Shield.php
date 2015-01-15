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
            $this->setDebugPanel();
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
        // Get the list of defined actions
        $actions = $this->config['action'];
        $action = new ShieldAction();

        // If there is no list of actions
        if (!is_array($actions)) {
            throw new \ErrorException('Shield: Action is expected as an array of tasks.');
        }

        // Iterate over the set of actions to do
        foreach ($actions as $task => $data) {
            // If there is no such method
            if (!method_exists($action, $task)) {
                continue;
            }

            // Invoke the task with givnen data
            $action->{$task}($this, $data);
        }

        // Terminate the flow of the script
        return (bool) static::terminate( );
    }


    /**
     * Register Shield into debug panels
     * 
     * @return array
     */
    protected function setDebugPanel()
    {
        // List of registered panels
        $panel = array( );

        // If there is Tracy loaded
        if (class_exists('Tracy\Debugger')) {
            // Register Shield into Tracy
            $panel['tracy'] = new TracyPanel($this);
        }

        // Rerturn list of panels
        return $panel;
    }


    /**
     * Terminate code flow
     */
    protected static function terminate()
    {
        exit(0); // Terminate
    }
}
