<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield;

use JuniWalk\Common\Container;
use JuniWalk\Common\Exceptions\AbortException;
use JuniWalk\Common\Exceptions\ErrorException;
use JuniWalk\Shield\Bridges\ShieldPanel;

class Shield
{
    /**
     * Config container
     *
     * @var Container
     */
    protected $config = [
        'enabled' => false,
        'debugger' => true,

        // Action to take
        'action' => [],

        // Allowed hosts
        'hosts' => [
            '127.0.0.1',  // Localhost IPv4
            '::1',        // Localhost IPv6
        ],
    ];


    /**
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        // Build configuration package by merging it
        $this->config = new Container($this->config);
        $config = $this->config->addValues($config);

        // If the Tracy panel is enabled
        if ($config['debugger']) {
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
     * @return bool|null
     * @throws ErrorException|AbortException
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
        $this->takeAction();
    }


    /**
     * Take action against unauthorized visitor
     *
     * @throws ErrorException|AbortException
     */
    protected function takeAction()
    {
        // Get the list of defined actions
        $actions = $this->config['action'];
        $action = new ShieldAction();

        // If there is no list of actions
        if (!is_array($actions)) {
            throw new ErrorException('Action is expected as an array of tasks.', $this);
        }

        // Iterate over the set of actions to do
        foreach ($actions as $task => $data) {
            // If there is no such method
            if (!method_exists($action, $task)) {
                continue;
            }

            // Invoke the task with given data
            $action->{$task}($data);
        }

        // Terminate the flow of the script
        throw new AbortException();
    }
}
