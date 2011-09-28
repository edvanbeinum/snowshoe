<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package Snowshoe
 */
namespace Snowshoe\Formatter\Adapter;

/**
 * Markdown Formatter Adapter. This class knows how to interact with the MArkdown library
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Markdown extends \Snowshoe\Formatter\AAdapter
{

    /**
     * converts a Markdown formatted string into an HTML formatted string
     *
     * @param $formattedString
     * @return string
     */
    public function execute($formattedString)
    {
        require_once APPLICATION_PATH . 'Snowshoe/Vendor/Formatters/php-markdown/markdown.php';
        return Markdown($formattedString);
    }
}
