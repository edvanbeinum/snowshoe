<?php
/**
 * 
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/09/2011
 * @package IAdapter 
 */
 
namespace Husky\Parser\Adapter;
 /**
 * 
 * @package IAdapter
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
interface IAdapter {

    /**
     * Runs the Parser Engine on the given $content and returns the parsed result
     *
     * @abstract
     * @param $content
     * @return string
     */
    public function execute($content);
}
