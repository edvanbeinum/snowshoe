<?php
/**
 * 
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package AFormatter 
 */
 
 namespace Husky\Formatter;
 /**
 * 
 * @package AFormatter
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
abstract class AAdapter {

    /**
     * Takes a formatted string (in MArkdown, Textile, etc) and returns an HTML version
     *
     * @abstract
     * @param string $formattedString
     * @return string
     */
    abstract public function execute($formattedString);

    public function getTitle()
    {
        
    }
}
