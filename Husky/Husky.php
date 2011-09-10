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
     * @return void
     */
    public function execute()
    {
        $content = $this->getParser()->parseContent(APPLICATION_PATH . 'assets/content/index.md');

        $primaryNav = $this->_getPrimaryNav();

        $finalPage = $this->getTemplateEngine()->parseTemplate(
            APPLICATION_PATH . 'assets/templates/layout.html',
            array(
                 'content' => $content,
                 'primaryNav' => $primaryNav
            )
        );

        Helper\FileSystem::writeFile(APPLICATION_PATH . 'public/index.html', $finalPage);
    }

    /**
     * @return array
     */
    protected function _getPrimaryNav()
    {
        $fileInfoArray = Helper\FileSystem::getFileTree(APPLICATION_PATH . Config::CONTENT_PATH, Config::PARSER_FILE_EXTENSION);
        return $this->_navigation->buildPrimaryNavigation($fileInfoArray);
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
