<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Husky
 */

namespace Husky;

require_once('bootstrap.php');
/**
 *
 * @package Husky
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Husky
{
    /**
     * Name of the Templating Engine
     * @var string
     */
    protected $_template;

    /**
     * Name of the parser
     * @var string
     */
    protected $_parser;

    /**
     *
     */
    public function __construct()
    {
        $this->_parser = Config::PARSER;
        $this->_template = Config::TEMPLATINGENGINE;
    }

    /**
     * Executes the build process
     * @return void
     */
    public function execute()
    {
        $this->parseContent();
        $this->parseTemplate();
    }

    /**
     * A simple Parameterized Factory method
     * Instantiates and returns an adapter object of the desired type.
     *
     * @static
     * @param $parser
     * @return Husky\TemplateEngine\Adapter\IAdapter
     */
    public static function getTemplateEngine($parser)
    {
            $className = 'Husky\TemplateEngine\Adapter\\' . $parser . 'Adapter';
            return new $className;
    }

    /**
     * @static
     * @param $parser
     * @return Husky\Parser\Adapter\IAdapter
     */
    public static function getParserEngine($parser)
    {
        $className = 'Husky\Parser\Adapter\\' . $parser . 'Adapter';
            return new $className;
    }

    public function parseTemplate()
    {
        $templateEngine = self::getTemplateEngine($this->_template);
        $template = file_get_contents(APPLICATION_PATH . 'assets/templates/layout.html');

        $parserEngine = self::getParserEngine($this->_parser);
        $rawContent = file_get_contents(APPLICATION_PATH . 'assets/content/index.md');
        $content = $parserEngine->execute($rawContent);
        

        $finalPage = $templateEngine->render($template, array('content' => $content));
        file_put_contents(APPLICATION_PATH . 'public/index.html', $finalPage);
        
        return $content;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * @param string $parser
     */
    public function setParser($parser)
    {
        $this->_parser = $parser;
    }

    /**
     * @return string
     */
    public function getParser()
    {
        return $this->_parser;
    }
}
