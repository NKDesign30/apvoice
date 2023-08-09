<?php
/*
Plugin Name: AWSM Libraries
Plugin URI: https://www.awsm.rocks
Description: A couple of helpful classes and methods
Version: 1.0.0
Author: Mark Sitko
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: awsm_lib
 */

namespace awsm\wp\libraries;
use awsm\wp\loader\ClassLoader;

if( !class_exists( 'awsm\wp\loader\ClassLoader' ) || !file_exists( dirname(__FILE__) . '/autoloader.php' ) ) return;

class Libraries
{
	private static $instance;

	private function __construct() 
	{
        ClassLoader::instance()->add( 'awsm\wp\libraries', __DIR__ . '/libraries');
	}

	/**
	* @return self
	*/
	public static function init() 
	{
		if( !self::$instance  && !self::$instance instanceof Libraries) {
			self::$instance = new static();
		}
		return self::$instance;
	}

}

Libraries::init();
