<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Husky
 */
require_once dirname(__FILE__) . '/../../../../Husky/bootstrap.php';

/**
 *
 * @package HuskyTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class MarkdownTest extends PHPUnit_Framework_TestCase
{


    /**
     * @var Husky\Formatter\Adapter\Markdown
     */
    protected $_markdown;

    public function setUp()
    {
        $this->_markdown = new \Husky\Formatter\Adapter\Markdown;
    }

    /**
     * Return Factory back to original state
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_markdown);
    }

    /**
     * @test
     */
    public function execute_returns_html_string()
    {
        $formattedString = "# Hello\n";
        $expected = "<h1>Hello</h1>\n";
        $result = $this->_markdown->execute($formattedString);

        $this->assertEquals($expected, $result);
    }
}