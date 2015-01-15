<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

use JuniWalk\Shield\Tests\Helpers\Shield;
use JuniWalk\Shield\ShieldAction;

class ShieldActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ShieldAction - getFile test
     */
    public function testLoad()
    {
        // Prepare path to test file
        $file = __DIR__.'/Helpers/Test.php';

        // Create ShieldAction instance
        $action = new ShieldAction();
        $action->getFile($file);

        // Test ShieldAction::getFile method
        $this->assertContains(
            $file,
            get_included_files( )
        );
    }


    /**
     * ShieldAction - setRedirect test
     */
    public function testRedirect()
    {
        // Test url for redirecting
        $url = 'https://www.example.org';

        // Create ShieldAction instance and
        // call the redirect method with url
        $action = new ShieldAction();
        $result = $action->setRedirect($url);

        // Assert that the header was set
        $this->assertNull($result);
    }


    /**
     * ShieldAction - setoutput test
     */
    public function testOutput()
    {
        // Create ShieldAction instance
        $action = new ShieldAction();
        $output = 'Test output string';

        // Assign expected output string
        $this->expectOutputString($output);

        // Run the function to test the output
        $action->setOutput($output);
    }


    /**
     * ShieldAction - invokeCallback test
     */
    public function testCallback()
    {
        // Create ShieldAction instance
        $action = new ShieldAction();
        $callback = function () {
            return true;
        };

        // Invoke the callback method using action callback invoker
        $response = $action->invokeCallback($callback);

        // Assert that the callback was successfull
        $this->assertTrue($response);
    }
}
