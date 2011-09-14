<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 12/09/2011
 * @package ParserTest
 */

require_once dirname(__FILE__) . '/../../../Husky/bootstrap.php';
require_once 'vfsStream/vfsStream.php';
/**
 *
 * @package ParserTest
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class ParserTest extends PHPUnit_Framework_TestCase
{

    protected $_parser;

    public function setUp()
    {
        $this->_parser = new \Husky\Parser\Parser;
    }

    public function tearDown()
    {
        unset($this->_parser);
    }

    /**
     * @return void
     * @test
     */
    public function parseContent_calls_execute_on_parser_engine()
    {
        $mockParserEngine = $this->getMock('\Husky\Parser\Adapter\Markdown');
        $mockParserEngine->expects($this->once())
                ->method('execute')
                ->withAnyParameters();
        $this->_parser->setParserEngine($mockParserEngine);

        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        vfsStream::newFile('file.md')->at(vfsStreamWrapper::getRoot());
        $this->_parser->parseContent(vfsStream::url('rootDir/file.md'));
    }

    /**
     * @test
     */
    public function getPageTitle_returns_expected_string()
    {

    }
}
