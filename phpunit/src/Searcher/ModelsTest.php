<?php
namespace Test\Searcher;

use Phalcon\DI;
use Phalcon\DI\FactoryDefault;
use Searcher\Searcher;

/**
 * Class ModelsTest
 *
 * @package Test\Searcher
 * @since   PHP >=5.5.12
 * @version 1.0
 * @author  Stanislav WEB | Lugansk <stanisov@gmail.com>
 *
 */
class ModelsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tested object
     *
     * @var \Searcher\Searcher
     */
    private $searcher;

    /**
     * Dependency Injection container
     *
     * @var \Phalcon\DI
     */
    private $di;

    /**
     * Models manager
     *
     * @var \Phalcon\Mvc\Model\Manager
     */
    private $manager;

    /**
     * Initialize testing object
     *
     * @uses Searcher
     * @uses \ReflectionClass
     */
    public function setUp()
    {

        $loader = new \Phalcon\Loader();

        $loader->registerDirs(array(
            './Models'
        ));

        $loader->register();

        $this->di = new FactoryDefault();
        $this->di->reset();

        /**
         * Setup DI
         */
        $this->di   =  new DI();

        $this->di->set('modelsManager', function() {
            return new \Phalcon\Mvc\Model\Manager();
        });

        $this->di->set('modelsMetadata', function() {
            return new \Phalcon\Mvc\Model\MetaData\Memory();
        });

        DI::setDefault($this->di);

        // initialize test models

        $this->manager  =   $this->di->get('modelsManager');
        //$this->manager->initialize(new \Test\Searcher\Models\Auto());
        //$this->manager->initialize(new \Test\Searcher\Models\Distributor());
    }

    public function testModels()
    {
        $this->searcher = new Searcher();
    }

    /**
     * Kill testing object
     *
     * @uses Builder
     */
    public function tearDown()
    {
        $this->di = null;
        $this->manager = null;
    }
}


 
