<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Husky
 */
require_once dirname(__FILE__) . '/../../../Husky/bootstrap.php';

/**
 *
 * @package HuskyTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class FactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * Return Factory back to original state
     *
     * @return void
     */
    public function tearDown()
    {
        \Husky\TemplateEngine\Factory::setTemplateEngine(NULL);
    }

    /**
     * @test
     */
    public function getterInjection_returns_exepcted_type()
    {
        $mockTwigAdapter = $this->getMock('\Husky\TemplateEngine\Adapter\Twig');
        \Husky\TemplateEngine\Factory::setTemplateEngine($mockTwigAdapter);

        $this->assertInstanceOf('\Husky\TemplateEngine\Adapter\Twig', Husky\TemplateEngine\Factory::getTemplateEngine());
    }

    /**
     * @test
     */
    public function getTemplateEngine_returns_expected_type_with_title_case()
    {
        $this->assertInstanceOf(
            '\Husky\TemplateEngine\Adapter\Twig',
            Husky\TemplateEngine\Factory::getTemplateEngine('Twig'),
            "getTemplateEngine not return expected type with title case format type"
        );
    }

    /**
     * @test
     */
    public function getTemplateEngine_returns_expected_type_with_lower_case()
    {
        $this->assertInstanceOf(
            '\Husky\TemplateEngine\Adapter\Twig',
            Husky\TemplateEngine\Factory::getTemplateEngine('twig'),
            "getTemplateEngine not return expected type with lowercase format type"
        );
    }

    /**
     * @test
     */
    public function getTemplateEngine_returns_expected_type_with_upper_case()
    {
        $this->assertInstanceOf(
            '\Husky\TemplateEngine\Adapter\Twig',
            Husky\TemplateEngine\Factory::getTemplateEngine('TWIG'),
            "getTemplateEngine not return expected type with lowercase format type"
        );
    }

    /**
     * @test
     * @expectedException ErrorException
     */
    public function getTemplateEngine_throws_error_on_unkown_formatter_type()
    {
        $class = Husky\TemplateEngine\Factory::getTemplateEngine('fake');
    }

}