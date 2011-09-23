<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package AFormatter
 */

namespace Snowshoe\Formatter;
/**
 *
 * @package AFormatter
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
abstract class AAdapter
{

    /**
     * Takes a formatted string (in Markdown, Textile, etc) and returns an HTML version
     *
     * @abstract
     * @param string $formattedString
     * @return string
     */
    abstract public function execute($formattedString);
}