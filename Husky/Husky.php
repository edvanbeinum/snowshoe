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
    protected $_templatingEngineName;

    /**
     * Name of the Content Parser
     * @var string
     */
    protected $_parser;

    /**
     *
     */
    public function __construct()
    {
        $this->_parser = Config::PARSER;
        $this->_templatingEngineName = Config::TEMPLATINGENGINE;
    }

    /**
     * Executes the build process
     * @return void
     */
    public function execute()
    {
        $content = $this->parseContent(APPLICATION_PATH . 'assets/content/index.md');
        $finalPage = $this->parseTemplate(
            APPLICATION_PATH . 'assets/templates/layout.html',
            array(
                 'content' => $content,
                 'links' => $this->_buildLinks()
            )
        );

        Helper\FileSystem::writeFile(APPLICATION_PATH . 'public/index.html', $finalPage);
    }

    /**
     * A simple Parameterized Factory method
     * Instantiates and returns an adapter object of the desired type.
     *
     * @static
     * @param $parser
     * @return \Husky\TemplateEngine\Adapter\IAdapter
     */
    public static function getTemplateEngine($parser)
    {
        $className = 'Husky\TemplateEngine\Adapter\\' . $parser . 'Adapter';
        return new $className;
    }

    /**
     * @static
     * @param $parser
     * @return \Husky\Parser\Adapter\IAdapter
     */
    public static function getParserEngine($parser)
    {
        $className = 'Husky\Parser\Adapter\\' . $parser . 'Adapter';
        return new $className;
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
        return self::getTemplateEngine($this->_templatingEngineName)->render($template, $content);
    }

    /**
     * Run the content at the given file path through the parser
     *
     * @param $contentFilePath
     * @return String
     */
    public function parseContent($contentFilePath)
    {

        $rawContent = file_get_contents($contentFilePath);
        return self::getParserEngine($this->_parser)->execute($rawContent);
    }

    /**
     * @param string $template
     */
    public function setTemplatingEngineName($template)
    {
        $this->_templatingEngineName = $template;
    }

    /**
     * @return string
     */
    public function getTemplatingEngineName()
    {
        return $this->_templatingEngineName;
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

    /**
     * Builds an associative array of links based on the contents for the Content folder.
     * This is used to generate the links sidebar
     *
     * @return array
     */
    protected function _buildLinks()
    {
        $links = array();
        $contentArray = \Husky\Helper\FileSystem::getFileTree(APPLICATION_PATH . Config::CONTENT_PATH);
        var_dump(APPLICATION_PATH . Config::CONTENT_PATH);
        /* @var $contentFileInfo splFileInfo */
        foreach ($contentArray as $contentFileInfo) {
            $links[] = array(
                'href' => $contentFileInfo->getFilename(),
                'title' => 'TEST'
            );
        }
        var_dump($links);
        return $links;
    }

}
