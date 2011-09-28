<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package SnowshoeTest
 */
namespace Snowshoe\tests\Formatter;
require_once dirname(__FILE__) . '/../../../Snowshoe/bootstrap.php';
/**
 *
 * @package SnowshoeTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Return Factory back to original state
     *
     * @return void
     */
    public function tearDown()
    {
        \Snowshoe\Formatter\Factory::setFormatter(NULL);
    }

    /**
     * @test
     */
    public function getterInjection_returns_exepcted_type()
    {
        $mockMarkdownAdapter = $this->getMock('\Snowshoe\Formatter\Adapter\Markdown');
        \Snowshoe\Formatter\Factory::setFormatter($mockMarkdownAdapter);

        $this->assertInstanceOf('\Snowshoe\Formatter\Adapter\Markdown', \Snowshoe\Formatter\Factory::getFormatter());
    }

    /**
     * @test
     */
    public function getFormatter_returns_expected_type_with_title_case()
    {
        $this->assertInstanceOf(
            '\Snowshoe\Formatter\Adapter\Markdown',
            \Snowshoe\Formatter\Factory::getFormatter('Markdown'),
            "getFormatter not return expected type with title case format type"
        );
    }

    /**
     * @test
     */
    public function getFormatter_returns_expected_type_with_lower_case()
    {
        $this->assertInstanceOf(
            '\Snowshoe\Formatter\Adapter\Markdown',
            \Snowshoe\Formatter\Factory::getFormatter('markdown'),
            "getformatter not return expected type with lowercase format type"
        );
    }

    /**
     * @test
     */
    public function getFormatter_returns_expected_type_with_upper_case()
    {
        $this->assertInstanceOf(
            '\Snowshoe\Formatter\Adapter\Markdown',
            \Snowshoe\Formatter\Factory::getFormatter('MARKDOWN'),
            "getformatter not return expected type with lowercase format type"
        );
    }

    /**
     * @test
     * @expectedException ErrorException
     */
    public function getFormatter_throws_error_on_unkown_formatter_type()
    {
        $class = \Snowshoe\Formatter\Factory::getFormatter('fake');
    }

}