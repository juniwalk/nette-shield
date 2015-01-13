<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

/**
 * Extend Shield class and override Shield::terminate()
 * to return null, instead of calling exit.
 */
class Shield extends \JuniWalk\Shield\Shield
{
    /**
     * Terminate code flow
     */
    protected static function terminate()
    {
        return null;
    }
}
