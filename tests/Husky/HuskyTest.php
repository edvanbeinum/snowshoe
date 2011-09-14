<?php
/**
 * 
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package HuskyTest 
 */
 
require_once dirname(__FILE__) . '/../../Husky/bootstrap.php';

 /**
 * 
 * @package HuskyTest
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class HuskyTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \Husky\Husky
     */
    protected $_husky;

    public function setUp(){
        $this->_husky = new \Husky\Husky;
    }




}
