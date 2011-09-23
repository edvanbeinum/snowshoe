<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 17/09/2011
 * @package FormatterFactory
 */

namespace Snowshoe\Formatter;
/**
 *
 * @package FormatterFactory
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Factory
{
    /**
     * @var AFormatter
     */
    protected static $_formatterEngine;


    public function getFormatter($formatterEngineName = NULL)
    {
        if (is_null(self::$_formatterEngine)) {

            $newClassName = '\Snowshoe\Formatter\Adapter\\' . ucwords(strtolower($formatterEngineName));
            return new $newClassName;
        }
        return self::$_formatterEngine;
    }

    public static function setFormatter($formatterEngine)
    {
        self::$_formatterEngine = $formatterEngine;
    }
}
