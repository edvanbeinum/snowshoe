<?php
/**
 * 
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package AFormatter 
 */
 
 namespace Snowshoe\TemplateEngine;
 /**
 * 
 * @package AFormatter
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
