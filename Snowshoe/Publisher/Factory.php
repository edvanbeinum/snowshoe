<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Factory
 */

namespace Snowshoe\Publish;
/**
 * Creates an instance of the request Publish class.
 * So far Amazon's S3 is supported
 *
 * @package Factory
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Factory
{
    /**
     * @var Snowshoe\Publish\Adapter
     */
    protected static $_publish;

    /**
     * Simple parameterized factory method that returns an instance of the given TemplateEngine name.
     *
     * Exceptions are handled by the autoloader
     *
     * @param string $templateEngineName
     * @return AAdapter
     */
    public function getPublisher($templateEngineName = NULL)
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
