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


    /**
     * Include given file into flow
     *
     * @param  string  $file    Path to file
     * @return mixed
     * @throws ErrorException
     */
    public function getFile($file)
    {
        // If given path is not a file or it is not readable
        if (!is_file($file) || !is_readable($file)) {
            throw new \ErrorException('Shield: Invalid file given to be loaded.');
        }

        // Load given file
        return include $file;
    }


    /**
     * Redirect to given url
     *
     * @param  string  $url     Destination url
     * @return bool|null
     * @throws ErrorException
     */
    public function setRedirect($url)
    {
        // If the headers were already sent
        if (static::checkHeaders($file, $line)) {
            throw new \ErrorException('Shield: Unable to redirect, headers already sent in '.$file.':'.$line.'.');
        }

        // If the URL is seriously malformed
        if (!is_string($url)) {
            throw new \ErrorException('Shield: Invalid url for redirect given.');
        }

        // Send Location header with the given url
        return header('Location: '.$url, true);
    }


    /**
     * Redirect to given url
     *
     * @param  string  $data    Data to be outputed
     * @throws ErrorException
     */
    public function setOutput($data)
    {
        // If the data value is not scalar except null
        if (!is_scalar($data) && !is_null($data)) {
            throw new \ErrorException('Shield: Only scalar values can be outputed.');
        }

        // Print the data
        echo $data;
    }


    /**
     * Call user function using callback
     *
     * @param  callable  $callback  Callback function
     * @throws ErrorException
     */
    public function invokeCallback(callable $callback)
    {
        // Invoke the callback function
        return call_user_func($callback);
    }


    /**
     * Are headers already sent out?
     *
     * @param  string|null  $file  Path to file
     * @param  int|null     $line  Line number
     * @return bool
     */
    protected static function checkHeaders(&$file = null, &$line = null)
    {
        // Simple headers_sent class with params
        return headers_sent($file, $line);
    }
}
