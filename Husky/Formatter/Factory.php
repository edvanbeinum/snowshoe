<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 17/09/2011
 * @package FormatterFactory
 */

namespace Husky\Formatter;
/**
 *
 * @package FormatterFactory
 * @author Ed van Beinum <edwin@sessiondigital.com>
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

            $newClassName = '\Husky\Formatter\Adapter\\' . ucwords(strtolower($formatterEngineName));
            return new $newClassName;
        }
        return self::$_formatterEngine;
    }

    public static function setFormatter($formatterEngine)
    {
        self::$_formatterEngine = $formatterEngine;
    }
}
