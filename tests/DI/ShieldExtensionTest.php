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

class ShieldPanelTest extends \PHPUnit_Framework_TestCase
{
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
		$config->setTempDirectory(__DIR__.'/../../tmp');
		$config->addConfig(__DIR__.'/../../res/config.neon');

        // Create DI container
		return $config->createContainer();
    }
}
