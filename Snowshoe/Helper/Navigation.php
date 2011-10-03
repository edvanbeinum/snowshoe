<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\Helper;

/**
 * Helper class that handles how the Navigation menu is built
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Navigation
{
    /**
     * Holds reference to the FilSystem helper object
     *
     * @var FileSystem
     */
    protected $_fileSystem;

    /**
     * Reference to Page helper object
     *
     * @var Page
     */
    protected $_page;

    /**
     * Reference to the config object
     *
     * @var \Snowshoe\Config\AConfig
     */
    protected $_config;

    /**
     * Construct ahoy!
     *
     * @param FileSystem $fileSystem
     * @param Page $page
     * @param \Snowshoe\Config\App $config
     */
    public function __construct(FileSystem $fileSystem, Page $page, \Snowshoe\Config\App $config)
    {
        $this->_fileSystem = $fileSystem;
        $this->_page = $page;
        $this->_config = $config;
    }

    /**
     * Takes and array of splFileInfo objects and returns an associative array of url and title for each file given
     *
     * @param array $contentFiles array of splFileInfo objects
     * @return array
     */
    public function getPrimaryNavigation(array $contentFiles)
    {
        $sortedFiles = $this->getSortedNavigation($contentFiles);

        $primaryNavigation = array();

        foreach ($sortedFiles as $fileInfo) {
            $primaryNavigation[] = array(
                'url' => $this->_getPageUrl($fileInfo),
                'title' => $this->_getPageTitle($fileInfo)
            );
        }
        return $primaryNavigation;
    }

    /**
     * Takes and array of splFileInfo objects and sorts them based on the config values for criteria and direction
     *
     * @param array $contentFiles
     * @return array
     */
    public function getSortedNavigation(array $contentFiles)
    {
        $sortCriteria = ucwords(strtolower($this->_config->getNavigationSortCriteria()));
        $sortDirection = ucwords(strtolower($this->_config->getNavigationSortDirection()));

        $sortFunctionName = 'sort' . $sortDirection;
        $sortClass = '\Snowshoe\Helper\Sort\\' . $sortCriteria;

        // order the content files in the order specified in the config file
        usort($contentFiles, array($sortClass, $sortFunctionName));
        return $contentFiles;
    }

    /**
     * Helper function that returns a Page's URL
     * 
     * This wrapper function exists so we can more easily mock the response during testing
     *
     * @param \splFileInfo $fileInfo
     * @return mixed|string
     */
    protected function _getPageUrl(\splFileInfo $fileInfo)
    {
        return $this->_page->getPageUrl($fileInfo->getPathname());
    }

    /**
     * Helper function that returns the page title for a given file.
     * It will return the content of the first <h1> or <h2> tag. If it can't find neither then
     * it returns a deslugified version of the filename
     * It also checks for the homepage - it will return 'Home' for a file in the base content directory and called 'index'
     *
     *
     * @param \splFileInfo $fileInfo
     * @return string
     */
    protected function _getPageTitle(\splFileInfo $fileInfo)
    {
        $homepagePath = APPLICATION_PATH . $this->_config->getContentDirectory() . '/index' . $this->_config->getFormatterFileExtension();
        if (strpos($homepagePath, $fileInfo->getPathname()) === 0) {
            return 'Home';
        }

        return $this->_page->getPageTitle(
            $this->_fileSystem->getFile($fileInfo->getPathname()),
            $fileInfo->getFilename()
        );
    }

}
