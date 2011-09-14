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

    public function __construct($templateEngineName = 'Twig')
    {
        $this->_templateEngineName = $templateEngineName;
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


    public function setTemplateEngine($templateEngine)
    {
        self::$_templateEngine = $templateEngine;
    }


    /**
     * Run template file at the given path through the Template Engine
     * The second parameter is an array of variables to be injected into the template
     *
     * @param string $templateFilePath
     * @param array $content
     * @return String
     */
    public function parseTemplate($templateFilePath, $content = array())
    {
        $template = file_get_contents($templateFilePath);
        return $this->getTemplateEngine($this->_templateEngineName)->render($template, $content);
    }

}
