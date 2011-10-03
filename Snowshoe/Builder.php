<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */
namespace Snowshoe;

/**
 * This is where the action happens
 * The Builder class pulls together all the elements of the system and gets them to play nicely together
 *
 *
 * @package Snowshoe
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
     * Class variable that holds the config object
     *
     * @var \Snowshoe\Config\App
     */
    protected $_config;

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
     * @param Config\App $config
     */
    public function __construct(
        \Snowshoe\Formatter\Factory $formatterFactory,
        \Snowshoe\TemplateEngine\Factory $templateEngineFactory,
        \Snowshoe\Helper\FileSystem $fileSystem,
        \Snowshoe\Helper\Navigation $navigation,
        \Snowshoe\Helper\Page $page,
        \Snowshoe\Config\App $config
    )
    {
        $this->_config = $config;
        $this->_formatter = $formatterFactory->getFormatter($this->_config->getFormatter());
        $this->_templateEngine = $templateEngineFactory->getTemplateEngine($this->_config->getTemplateEngine());
        $this->_fileSystem = $fileSystem;
        $this->_navigation = $navigation;
        $this->_page = $page;

        $this->_contentDirectory = APPLICATION_PATH . $this->_config->getContentDirectory();
        $this->_templatePath = APPLICATION_PATH . $this->_config->getTemplatePath();
        $this->_publicDirectory = APPLICATION_PATH . $this->_config->getPublicDirectory();
    }

    /**
     * This is were the public site is actually created
     *
     * @return void
     */
    public function execute()
    {

        // Get file in the Content Directory
        $contentFiles = $this->_getContentFiles();
        $template = $this->_fileSystem->getFile($this->_templatePath);

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
                     'rootUrl' => $this->_getRootUrl(),
                     'pageTitle' => $this->_page->getPageTitle($content, $fileInfo),
                     'siteName' => $this->_config->getSiteName(),
                     'datePublished' => $fileInfo->getCTime()
                )
            );

            // Write page to the public directory
            $publicFilePath = $this->_page->getPublicFilePath($fileInfo->getPathname());
            $this->_fileSystem->createFile($publicFilePath, $completePage);
        }
    }

    /**
     * Get the root URL depending on whether we are in production mode or not
     *
     * @return string
     */
    protected function _getRootUrl()
    {
        $rootUrl = APPLICATION_PATH . $this->_config->getPublicDirectory();
        if ($this->_config->getIsProductionMode()) {
            $rootUrl = $this->_config->getPublishLocation();
        }
        return $rootUrl;
    }

    /**
     * Return array of splFileInfo objects from the content directory
     *
     * @return array
     */
    protected function _getContentFiles()
    {
        $contentFiles = $this->_fileSystem->getFilesInDirectory(
            $this->_contentDirectory, $this->_config->getFormatterFileExtension()
        );

        if (empty($contentFiles)) {
            echo "No files found in the content directory: ", realpath($this->_contentDirectory);
            die("\n Snowshoe has stopped");
        }
        return $contentFiles;
    }
}
