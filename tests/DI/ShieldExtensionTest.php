<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   Shield
 * @link      https://github.com/juniwalk/shield
 * @copyright Martin Procházka (c) 2015
 * @license   MIT License
 */

namespace JuniWalk\Shield\Tests\DI;

use JuniWalk\Shield\DI\ShieldExtension;
use Nette\Configurator;

class ShieldExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Case - Extension test.
     */
    public function testExtension()
    {
        // Get the Shield service from container
        $shield = $this->createContainer()
            ->getService('juniwalk.shield');

        // Check that the Shield is really Shield
        // and that it is enabled from configuration
        $this->assertTrue($shield->isEnabled());
        $this->assertInstanceOf(
            '\JuniWalk\Shield\Shield',
            $shield
        );
    }


    /**
     * Create new DI container.
     */
    protected function createContainer()
    {
        // Create bootstrap configurator
		$config = new Configurator;
		$config->setTempDirectory(sys_get_temp_dir());
		$config->addConfig(__DIR__.'/../Helpers/config.neon');

        // Create DI container
		return $config->createContainer();
    }
}
