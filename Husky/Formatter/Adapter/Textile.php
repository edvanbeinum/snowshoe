<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package MarkdownAdapter
 */
namespace Husky\Formatter\Adapter;

/**
 * Textile Formatter Adapter. This class knows how to interact with the MArkdown library
 *
 * @package MarkdownAdapter
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Textile extends \Husky\Formatter\AAdapter
{

    /**
     * converts a Textile formatted string into an HTML formatted string
     *
     * @param $formattedString
     * @return string
     */
    public function execute($formattedString)
    {
        require_once APPLICATION_PATH . 'Husky/Vendor/Formatters/textile/classTextile.php';
        $t = new \Textile();
        return Markdown($t->TextileThis($formattedString));
    }
}
