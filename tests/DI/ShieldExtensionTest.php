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
     * Configuration file.
     * @vqr string
     */
    const CONFIG = __DIR__.'/../Helpers/config.neon';


    /**
     * Case - Basic extension test.
     */
    public function testBasic()
    {
        $this->createContainer();
    }


    /**
     * Create new DI container.
     */
    protected function createContainer()
    {
        // Create bootstrap configurator
		$config = new Configurator;
		$config->setTempDirectory(sys_get_temp_dir());
		$config->addConfig(static::CONFIG);

        // Create DI container
		return $config->createContainer();
    }
}
