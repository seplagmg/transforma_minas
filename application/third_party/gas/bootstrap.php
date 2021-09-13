<?php defined('BASEPATH') or die('No direct access allowed');

/**
 *---------------------------------------------------------------
 * Load the DB packages and environment preparation
 *---------------------------------------------------------------
 */
 
// Set error level
if (ENVIRONMENT === 'testing') error_reporting(E_STRICT);

// Check the environment var
if ( ! defined('DB_GROUP'))
{
	define('DB_GROUP', 'default');
}
else
{
	unset($DB);
}

// Define this root folder as Gas ORM base path
defined('GASPATH') or define('GASPATH', __DIR__.DIRECTORY_SEPARATOR);

// Load everything on base gas directory
require_once GASPATH.'classes'.DIRECTORY_SEPARATOR.'core.php';
require_once GASPATH.'classes'.DIRECTORY_SEPARATOR.'data.php';
require_once GASPATH.'classes'.DIRECTORY_SEPARATOR.'janitor.php';
require_once GASPATH.'classes'.DIRECTORY_SEPARATOR.'orm.php';
require_once GASPATH.'interfaces'.DIRECTORY_SEPARATOR.'extension.php';

// Load needed DB files
require_once Gas\Janitor::path('base').'database'.DIRECTORY_SEPARATOR.'DB.php';
require_once Gas\Janitor::path('base').'database'.DIRECTORY_SEPARATOR.'DB_forge.php';
require_once Gas\Janitor::path('base').'database'.DIRECTORY_SEPARATOR.'DB_utility.php';

// Define DB path
define('DBPATH', Gas\Janitor::path('base').'database'.DIRECTORY_SEPARATOR);
define('DBDRIVERSPATH', DBPATH.'drivers'.DIRECTORY_SEPARATOR);

// Mock internal CI instance and low-level functions,
// in case we run Gas ORM outside CI scope
if ( ! function_exists('get_instance'))
{
	// Build our own TRON!
	class Tron {
		/**
		 * @var object Tron super-object
		 */
		private static $instance;

		/**
		 * Constructor
		 *
		 * @param   mixed   CI DB instance
		 * @return  void   
		 */
		function __construct($DB)
		{
			$this->db         = $DB;
			static::$instance = $this;
		}

		/**
		 * Get Tron super-object
		 *
		 * @return  object   
		 */
		public static function &get_instance()
		{
			return static::$instance;
		}

		/**
		 * Serve static call for TRON instantiation
		 *
		 * @return  object   
		 */
		public static function make()
		{
			return new static(NULL);
		}

		/**
		 * Serve loader
		 *
		 * @param   mixed
		 * @return  object   
		 */
		public static function load($args)
		{
			// TODO : resolve this loader to perform any necessarily
			// action, to load the real requested class.
			return static::$instance;
		}

		/**
		 * Serve undefined Core CI properties
		 */
		public function __get($name)
		{
			if ($name == 'load')
			{
				return static::$instance;
			}
		}

		/**
		 * Serve other methods, to capture the error for the very least
		 *
		 * @param   string
		 * @param   mixed
		 * @throws  LogicException Serve show error method
		 * @return  mixed
		 */
		public function __call($name, $arguments)
		{
			// Only response for error
			if ($name == 'show_error')
			{
				// Get any meaning information
				$internal_error = (array_key_exists(2, $arguments)) ? $arguments[2] : 'Undefined CI Error';

				// Good bye
				throw new LogicException('CI Internal Error with message : '.$internal_error);
			}
			// For package path
			elseif ($name == 'get_package_paths')
			{
				return array();
			}
		}
	}

	/**
	 * global is_php method
	 */
	function is_php($version = '5.0.0')
	{
		static $_is_php;
		$version = (string)$version;

		if ( ! isset($_is_php[$version]))
		{
			$_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
		}

		return $_is_php[$version];
	}

	/**
	 * global get_instance method
	 */
	function &get_instance() {

		$instance =& Tron::get_instance();

		// If Tron not initialized yet, build a mock
		if (is_null($instance))
		{
			$instance = new stdClass();
			$instance->load = new Tron('undefined');
		}

		return $instance;
	}

	/**
	 * global log_message method
	 */
	function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
	{
		// Good bye
		throw new LogicException('CI Internal Error with message : '.$message);
	}

	/**
	 * global log_message method
	 */
	function log_message(){}

	/**
	 * global load_class method
	 */
	function load_class(){
		// Capture argument
		$args = func_get_args();

		// Return new TRON to resolve any possible error
		return Tron::make()->load($args);
	}
}

// Validate DB instance
if ( ! class_exists('CI_DB'))
{
	try{
		$DB = &DB(DB_GROUP);
	} catch (Exception $e) {
		die('Cant connect to database : '.$e->getMessage().', please check config/testing/database.php.'."\n");
	}
}

if ( ! $DB instanceof CI_DB_Driver)
{
	throw new InvalidArgumentException('db_connection_error:default');
}

// Load required utility files once
require_once(DBPATH.'DB_forge.php');
require_once(DBPATH.'DB_utility.php');
require_once(DBDRIVERSPATH.$DB->dbdriver.DIRECTORY_SEPARATOR.$DB->dbdriver.'_utility.php');
require_once(DBDRIVERSPATH.$DB->dbdriver.DIRECTORY_SEPARATOR.$DB->dbdriver.'_forge.php');

// if we run Gas ORM outside CI scope
if ( class_exists('Tron'))
{
	// MayDay!! Call TRON
	$tron = new Tron($DB);
}

/**
 *---------------------------------------------------------------
 * Instantiate Gas ORM Core classes
 *---------------------------------------------------------------
 */

// Instantiate core class then clean up global variables
Gas\Core::make($DB, $config)->init();
unset($DB, $config);