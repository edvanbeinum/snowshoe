<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 17/09/2011
 * @package Builder
 */
namespace Husky;

/**
 * this is where the action happens
 * The Builder class pulls together all the elements of the system and gets them to play nicely together
 *
 *
 * @package Builder
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Builder
{

    /**
     * Class variable to hold the Formatter object
     *
     * @var Husky\Formatter\AAdapter
     */
    protected $_formatter;

    /**
     * Class variabel to hold the TemplateEngine object
     *
     * @var Husky\TemplateEngine\AAdapter
     */
    protected $_templateEngine;


    /**
     * Class variable to hold the FileSystem Object
     *
     * @var \Husky\Husky\Helper\FileSystem
     */
    protected $_fileSystem;

    /**
     * Class variable to hold the Navigation object
     *
     * @var Husky\Builder\Navigation
     */
    protected $_navigation;

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
     * @param Builder\Navigation $navigation
     */
    public function __construct(
        \Husky\Formatter\Factory $formatterFactory,
        \Husky\TemplateEngine\Factory $templateEngineFactory,
        \Husky\Helper\FileSystem $fileSystem,
        \Husky\Builder\Navigation $navigation
    )
    {
        $this->_formatter = $formatterFactory->getFormatter($GLOBALS['huskyConfig']->formatter);
        $this->_templateEngine = $templateEngineFactory->getTemplateEngine($GLOBALS['huskyConfig']->templateEngine);
        $this->_fileSystem = $fileSystem;
        $this->_navigation = $navigation;

        $this->_contentDirectory = APPLICATION_PATH . $GLOBALS['huskyConfig']->contentDirectory;
        $this->_templatePath = APPLICATION_PATH . $GLOBALS['huskyConfig']->templatePath;
        $this->_publicDirectory = APPLICATION_PATH . $GLOBALS['huskyConfig']->publicDirectory;
    }

    /**
     * This is were the public site is actually created
     *
     * @return void
     */
    public function execute()
    {

        // Get contents of Content Directory
        $rawContents = $this->_fileSystem->getFilesInDirectory(
            $this->_contentDirectory, $GLOBALS['huskyConfig']->formatterFileExtension
        );
        $template = $this->_fileSystem->getFile($this->_templatePath);

        if (empty($rawContents)) {
            echo "No files found in the content directory: ", realpath($this->_contentDirectory);
            die("\n Husky has stopped");
        }

        $primaryNavigation = $this->_navigation->getPrimaryNavigation($rawContents);

        foreach ($rawContents as $fileInfo) {
            echo "Getting ", $fileInfo->getPathname(), "\n";
            $content = $this->_fileSystem->getFile($fileInfo->getPathname());

            // Parse each of those content files into HMTL
            $htmlContent = $this->_formatter->execute($content);

            // Run each HTML-ized content files through the template
            $completePage = $this->_templateEngine->execute(
                $template,
                array(
                     'content' => $htmlContent,
                     'primaryNavigation' => $primaryNavigation,
                     'rootUrl' => APPLICATION_PATH . $GLOBALS['huskyConfig']->publicDirectory,
                     'datePublished' => $fileInfo->getCTime()
                )
            );

            // Write page to the public directory
            $publicFilePath = $this->_navigation->getPublicPath($fileInfo->getPathname());

            echo "Writing new file: ", realpath($publicFilePath), "\n";
            $this->_fileSystem->createFile($publicFilePath, $completePage);
        }
    }
}
