<?php
/**
 * 
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package HuskyTest 
 */
 
require_once '../../Husky/bootstrap.php';

 /**
 * 
 * @package HuskyTest
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class HuskyTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \Husky\Husky
     */
    protected $_husky;

    public function setUp(){
        $this->_husky = new \Husky\Husky;
    }

    /**
     * Are the member vars set with the expected vales form config when Husky class is onstantiated?
     *
     * @test
     * @return void
     */
    public function construct_sets_member_vars_from_config()
    {
       // $this->assertSame($this->_husky->getParser()->g, \Husky\Config::PARSER, 'Parser values do not match');
       // $this->assertSame($this->_husky->getTemplatingEngineName(), \Husky\Config::TEMPLATINGENGINE, 'Templating Engines values do not match');
    }

    /**
     * @test
     */
    public function getTemplateEngineObject_returns_instance_of_expected_class()
    {
//        $templateEngine = $this->_husky->getTemplateEngine();
//        $this->assertInstanceOf('Husky\TemplateEngine\Adapter\IAdapter', $templateEngine, 'TemplateEngine is not of expected Interface');
//        $this->assertInstanceOf('Husky\TemplateEngine\Adapter\TwigAdapter', $templateEngine, 'TemplateEngine is not of expected concrete class');
    }

    /**
     * @test
     */
    public function execute()
    {
         var_dump($this->_husky->execute());
    }

    /**
     * @return void
     * @test
     */
    public function buildLinks_returns_expected_array()
    {
        //var_dump($this->_husky->_buildLinks(APPLICATION_PATH . \Husky\Config::CONTENT_PATH));
    }

}
