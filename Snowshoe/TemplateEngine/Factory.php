<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\TemplateEngine;
/**
 * Factory class for creating concrete instances of a TemplateEngine Adapter
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
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
     * @param string $templateEngineName
     * @return AAdapter
     */
    public function getTemplateEngine($templateEngineName = NULL)
    {
        if (is_null(self::$_templateEngine)) {
            $newClassName = '\Snowshoe\TemplateEngine\Adapter\\' . ucwords(strtolower($templateEngineName));
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
