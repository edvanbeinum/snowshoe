<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 17/09/2011
 * @package FormatterFactory
 */

namespace Husky\TemplateEngine;
/**
 *
 * @package FormatterFactory
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Factory
{
    /**
     * @var AAdapter
     */
    protected static $_templateEngine;


    /**
     * Simple parameterized factory method that returns an instance of the given TemplateEngine name.
     *
     * Exceptions are handled by the autoloader
     *
     * @static
     * @param string $templateEngineName
     * @return AAdapter
     */
    public static function getTemplateEngine($templateEngineName = NULL)
    {
        if (is_null(self::$_templateEngine)) {
            $newClassName = '\Husky\TemplateEngine\Adapter\\' . ucwords(strtolower($templateEngineName));
            return new $newClassName;
        }
        return self::$_templateEngine;
    }

    /**
     * Sets the TemplateEngine. This is only used by the unit tests
     *
     * @static
     * @param $templateEngine
     * @return void
     */
    public static function setTemplateEngine($templateEngine)
    {
        self::$_templateEngine = $templateEngine;
    }
}
