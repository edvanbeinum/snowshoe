<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\Formatter;
/**
 * Abstract class for creating Formatter (Markdown, Textile, etc) Adapters
 *
 * @package Snowshoe
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
