<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package SnowshoeTest
 */

require_once dirname(__FILE__) . '/../../../Snowshoe/bootstrap.php';
require_once 'vfsStream/vfsStream.php';

/**
 * Test class for String.
 */
class StringTest extends PHPUnit_Framework_TestCase
{


    /**
     * @test
     */
    public function getDeslugified_returns_expected_string()
    {
        $expected = "This Is Nice";
        $this->assertSame($expected, \Snowshoe\Helper\String::getDeslugified('this-is-nice'));
    }

    /**
     * @test
     */
    public function getDeslugified_returns_expected_string_with_integers()
    {
        $expected = "This Is Nice 0001";
        $this->assertSame($expected, \Snowshoe\Helper\String::getDeslugified('this-is-nice-0001'));
    }

    /**
     * @test
     */
    public function getDeslugified_returns_expected_string_with_underscores()
    {
        $expected = "This Is Nice";
        $this->assertSame($expected, \Snowshoe\Helper\String::getDeslugified('this_is_nice'));
    }

    /**
     * @test
     */
    public function getDeslugified_returns_expected_string_with_trailing_underscores()
    {
        $expected = "This Is Nice";
        $this->assertSame($expected, \Snowshoe\Helper\String::getDeslugified('this_is_nice_'));
    }

    /**
     * @test
     */
    public function getDeslugified_returns_expected_string_with_leading_underscores()
    {
        $expected = "This Is Nice";
        $this->assertSame($expected, \Snowshoe\Helper\String::getDeslugified('_this_is_nice'));
    }

    /**
     * @test
     */
    public function getDeslugified_returns_expected_string_with_underscores_and_integers()
    {
        $expected = "This Is Nice 0001";
        $this->assertSame($expected, \Snowshoe\Helper\String::getDeslugified('this_is_nice_0001'));
    }

}