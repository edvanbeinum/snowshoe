<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 16/10/2011
 * @package PublisherTest
 */

namespace Snowshoe\tests\Publisher;
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
        $mockConfig = $this->_getMockConfig();
        $this->_publisher = new \Snowshoe\Publisher\Factory($mockConfig);
    }

    /**
     * Return Factory back to original state
     *
     * @return void
     */
    public function tearDown()
    {
        \Snowshoe\Publisher\Factory::setPublisher(NULL);
    }

    /**
     * Helper menthod that returns a mock \Snowshoe\Config\App obkect
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function _getMockConfig()
    {
        $config = $this->getMock('\Snowshoe\Config\App', array('getS3Key', 'getS3SecretKey', 'getS3BucketName'));
        $config->expects($this->any())
                ->method('getS3Key')
                ->will($this->returnValue('test'));
        $config->expects($this->any())
                ->method('getS3SecretKey')
                ->will($this->returnValue('test'));
        $config->expects($this->any())
                ->method('getS3BucketName')
                ->will($this->returnValue('test'));

        return $config;
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function getPublisher_throws_exception_with_unknown_name()
    {
        $this->_publisher->getPublisher('cabbage');
    }

    /**
     * @test
     */
    public function getPublisher_returns_expected_object()
    {
        $this->assertInstanceOf(
            '\Snowshoe\Publisher\Adapter\S3',
            $this->_publisher->getPublisher('s3')
        );
    }

    /**
     * @test
     */
    public function getPublisher_returns_publisher_that_has_been_set()
    {
        $mockPublisher = new \stdClass();
        $this->_publisher->setPublisher($mockPublisher);
        $this->assertEquals($mockPublisher, $this->_publisher->getPublisher());
    }

}

