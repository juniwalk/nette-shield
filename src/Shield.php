<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield;

use JuniWalk\Common\Container as Config;
use JuniWalk\Common\Exceptions\AbortException;
use JuniWalk\Common\Exceptions\ErrorException;
use JuniWalk\Shield\Bridges\ShieldPanel;
use Nette\DI\Container;

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
    public function __construct(array $config, Container $di)
    {
        \tracy\debugger::dump($di);exit;
    }
}
