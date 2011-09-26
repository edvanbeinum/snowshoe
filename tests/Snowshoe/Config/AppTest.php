<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Snowshoe
 */
require_once dirname(__FILE__) . '/../../../Snowshoe/bootstrap.php';

/**
 *
 * @package SnowshoeTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class AppTest extends PHPUnit_Framework_TestCase
{
    protected $_app;

    public function setUp()
    {
        $this->_app = new \Snowshoe\Config\App();
    }

    public function tearDown()
    {
        unset($this->_app);
    }

    /**
     * @test
     * @return void
     */
    public function magic_getter_returns_array_values()
    {
        $expected = array('one' => 'test', 'two' => 'lipsum');
        $this->_app->setConfig($expected);
        $this->assertSame('test', $this->_app->getOne());
    }

    /**
     * @test
     */
    public function magic_getter_translates_underscores_into_camel_case()
    {
        $expected = array('multi_word_var' => 'test',);
        $this->_app->setConfig($expected);
        $this->assertSame('test', $this->_app->getMultiWordVar());
    }

    /**
     * @test
     * @expectedException ErrorException
     */
    public function config_throws_exception_when_value_does_not_exist()
    {
        $config = array(
            'test' => 'value'
        );
        $this->_app->setConfig($config);
        $this->_app->getNonExistentValue();
    }

}