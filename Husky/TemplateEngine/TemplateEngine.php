<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 10/09/2011
 * @package TemplateEngine
 */

namespace Husky\TemplateEngine;
/**
 *
 * @package TemplateEngine
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class TemplateEngine
{
    /**
     * Holds the name of the Templating Engine. Twig or Mustache ship with Husky
     *
     * @var string
     */
    protected $_templateEngineName;

    /**
     * @var \Husky\TemplateEngine\Adapter\IAdapter
     */
    protected static $_templateEngine;

    public function __construct($templatingEngineName)
    {
        $this->_templateEngineName = $templatingEngineName;
    }

    /**
     * A simple Parameterized Factory method
     * Instantiates and returns an adapter object of the specified type.
     *
     * @return \Husky\TemplateEngine\Adapter\IAdapter
     */
    public function getTemplateEngine()
    {
        // Used for testing, we can inject a mock Adapter into _templateEngine class var
        if (!is_null(self::$_templateEngine)) {
            return self::$_templateEngine;
        }

        $className = 'Husky\TemplateEngine\Adapter\\' . $this->_templateEngineName;
        return new $className;
    }


    public function setTemplatingEngine($templateEngine)
    {
        self::$_templateEngine = $templateEngine;
    }


    /**
     * Run the given content through the template file at the given template file path
     *
     * @param string $templateFilePath
     * @param string $content
     * @return String
     */
    public function parseTemplate($templateFilePath, $content)
    {
        $template = file_get_contents($templateFilePath);
        return $this->getTemplateEngine($this->_templateEngineName)->render($template, $content);
    }

}
