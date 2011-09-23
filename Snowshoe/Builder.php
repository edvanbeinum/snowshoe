<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 17/09/2011
 * @package Builder
 */
namespace Snowshoe;
use \Snowshoe\Config\Factory as Config;

/**
 * this is where the action happens
 * The Builder class pulls together all the elements of the system and gets them to play nicely together
 *
 *
 * @package Builder
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Builder
{

    /**
     * Class variable to hold the Formatter object
     *
     * @var Snowshoe\Formatter\AAdapter
     */
    protected $_formatter;

    /**
     * Class variabel to hold the TemplateEngine object
     *
     * @var TemplateEngine\AAdapter
     */
    protected $_templateEngine;


    /**
     * Class variable to hold the FileSystem Object
     *
     * @var Helper\FileSystem
     */
    protected $_fileSystem;

    /**
     * Class variable to hold the Navigation Helper object
     *
     * @var Helper\Navigation
     */
    protected $_navigation;
    /**
     * Class variable to hold the Page helper object
     *
     * @var Helper\Page
     */
    protected $_page;

    /**
     * Absolute path to the content Directory (where the raw content files are)
     *
     * @var string
     */
    protected $_contentDirectory;

    /**
     * Absolute path to the template layout file
     *
     * @var string
     */
    protected $_templatePath;

    /**
     * Absolute path to the public directory
     *
     * @var string
     */
    protected $_publicDirectory;

    /**
     * Construct this sucker
     *
     * @param Formatter\Factory $formatterFactory
     * @param TemplateEngine\Factory $templateEngineFactory
     * @param Helper\FileSystem $fileSystem
     * @param Helper\Navigation $navigation
     * @param Helper\Page $page
     */
    public function __construct(
        \Snowshoe\Formatter\Factory $formatterFactory,
        \Snowshoe\TemplateEngine\Factory $templateEngineFactory,
        \Snowshoe\Helper\FileSystem $fileSystem,
        \Snowshoe\Helper\Navigation $navigation,
        \Snowshoe\Helper\Page $page
    )
    {
        $this->_formatter = $formatterFactory->getFormatter(Config::getConfig('app')->getFormatter());
        $this->_templateEngine = $templateEngineFactory->getTemplateEngine(Config::getConfig('app')->getTemplateEngine());
        $this->_fileSystem = $fileSystem;
        $this->_navigation = $navigation;
        $this->_page = $page;

        $this->_contentDirectory = APPLICATION_PATH . Config::getConfig('app')->getContentDirectory();
        $this->_templatePath = APPLICATION_PATH . Config::getConfig('app')->getTemplatePath();
        $this->_publicDirectory = APPLICATION_PATH . Config::getConfig('app')->getPublicDirectory();
    }

    /**
     * This is were the public site is actually created
     *
     * @return void
     */
    public function execute()
    {

        // Get contents of Content Directory
        $contentFiles = $this->_fileSystem->getFilesInDirectory(
            $this->_contentDirectory, Config::getConfig('app')->getFormatterFileExtension()
        );
        $template = $this->_fileSystem->getFile($this->_templatePath);

        if (empty($contentFiles)) {
            echo "No files found in the content directory: ", realpath($this->_contentDirectory);
            die("\n Snowshoe has stopped");
        }

        $primaryNavigation = $this->_navigation->getPrimaryNavigation($contentFiles);

        foreach ($contentFiles as $fileInfo) {
            $content = $this->_fileSystem->getFile($fileInfo->getPathname());

            // Parse each of those content files into HMTL
            $htmlContent = $this->_formatter->execute($content);

            // Run each HTML-ized content files through the template
            $completePage = $this->_templateEngine->execute(
                $template,
                array(
                     'content' => $htmlContent,
                     'primaryNavigation' => $primaryNavigation,
                     'rootUrl' => APPLICATION_PATH . Config::getConfig('app')->getPublicDirectory(),
                     'pageTitle' => $this->_page->getPageTitle($content, $fileInfo),
                     'datePublished' => $fileInfo->getCTime()
                )
            );

            // Write page to the public directory
            $publicFilePath = $this->_page->getPublicFilePath($fileInfo->getPathname());
            $this->_fileSystem->createFile($publicFilePath, $completePage);
        }
    }
}
