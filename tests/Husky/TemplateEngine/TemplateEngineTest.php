<?php
/**
 * 
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 12/09/2011
 * @package TemplateEngineTest 
 */
 
require_once dirname(__FILE__) . '/../../../Husky/bootstrap.php';
require_once 'vfsStream/vfsStream.php';
 /**
 * 
 * @package TemplateEngineTest
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class TemplateEngineTest extends PHPUnit_Framework_TestCase{

    protected $_templateEngine;

    public function setUp()
    {
        $this->_templateEngine = new \Husky\TemplateEngine\TemplateEngine;
    }

    public function tearDown()
    {
        unset($this->_templateEngine);
    }

    /**
     * @return void
     * @test
     */
    public function parseContent_calls_execute_on_templateEngine_engine()
    {
        $mockTemplateEngineEngine = $this->getMock('\Husky\TemplateEngine\Adapter\Twig');
        $mockTemplateEngineEngine->expects($this->once())
                ->method('render')
                ->withAnyParameters();
        $this->_templateEngine->setTemplateEngine($mockTemplateEngineEngine);

        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        vfsStream::newFile('file.md')->at(vfsStreamWrapper::getRoot());
        $this->_templateEngine->parseTemplate(vfsStream::url('rootDir/file.md'), array('var' => 'dummy content'));
    }
}
