<?php
/**
 * 
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package TemplateEngine_Adapter_Interface 
 */
 
namespace Husky\TemplateEngine\Adapter;
 /**
 * 
 * @package TemplateEngine_Adapter_Interface
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
interface IAdapter {

    /**
     * Renders the given string encoded in the template engine that the subclass represents.
     * Return an HTML formatted string
     *
     * @abstract
     * @param  string $encodedString
     * @param array $vars
     * @return string
     */
    public function render($encodedString, array $vars = array());
}
