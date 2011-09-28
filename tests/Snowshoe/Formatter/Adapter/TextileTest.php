<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Snowshoe
 */
require_once dirname(__FILE__) . '/../../../../Snowshoe/bootstrap.php';

/**
 *
 * @package SnowshoeTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class TextileTest extends PHPUnit_Framework_TestCase
{


    /**
     * @var Snowshoe\Formatter\Adapter\Textile
     */
    protected $_textile;

    public function setUp()
    {
        $this->_textile = new \Snowshoe\Formatter\Adapter\Textile;
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
        $formattedString = "h1. Hello";
        $expected = "<h1>Hello</h1>";
        $result = trim($this->_textile->execute($formattedString));

        $this->assertEquals($expected, $result);
    }
}