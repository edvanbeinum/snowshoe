<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 22/09/2011
 * @package String
 */

namespace Husky\Helper;
/**
 * A bunch of hlper methods for Strings
 *
 * @package String
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class String
{


    /**
     * converts a slugged string (we guess something like: dashes or underscores used instead of spaces and all lowercase)
     * to a title case string
     * e.g. this-is-a-slug becomes This Is A Slug
     *
     * @param $sluggedString
     * @return string
     */
    public static function getDeslugifiedString($sluggedString)
    {
        $desluggedString = str_replace(array('-', '_'), ' ', $sluggedString);
        return ucwords($desluggedString);
    }
}
