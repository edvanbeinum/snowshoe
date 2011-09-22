<?php
/**
 * 
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package HuskyTest 
 */
 
require_once dirname(__FILE__) . '/../../Husky/bootstrap.php';

 /**
 * 
 * @package HuskyTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class BuilderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \Husky\Builder
     */
    protected $_builder;

    public function setUp(){
        $mockFormatter = $this->getMockForAbstractClass('Husky\Formatter\AAdapter');
        $mockTemplateEngine = $this->getMockForAbstractClass('Husky\TemplateEngine\AAdapter');
        $mockFileSystem = $this->getMock('Husky\Helper\FileSystem');
       // $mockNavigaton = $this->getMock('Husky\Helper\Navigation');

       // $this->_builder = new \Husky\Builder($mockFormatter, $mockTemplateEngine, $mockFileSystem, $mockNavigaton);
    }

    /**
     * @test
     */
    public function dummy()
    {
        
    }


}
