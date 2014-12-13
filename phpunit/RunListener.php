<?php
/**
 * Class RunListener
 * @package Phalcon
 * @since PHP >=5.5.12
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 */
class RunListener implements PHPUnit_Framework_TestListener
{
	/**
	 * @const BLACK color
	 */
	const BLACK = 30;

	/**
	 * @const RED color
	 */
	const RED 		= 31;

	/**
	 * @const GREEN color
	 */
	const GREEN 	= 32;

	/**
	 * @const BROWN color
	 */
	const BROWN 	= 33;

	/**
	 * @const BLUE color
	 */
	const BLUE 		= 34;

	/**
	 * @const PURPLE color
	 */
	const PURPLE 	= 35;

	/**
	 * @const CYAN color
	 */
	const CYAN 		= 36;

	/**
	 * @const WHITE color
	 */
	const WHITE 	= 37;


	/**
	 * Write test title
	 *
	 * @return null
	 */
	public function __construct() {
		$this->writeTitle('Phalcon Searcher Test', self::CYAN);
	}

	/**
	 * Error while running test
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param Exception              $e
	 * @param float                  $time
	 * @return null
	 */
	public function addError(PHPUnit_Framework_Test $test, Exception $e, $time) {

		$this->write(
			sprintf("Error while running test '%s'. %s", $test->getName(), $time), self::RED
		);
	}

	/**
	 * Notify while test was failed
	 *
	 * @param PHPUnit_Framework_Test                 $test
	 * @param PHPUnit_Framework_AssertionFailedError $e
	 * @param float                                  $time
	 * @return null
	 */
	public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time) {

		$this->write(
			sprintf("Test '%s' failed. %s", $test->getName(), $time), self::RED
		);
	}

	/**
	 * Incomplete test status
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param Exception              $e
	 * @param float                  $time
	 * @return null
	 */
	public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time) {

		$this->write(
			sprintf("Test '%s' is incomplete. %s", $test->getName(), $time), self::RED
		);
	}

	/**
	 * Risky test status
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param Exception              $e
	 * @param float                  $time
	 * @return null
	 */
	public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time) {

		$this->write(
			sprintf("Test '%s' is deemed risky. %s", $test->getName(), $time), self::BROWN
		);
	}

	/**
	 * Skipped test status
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param Exception              $e
	 * @param float                  $time
	 * @return null
	 */
	public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time) {

		$this->write(
			sprintf("Test '%s' has been skipped. %s", $test->getName(), $time), self::PURPLE
		);
	}

	/**
	 * Start test status message
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @return null
	 */
	public function startTest(PHPUnit_Framework_Test $test) {

		$this->write(
			sprintf("Test '%s' started.\n", $test->getName()), self::BLACK
		);
	}

	/**
	 * End test status message
	 *
	 * @param PHPUnit_Framework_Test $test
	 * @param float                  $time
	 * @return null
	 */
	public function endTest(PHPUnit_Framework_Test $test, $time) {

		$this->write(
			sprintf("\nTest '%s' ended. %s", $test->getName(), $time), self::BLACK
		);
	}

	/**
	 * Start test suite status
	 *
	 * @param PHPUnit_Framework_TestSuite $suite
	 * @return null
	 */
	public function startTestSuite(PHPUnit_Framework_TestSuite $suite) {

		$this->write(
			sprintf("\nTestSuite '%s' started", $suite->getName()), self::BLACK
		);
	}

	/**
	 * End test suite status
	 *
	 * @param PHPUnit_Framework_TestSuite $suite
	 * @return null
	 */
	public function endTestSuite(PHPUnit_Framework_TestSuite $suite) {

		$this->write(
			sprintf("\nTestSuite '%s' ended", $suite->getName()), self::BLACK
		);
	}

	/**
	 * Insulate color to string
	 *
	 * @param      $text
	 * @param null $color
	 * @return string
	 */
	public function write($text, $color = null)
	{
		if($color == null)
			return print $text;

		return print "\033[".$color."m" . $text . "\033[37m";
	}

	/**
	 * Write line
	 *
	 * @param      $text
	 * @param null $color
	 * @return string
	 */
	public function writeLine($text, $color = null){
		return $this->write($text, $color);
	}

	/**
	 * Output title
	 * @param      $title
	 * @param null $color
	 * @uses self::writeLine
	 * @return null
	 */
	public function writeTitle($title, $color = null){
		$this->writeLine("---------------------------\n", $color);
		$this->writeLine($title."\n", $color);
		$this->writeLine("---------------------------\n", $color);
	}
}