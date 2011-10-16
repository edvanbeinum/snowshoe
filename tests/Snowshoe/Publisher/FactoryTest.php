<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 16/10/2011
 * @package PublisherTest
 */

require_once dirname(__FILE__) . '/../../../Snowshoe/bootstrap.php';

/**
 *
 * @package PublisherTest
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Snowshoe\Publisher\Factory
     */
    protected $_publisher;

    /**
     * Setup fixture
     *
     * @return void
     */
    public function setUp()
    {
        $this->_publisher = new \Snowshoe\Publisher\Factory;
    }

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
     * @expectedException Exception
     */
    public function getPublisher_throws_exception_with_unknown_name()
    {
        $this->_publisher->getPublisher('cabbage');
    }

    public function getPublisher_returns_expected_object()
    {
        $this->assertInstanceOf(
            '\Snowshoe\Publisher\Adapter\S3',
            $this->_publisher->getPublisher('s3')
        );
    }
}

