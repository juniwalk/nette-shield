<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests\Helpers;

/**
 * Extend ShieldAction class and override ShieldAction::headers_sent()
 * to return true, instead of calling headers_sent().
 */
class ShieldAction extends \JuniWalk\Shield\ShieldAction
{
    /**
     * Are headers already sent out?
     *
     * @param  string|null  $file  Path to file
     * @param  int|null     $line  Line number
     * @return bool
     */
    protected static function checkHeaders(&$file = null, &$line = null)
    {
        // Just some values for testing
        $file = __FILE__;
        $line = __LINE__;

        return true;
    }
}
