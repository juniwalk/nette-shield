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
     * @param  Shield  $shield  Instance of Shield
     * @param  string  $file    Path to file
     * @return mixed
     * @throws ErrorException
     */
    public function getFile(Shield $shield, $file)
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
     * @param  Shield  $shield  Instance of Shield
     * @param  string  $url     Destination url
     * @return bool|null
     * @throws ErrorException
     */
    public function setRedirect(Shield $shield, $url)
    {
        // If the headers were already sent
        if (headers_sent($file, $line)) {
            throw new \ErrorException('Shield: Unable to redirect, headers already sent in '.$file.':'.$line.'.');
        }

        // If the URL is seriously malformed
        if (parse_url($url) === false) {
            throw new \ErrorException('Shield: Invalid url for redirect given.');
        }

        // Send Location header with the given url
        return header('Location: '.$url, true, 503);
    }


    /**
     * Redirect to given url
     * 
     * @param  Shield  $shield  Instance of Shield
     * @param  string  $data    Data/File to be outputed
     * @throws ErrorException
     */
    public function setOutput(Shield $shield, $data)
    {
        // If given path is a file and it is readable
        if (is_file($data) && is_readable($data)) {
            // Load its data into the holder
            $data = file_get_contents($data);
        }

        // If the data is object and there is to string converter method
        if (is_object($data) && method_exists($data, '__toString')) {
            // Convert object into string
            $data = $data->__toString();
        }

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
     * @param  Shield    $shield    Instance of Shield
     * @param  callable  $callback  Callback function
     * @throws ErrorException
     */
    public function invokeCallback(Shield $shield, $callback)
    {
        // If the method is not callable
        if (!is_callable($callback)) {
            throw new \ErrorException('Shield: Given callback cannot be called.');
        }

        // Invoke the callback function with Shield as param
        return call_user_func($callback, $shield);
    }
}
