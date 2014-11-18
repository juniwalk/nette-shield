<?php /**


	* @author:		Martin Procházka
	* @contact:		juniwalk@outlook.cz
	* @created:		2014-11-18 13:30
	* @file:		Extension.php
	* @copyright:	Martin Procházka (c) 2014


	*///////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////	Extension


	namespace JuniWalk\Security\Shield;


	use \JuniWalk\Security\Shield;


	class Extension extends \Nette\DI\CompilerExtension
	{
		/**
		 *
		 * DI Tag name
		 *
		 * @var string
		**/
		const TAG = "shield";

		/**
		 *
		 * Default values
		 *
		 * @var array
		**/
		public $defaults = array
		(
			'debugger'	=> false,
			'enabled'	=> false,
			'hosts'		=> [ '127.0.0.1' ],
		);


		/**
		 *
		 * Get configuration values
		 *
		 * @param	void
		 * @return	void
		 * @see		loadConfiguration
		**/
		public function loadConfiguration ( )
		{
			// Get the configuration values extending defaults
			$config = $this->getConfig( $this->defaults );

			// Create new Shield service in the DI Container
			$this->getContainerBuilder( )->addDefinition( static::TAG )
				->setClass( Shield::class, [ $config ] );
		}
	}


	////////////////////////////////	END OF CODE
	////////////////////////////////////////////////////////////////////////////////////

