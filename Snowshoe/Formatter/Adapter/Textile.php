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
 * Textile Formatter Adapter. This class knows how to interact with the MArkdown library
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Textile extends \Snowshoe\Formatter\AAdapter
{

    /**
     * converts a Textile formatted string into an HTML formatted string
     *
     * @param $formattedString
     * @return string
     */
    public function execute($formattedString)
    {
        require_once APPLICATION_PATH . 'Snowshoe/Vendor/Formatters/textile/classTextile.php';
        $t = new \Textile();
        return $t->TextileThis($formattedString);
    }
}
