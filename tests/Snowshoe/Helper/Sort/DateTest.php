<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package SnowshoeTest
 */
require_once dirname(__FILE__) . '/../../../../Snowshoe/bootstrap.php';

/**
 *
 * @package SnowshoeTest
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class DateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Snowshoe\Helper\Sort\Date
     */
    protected $_date;

    public function setUp()
    {
        $this->_date = new \Snowshoe\Helper\Sort\Date;
    }

    /**
     * Helper function that creates mock SplFileInfo objects
     *
     * @param $returnValue
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function _getMockSplFileInfo($returnValue)
    {
        $splFileInfo = $this->getMockBuilder('\splFileInfo')
                ->disableOriginalConstructor()
                ->getMock();
        $splFileInfo->expects($this->any())
                ->method('getFilename')
                ->will($this->returnValue($returnValue));
        return $splFileInfo;
    }

    /**
     * @test
     * @return void
     */
    public function sortAsc_returns_negative_int_when_a_is_before_b()
    {
        $result = $this->_date->sortAsc(
            $this->_getMockSplFileInfo('1316670643'),
            $this->_getMockSplFileInfo('1316670743')
        );
        $this->assertSame(
            0,
            max(0, $result) // we expected 0 to be bigger than $result
        );
    }

    /**
     * @test
     */
    public function sortAsc_returns_positive_int_when_a_is_after_b()
    {
        $result = $this->_date->sortAsc(
            $this->_getMockSplFileInfo('1316670743'),
            $this->_getMockSplFileInfo('1316650743')
        );
        $this->assertSame(
            0,
            min(0, $result) // we expect 0 to be less than $result
        );
    }

    /**
     * @test
     */
    public function sortAsc_returns_zero_when_a_is_sames_as_b()
    {
        $result = $this->_date->sortAsc(
            $this->_getMockSplFileInfo('1316670743'),
            $this->_getMockSplFileInfo('1316670743')
        );
        $this->assertSame(
            0,
            $result
        );
    }

    /**
     * @test
     * @return void
     */
    public function sortDesc_returns_positive_int_when_a_is_before_b()
    {
        $result = $this->_date->sortDesc(
            $this->_getMockSplFileInfo('1316670643'),
            $this->_getMockSplFileInfo('1316670743')
        );
        $this->assertSame(
            0,
            min(0, $result) // we expected 0 to be less than $result
        );
    }

    /**
     * @test
     */
    public function sortDesc_returns_negative_int_when_a_is_after_b()
    {
        $result = $this->_date->sortDesc(
            $this->_getMockSplFileInfo('1316670743'),
            $this->_getMockSplFileInfo('1316650743')
        );
        $this->assertSame(
            0,
            max(0, $result) // we expect 0 to be greater than $result
        );
    }

    /**
     * @test
     */
    public function sortDesc_returns_zero_when_a_is_sames_as_b()
    {
        $result = $this->_date->sortDesc(
            $this->_getMockSplFileInfo('1316670743'),
            $this->_getMockSplFileInfo('1316670743')
        );
        $this->assertSame(
            0,
            $result
        );
    }

}