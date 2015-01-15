<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests;

use JuniWalk\Shield\ShieldAction;

class ShieldActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Shield instance
     *
     * @var Shield
     */
    public $shield;


    /**
     * Prepare enviroment for the tests
     */
    protected function setUp()
    {
        // Create Shield instance
        $this->shield = new Shield(ShieldTest::getConfig());
    }


    /**
     * ShieldAction - getFile test
     */
    public function testLoad()
    {
        // Prepare path to test file
        $file = __DIR__.'/ShieldTest.php';

        // Create ShieldAction instance
        $action = new ShieldAction();

        // Test ShieldAction::getFile method
        $this->assertStringEqualsFile(
            $this->file,
            $action->getFile($this->shield, $file)
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
        $action->setRedirect($this->shield, $url);

        // Assert that the header was set
        $this->assertContains(
            'Location: '.$url,
            headers_list()
        );

        // Remove the location header
        header_remove('Location');
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
        $action->setOutput($this->shield, $output);
    }


    /**
     * ShieldAction - invokeCallback test
     */
    public function testCallback()
    {
        // Create ShieldAction instance
        $action = new ShieldAction();
        $callback = function (Shield $shield) {
            return $shield->isEnabled();
        };

        // Invoke the callback method using action callback invoker
        $response = $action->invokeCallback($this->shield, $callback);

        // Assert that the callback was successfull
        $this->assertTrue($response);
    }
}
