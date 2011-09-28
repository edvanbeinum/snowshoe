<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\Formatter;
/**
 * Factory class for creating concrete Formatter Adapter classes.
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Factory
{
    /**
     * @var AFormatter
     */
    protected static $_formatterEngine;


    /**
     * Returns an instance of the Formatter class
     *
     * @param null $formatterEngineName
     * @return AFormatter
     */
    public function getFormatter($formatterEngineName = NULL)
    {
        if (is_null(self::$_formatterEngine)) {

            $newClassName = '\Snowshoe\Formatter\Adapter\\' . ucwords(strtolower($formatterEngineName));
            return new $newClassName;
        }
        return self::$_formatterEngine;
    }

    /**
     * Set the Formatter. Used for unit testing
     *
     * @static
     * @param $formatterEngine
     * @return void
     */
    public static function setFormatter($formatterEngine)
    {
        self::$_formatterEngine = $formatterEngine;
    }
}
