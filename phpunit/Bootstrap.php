<?php
namespace Phalcon\Searcher\Test;

/**
 * Class Bootstrap For original classes
 * @package Phalcon
 * @subpackage Phalcon\Searcher\Test
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 */

class Bootstrap {

	static private $classNames = array();

	/**
	 * Store the filename (sans extension) & full path of all ".php" files found
	 *
	 * @param $dirName
	 * @access static
	 * @return null
	 */
	public static function registerDirectory($dirName)
	{
		$di = new \DirectoryIterator($dirName);
		foreach($di as $file) {

			if($file->isDir() && !$file->isLink() && !$file->isDot()) {
				// recurse into directories other than a few special ones
				self::registerDirectory($file->getPathname());
			} elseif (substr($file->getFilename(), -4) === '.php') {
				// save the class name / path of a .php file found
				$className = substr($file->getFilename(), 0, -4);
				Bootstrap::registerClass($className, $file->getPathname());
			}
		}
	}

	/**
	 * Register classes
	 *
	 * @param $className
	 * @param $fileName
	 * @access static
	 * @return null
	 */
	public static function registerClass($className, $fileName)
	{
		Bootstrap::$classNames[$className] = $fileName;
	}

	/**
	 * Load classes
	 *
	 * @param $className
	 * @access static
	 * @return null
	 */
	public static function loadClass($className)
	{

		if(isset(Bootstrap::$classNames[$className])) {
			print Bootstrap::$classNames[$className]."\n";

			require_once(Bootstrap::$classNames[$className]);
		}
	}
}

spl_autoload_register(array('Phalcon\Searcher\Test\Bootstrap', 'loadClass'));
// Register the directory to your include files

chdir(dirname(__FILE__) . '../src/Searcher');

Bootstrap::registerDirectory(getcwd());