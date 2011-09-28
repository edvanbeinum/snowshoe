<?php
/**
 * 
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */
 
 namespace Snowshoe\TemplateEngine;
 /**
 *  Abstract class for concrete TemplateEngine Adapter objects
  *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
abstract class AAdapter {

    /**
     * Instance variable to hold a reference to the instantiated Twig Template Engine
     *
     * @var unknown
     */
    protected $_templateEngine;

    /**
     * Takes a templated string and the variables to be injected and returns the result
     *
     * @abstract
     * @param $templateString
     * @param array $templateVars
     * @return void
     */
    abstract public function execute($templateString, array $templateVars = array());
}
