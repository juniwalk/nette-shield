<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield;

class ShieldAction
{
    /**
     * Shield action - Load file
     *
     * @var string
     */
    const LOAD = 'getFile';

    /**
     * Shield action - Redirect to url
     *
     * @var string
     */
    const REDIRECT = 'setRedirect';

    /**
     * Shield action - Output text
     *
     * @var string
     */
    const OUTPUT = 'setOutput';

    /**
     * Shield action - invoke callback
     *
     * @var string
     */
    const CALLBACK = 'invokeCallback';
}
