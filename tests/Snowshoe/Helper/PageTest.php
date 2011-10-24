<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package SnowshoeTest
 */

require_once dirname(__FILE__) . '/../../../Snowshoe/bootstrap.php';

/**
 * Test class for Page.
 */
class PageTest extends PHPUnit_Framework_TestCase
{

    /**
     * Helper function that creates a mock FormatterFactory and will set the value returned by calling execute() on the
     * created formatter class
     *
     * @param $returnValue
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function _getMockFormatterFactory($returnValue)
    {
        $mockFormatter = $this->getMock('\Snowshoe\Formatter\Adapter\Markdown');
        $mockFormatter->expects($this->any())
                ->method('execute')
                ->will($this->returnValue($returnValue));

        $mockFactory = $this->getMock('\Snowshoe\Formatter\Factory', array('getFormatter'));
        $mockFactory->expects($this->any())
                ->method('getFormatter')
                ->will($this->returnValue($mockFormatter));

        return $mockFactory;
    }

    /**
     * Helper function that returns a new instance of the Page Helper object
     *
     * @param $mockFactory
     * @param $config
     * @return Snowshoe\Helper\Page
     */
    protected function _getPage($mockFactory, $config = NULL)
    {
        if (is_null($config)) {
            $config = $this->getMock('\Snowshoe\Config\App');
        }
        return $this->_page = new \Snowshoe\Helper\Page($mockFactory, $config);
    }

    /**
     * @test
     */
    public function getPageTitle_returns_expected_string_with_h1()
    {
        $expected = "This is nice";
        $page = $this->_getPage($this->_getMockFormatterFactory('<h1>This is nice</h1>'));
        $this->assertSame($expected, $page->getPageTitle('dummy', 'test-file'));
    }

    /**
     * @test
     */
    public function getPageTitle_returns_expected_string_with_h2()
    {
        $expected = "This is nice";
        $page = $this->_getPage($this->_getMockFormatterFactory('<h2>This is nice</h2>'));
        $this->assertSame($expected, $page->getPageTitle('dummy', 'test-file'));
    }

    /**
     * @test
     */
    public function getPageTitle_returns_expected_string_from_filename()
    {
        $expected = "This Is Nice";
        $page = $this->_getPage($this->_getMockFormatterFactory('<p>This is nice</p>'));
        $this->assertSame($expected, $page->getPageTitle('dummy text', 'this-is-nice'));
    }

    /**
     * @test
     */
    public function getPageTitle_returns_expected_string_from_splFileInfo_object()
    {
        $splFileInfo = $this->getMockBuilder('\splFileInfo')
                ->disableOriginalConstructor()
                ->getMock();
        $splFileInfo->expects($this->any())
                ->method('getFilename')
                ->will($this->returnValue('this-is-nice.html'));

        $expected = "This Is Nice";
        $page = $this->_getPage($this->_getMockFormatterFactory('<p>This is nice</p>'));
        $this->assertSame($expected, $page->getPageTitle('dummy text', $splFileInfo));
    }

    /**
     * @test
     */
    public function getPublicFilename_replaces_formatter_extension_with_public_extension()
    {
        $config = $this->getMock('\Snowshoe\Config\App', array('getFormatterFileExtension', 'getPublicFileExtension'));
        $config->expects($this->once())
                ->method('getFormatterFileExtension')
                ->will($this->returnValue('.md'));
        $config->expects($this->once())
                ->method('getPublicFileExtension')
                ->will($this->returnValue('.html'));
        $mockFactory = $this->getMock('\Snowshoe\Formatter\Factory');

        $page = $this->_getPage($mockFactory, $config);
        $expected = 'filename.html';
        $this->assertSame($expected, $page->getPublicFilename('filename.md'));

    }

    /**
     * @test
     */
    public function getPublicFilePath_replaces_Content_dir_with_Public_dir()
    {
        $config = $this->getMock('\Snowshoe\Config\App', array('getContentDirectory', 'getPublicDirectory', 'getFormatterFileExtension', 'getPublicFileExtension'));
        $config->expects($this->once())
                ->method('getContentDirectory')
                ->will($this->returnValue('/absolute/content/dir'));
        $config->expects($this->once())
                ->method('getPublicDirectory')
                ->will($this->returnValue('/absolute/public/dir'));
        $config->expects($this->once())
                ->method('getFormatterFileExtension')
                ->will($this->returnValue('.md'));
        $config->expects($this->once())
                ->method('getPublicFileExtension')
                ->will($this->returnValue('.html'));
        $mockFactory = $this->getMock('\Snowshoe\Formatter\Factory');

        $page = $this->_getPage($mockFactory, $config);
        $expected = APPLICATION_PATH . '/absolute/public/dir/filename.html';
        $this->assertSame($expected, $page->getPublicFilePath(APPLICATION_PATH . '/absolute/content/dir/filename.md'));

    }

    /**
     * @test
     */
    public function getPageUrl_returns_relative_url()
    {
        $config = $this->getMock('\Snowshoe\Config\App', array('getIsProductionMode', 'getContentDirectory', 'getFormatterFileExtension', 'getPublicFileExtension'));
        $config->expects($this->any())
                ->method('getIsProductionMode')
                ->will($this->returnValue(TRUE));
        $config->expects($this->once())
                ->method('getContentDirectory')
                ->will($this->returnValue('/absolute/content/dir'));
        $config->expects($this->once())
                ->method('getFormatterFileExtension')
                ->will($this->returnValue('.md'));
        $config->expects($this->once())
                ->method('getPublicFileExtension')
                ->will($this->returnValue('.html'));
        $mockFactory = $this->getMock('\Snowshoe\Formatter\Factory');
        $page = $this->_getPage($mockFactory, $config);

        $expected = '/subdir/filename.html';
        $this->assertSame($expected, $page->getPageUrl(APPLICATION_PATH . '/absolute/content/dir/subdir/filename.md'));

    }
}