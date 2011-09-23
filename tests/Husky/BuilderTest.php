<?php
/**
 * 
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package SnowshoeTest
 */
 
require_once dirname(__FILE__) . '/../../Snowshoe/bootstrap.php';

 /**
 * 
 * @package SnowshoeTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class BuilderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \Snowshoe\Builder
     */
    protected $_builder;

    public function setUp(){
        $mockFormatter = $this->getMockForAbstractClass('Snowshoe\Formatter\AAdapter');
        $mockTemplateEngine = $this->getMockForAbstractClass('Snowshoe\TemplateEngine\AAdapter');
        $mockFileSystem = $this->getMock('Snowshoe\Helper\FileSystem');
       // $mockNavigaton = $this->getMock('Snowshoe\Helper\Navigation');

       // $this->_builder = new \Snowshoe\Builder($mockFormatter, $mockTemplateEngine, $mockFileSystem, $mockNavigaton);
    }

    /**
     * @test
     */
    public function dummy()
    {
        
    }


}
