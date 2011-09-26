<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 17/09/2011
 * @package Navigation
 */

namespace Snowshoe\Helper;
use \Snowshoe\Config\Factory as Config;
/**
 * Helper class that handles how the Navigation menu is built
 *
 * @package Navigation
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
     */
    public function __construct(FileSystem $fileSystem, Page $page)
    {
        $this->_fileSystem = $fileSystem;
        $this->_page = $page;
        $this->_config = Config::getConfig('app');
    }

    /**
     * Setter used for injecting a mock config object for testing
     *
     * @param \Snowshoe\Config\AConfig $config
     * @return void
     */
    public function setConfig(\Snowshoe\Config\AConfig $config)
    {
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
                'url' => $this->_getPublicFilePath($fileInfo),
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
     * Helper function that returns the public path to the file once it has been formatted and
     * published on the live site
     *
     * @param \splFileInfo $fileInfo
     * @return string
     */
    protected function _getPublicFilePath(\splFileInfo $fileInfo)
    {
        return $this->_page->getPublicFilePath($fileInfo->getPathname());
    }

    /**
     * Helper function that returns the page title for a given file.
     * It will return the content of the first <h1> or <h2> tag. If it can't find neither then
     * it returns a deslugified version of the filename
     *
     * @param \splFileInfo $fileInfo
     * @return string
     */
    protected function _getPageTitle(\splFileInfo $fileInfo)
    {
        return $this->_page->getPageTitle(
            $this->_fileSystem->getFile($fileInfo->getPathname()),
            $fileInfo->getFilename()
        );
    }

}
