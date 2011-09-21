<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 20/09/2011
 * @package Factory
 */

namespace Husky\Config;

/**
 *
 * @package Factory
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Factory
{

    /**
     * Simple parameterized factory method for generating instances of Config objects
     *
     * @static
     * @param string $name
     * @return \Husky\Config\AConfig
     */
    public static function getConfig($name)
    {
        $newClassName = '\Husky\Config\\' . ucfirst($name);
        return new $newClassName;
    }
}
