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
    const TMPDIR = __DIR__.'/../../tmp';


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
        // If there is no temp directory
        if (!is_dir(static::TMPDIR)) {
            // Try tp create one recursively
            mkdir(static::TMPDIR, 0755, true);
        }

        // Create bootstrap configurator
		$config = new Configurator;
		$config->setTempDirectory(static::TMPDIR);
		$config->addConfig(__DIR__.'/../../res/config.neon');

        // Create DI container
		return $config->createContainer();
    }
}
