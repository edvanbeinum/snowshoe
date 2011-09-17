<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Husky
 */
require_once dirname(__FILE__) . '/../../../../Husky/bootstrap.php';

/**
 *
 * @package HuskyTest
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class TwigTest extends PHPUnit_Framework_TestCase
{


    /**
     * @var Husky\TemplateEngine\Adapter\Twig
     */
    protected $_twig;

    public function setUp()
    {
        $this->_twig = new \Husky\TemplateEngine\Adapter\Twig;
    }

    /**
     * Return Factory back to original state
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_twig);
    }

    /**
     * Fairly arbitrary test to make sure the template engine is hooked up correctly
     *
     * @test
     */
    public function execute_returns_a_parsed_string()
    {
        $formattedString = '{{ "I like %s and %s."|format("this", "that") }}';
        $expected = "I like this and that.";
        $result = $this->_twig->execute($formattedString);

        $this->assertEquals($expected, $result);
    }
}