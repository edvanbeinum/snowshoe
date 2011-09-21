<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package MarkdownAdapter
 */
namespace Husky\Formatter\Adapter;

/**
 * Markdown Formatter Adapter. This class knows how to interact with the MArkdown library
 *
 * @package MarkdownAdapter
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Markdown extends \Husky\Formatter\AAdapter
{

    /**
     * converts a Markdown formatted string into an HTML formatted string
     *
     * @param $formattedString
     * @return string
     */
    public function execute($formattedString)
    {
        require_once APPLICATION_PATH . 'Husky/Vendor/Formatters/php-markdown/markdown.php';
        return Markdown($formattedString);
    }
}
