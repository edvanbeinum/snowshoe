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
     * Templating Engine
     * @var \Husky\TemplateEngine
     */
    protected $_templateEngine;

    /**
     * Name of the Content Parser
     * @var \Husky\Parser
     */
    protected $_parser;

    /**
     * @var \Husky\Helper\Navigation
     */
    protected $_navigation;

    /**
     * Construct this sucker
     *
     * @todo Use DI for managing dependencies
     * @void
     */
    public function __construct()
    {
        $this->_parser = new Parser\Parser(Config::PARSER);
        $this->_templateEngine = new TemplateEngine\TemplateEngine(Config::TEMPLATING_ENGINE);
        $this->_navigation = new Helper\Navigation($this->_parser);
    }

    /**
     * Executes the build process
     * 
     * @return void
     */
    public function execute()
    {
        $fileInfoArray = Helper\FileSystem::getFileTree(APPLICATION_PATH . Config::CONTENT_PATH, Config::PARSER_FILE_EXTENSION);
        var_dump($fileInfoArray);
        $primaryNav = $this->_navigation->getPrimaryNavigation($fileInfoArray);

        foreach ($fileInfoArray as $contentFile) {

            $content = $this->getParser()->parseContent($contentFile);

            $finalPage = $this->getTemplateEngine()->parseTemplate(
                APPLICATION_PATH . Config::TEMPLATE_PATH . 'layout.html',
                array(
                     'content' => $content,
                     'primaryNav' => $primaryNav
                )
            );
            $publicFilePath = \Husky\Helper\Navigation::getPublicFilePath($contentFile->getPathname());
            var_dump($publicFilePath);
            Helper\FileSystem::writeFile($publicFilePath, $finalPage);
        }
    }


    /**
     * @param string $template
     */
    public function setTemplateEngine($template)
    {
        $this->_templateEngine = $template;
    }

    /**
     *
     * @return string
     *
     * @todo implement getter injection
     */
    public function getTemplateEngine()
    {
        return $this->_templateEngine;
    }

    /**
     * @param string $parser
     */
    public function setParser($parser)
    {
        $this->_parser = $parser;
    }

    /**
     *
     * @return string
     *
     * @todo implement getter injection
     */
    public function getParser()
    {
        return $this->_parser;
    }


}
