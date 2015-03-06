<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield;

use JuniWalk\Shield\Bridge\ShieldPanel;
use JuniWalk\Shield\Exception\AbortException;
use Nette\Http\Response;

/**
 * @method void onUnauthorized()
 */
class Shield extends \Nette\Object
{
    /**
     * Config container.
     * @var array
     */
    protected $config;

    /**
     * HTTP response instance.
     * @var Response
     */
    protected $response;

    /**
     * Event - Unauthorized access
     * @var array
     */
    public $onUnauthorized;


    /**
     * Initialize Shield instance and perform authorization.
     * @param  array        $config    Configuration
     * @param  ShieldPanel  $panel     Tracy's ShieldPanel
     * @param  Response     $response  Http response
     */
    public function __construct(array $config, ShieldPanel $panel, Response $response)
    {
        // Store provided properties
        $this->config = $config;
        $this->response = $response;

        // If Tracy panel is enabled
        if ($config['debugger']) {
            // Set Shield instance to panel
            $panel->setShield($this);
        }

        // Setup defined actions into events
        $this->setActions($config['actions']);

        // If automatic mode is disabled or user is authorized
        if (!$this->isAutorun() || $this->isAuthorized()) {
            return null;
        }

        // User is unauthorized
        return $this->onUnauthorized();
    }


    /**
     * Is the Shield enabled?
     * @return bool
     */
    public function isEnabled()
    {
        // Return state of the Shield
        return (bool) $this->config['enabled'];
    }


    /**
     * Autorun Shield authorizator?
     * @return bool
     */
    public function isAutorun()
    {
        // Return state of the Shield
        return (bool) $this->config['autorun'];
    }


    /**
     * Is current visitor authorized?
     * @return bool
     */
    public function isAuthorized()
    {
        // If the Shield is disabled
        if (!$this->isEnabled()) {
            return true;
        }

        // Gather needed properties for check
        $hosts = $this->config['hosts'];
        $host = $_SERVER['REMOTE_ADDR'];

        // If the visitor is authorized
        return in_array($host, $hosts);
    }


    /**
     * Set defined actions into event listener.
     * @param array  $actions  List of actions
     */
    protected function setActions(array $actions)
    {
        // Clear all setup actions
        $this->onUnauthorized = [];

        // Iterate over the list of all defined actions
        foreach ($actions as $method => $param) {
            // Get the name of action method
            $method = 'action'.$method;

            // If there is no such method available
            if (!method_exists($this, $method)) {
                continue;
            }

            // Insert callback to the action into unauthorized event listener
            $this->onUnauthorized[] = function() use ($method, $param) {
                return $this->$method($param);
            };
        }

        // Register abort action in the end
        $this->onUnauthorized[] = function() {
            return $this->actionAbort(0);
        };
    }


    /**
     * Action - Allows to redirect to a Url.
     * @param string  $uri  Endpoint URI
     */
    protected function actionRedirect($uri)
    {
        // Redirect to giben Uri address
        $this->response->redirect($uri);
    }


    /**
     * Action - Includes specified file.
     * @param string  $file  Path to file
     */
    protected function actionInclude($file)
    {
        // If there is no such file or it is not readable
        if (!is_file($file) || !is_readable($file)) {
            return null;
        }

        // Include the file
        include $file;
    }


    /**
     * Action - Outputs text to browser.
     * @param string  $message  Text to ouput
     */
    protected function actionOutput($message)
    {
        // If the message is not a string
        if (!is_string($message)) {
            // Try to convert it into string
            $message = (string) $message;
        }

        // Print the message
        print $message;
    }


    /**
     * Action - Invokes provided callback.
     * @param callable  $callback
     */
    protected function actionCallback(callable $callback)
    {
        // Invoke callback
        $callback($this);
    }


    /**
     * Action - Terminate the flow of the script.
     * @param  mixed  $status  Exit status
     * @throws AbortException
     */
    protected function actionAbort($status)
    {
        // Abort code execution flow
        throw isset($_SERVER['TRAVIS'])
            ? new AbortException($status)   // For Travis throw Exception
            : exit($status);                // Exit the flow otherwise
    }
}
