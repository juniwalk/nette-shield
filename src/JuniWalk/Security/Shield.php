<?php /**


	* @author:		Martin Procházka
	* @contact:		juniwalk@outlook.cz
	* @created:		2014-11-18 13:30
	* @file:		Shield.php
	* @copyright:	Martin Procházka (c) 2014


	*///////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////	Shield


	namespace JuniWalk\Security;


	use \Tracy\Debugger;


	class Shield extends \Nette\Object implements \Tracy\IBarPanel
	{
		/**
		 *
		 * Tracy Bar icon
		 *
		 * @var string
		**/
		const ICON = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAmJJREFUeNp8U1tLVFEYXec2Nx0vaWZopWkjPSSUYuEglA++VOR7kdBLL/4C/4RQEYSTJb2FMVb2LHSjEmKyCVKkBh3NM87FyXEuZ+ac3be3HTFn6IPF/vbe61t77c23JcYYeEiSBDs2p/xtzDKXCYrYk2VTktXOwyPvIjbHrlNRISyzFK6/MKRoHWdp5kbxR1hJvX/6jSZVB7l7ArHH/TPMNK/BsuA5cQr5bAT5L2EY20nUdQ3B097j0SeKDLIKSdWeU8mwcGdbSc9eZbWDl8ibU+jmIh/gbvVBfzsDT1MLvJ03AG8bbVUjNnkdTbfmpX8cGMkUeWfQ56bE3NXYSuY5R4aRTiEZus8PR13/XTrEKr8CK5X4Swo0dvtpoK18ForDSXBD1jR6TOxyKr3BjmEtslS6S3VVo5TN0MEaVLNIgwsyiciKSu6bYcV/EheLdp1sJ9GEMV3Y1OE+2k4C2zDzOygRFFHsEA7UmpMwNr4TtzhdJjD+ci1QiK7B09IFQwhkSICuIBxoAuqhc8gtv8b47K9AmUDwY3wlGd1YMrcycNQ0i9PNXAaykwQ0B7Ta0zAT69jSV5Y4t0yA909wPjWWCYdQdawbppFHkQQUpxOF3ykoDT3YDr1AcH5rjHPtIulAK3uW7vXOHfcP9CkN9UgsvIKzpg7ejmEU40msvnn2yTf6mZoFWbtO9PTeZDd8+sM+Zq3fYZmF24RRZq5OMD3Qy0m+/X9B1FUQwM2LRy7HngwwS39AeMR4ztf2c/4rQOEYGWy+Eps8zzh4ztcqCUiVvrMtQjjzN//Ku/2gAI8/AgwAzY0uaVJ2oxEAAAAASUVORK5CYII=";


		/**
		 *
		 * Is shield enabled?
		 *
		 * @var bool
		**/
		public $enabled;

		/**
		 *
		 * Debugger integration
		 *
		 * @var bool
		**/
		public $debugger;

		/**
		 *
		 * List of allowed hosts
		 *
		 * @var array
		**/
		public $hosts;


		/**
		 *
		 * <<magic>> Constructor
		 *
		 * @param	array	$config
		 * @return	void
		 * @see		__construct
		**/
		public function __construct ( array $config )
		{
			// Walk through each config property
			foreach ( $config as $key => $value )
			{
				// If there is no such property
				if ( !property_exists( $this, $key ) )
				{
					continue;
				}


				// Assign value to instance
				$this->$key = $value;
			}

			// If the debbuger is enabled
			if ( $this->debugger == true )
			{
				// Register debugger panel into the Tracy bar
				Debugger::getBar( )->addPanel( $this, 'shield' );
			}
		}


		/**
		 *
		 * Authorize access to the page
		 *
		 * @param	void
		 * @return	bool
		 * @see		isAuthorized
		**/
		public function isAuthorized ( )
		{
			// Set production mode as a default one
			Debugger::enable( Debugger::PRODUCTION );

			// If the Shield is disabled
			if ( !$this->enabled )
			{
				return true;
			}

			// If this IP Address is not allowed in the list
			if ( !Debugger::detectDebugMode( $this->hosts ) )
			{
				return false;
			}


			// Assign settings to the Tracy Debugger class
			Debugger::enable( Debugger::DEVELOPMENT );
			Debugger::$strictMode = true;
			Debugger::$maxDepth = 5;
			Debugger::$maxLen = 500;

			return true;
		}


#region IBarPanel


		/**
		 *
		 * Renders HTML code for custom tab.
		 *
		 * @param	void
		 * @return	string
		 * @see		getTab
		**/
		public function getTab ( )
		{
			return "
			<span title=\"Shield ". ( $this->enabled ? "enabled" : "disabled" ) ."\">
				<img src=\"". static::ICON ."\" alt=\"shield\" ". ( $this->enabled ?'': "style=\"opacity: .5;\"" ) ." />". ( $this->enabled ? "On" : "Off" ) ."
			</span>";
		}


		/**
		 *
		 * Renders HTML code for custom panel.
		 *
		 * @param	void
		 * @return	string
		 * @see		getPanel
		**/
		public function getPanel ( )
		{
			return null;
		}


#endregion

	}


	////////////////////////////////	END OF CODE
	////////////////////////////////////////////////////////////////////////////////////

