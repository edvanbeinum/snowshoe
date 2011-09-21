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
class TextileTest extends PHPUnit_Framework_TestCase
{


    /**
     * @var Husky\Formatter\Adapter\Textile
     */
    protected $_textile;

    public function setUp()
    {
        $this->_textile = new \Husky\Formatter\Adapter\Textile;
    }

    /**
     * Return Factory back to original state
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_textile);
    }

    /**
     * @test
     */
    public function execute_returns_html_string()
    {
        $formattedString = "h1. Hello \n";
        $expected = "<h1>Hello</h1>";
        $result = $this->_textile->execute($formattedString);

        $this->assertEquals($expected, $result);
    }
}