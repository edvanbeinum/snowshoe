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
     * Construct ahoy!
     *
     * @param FileSystem $fileSystem
     * @param Page $page
     */
    public function __construct(FileSystem $fileSystem, Page $page)
    {
        $this->_fileSystem = $fileSystem;
        $this->_page = $page;
    }

    /**
     * Takes and array of splFileInfo objects and returns an associative array of url and title for each file given
     *
     * @param array $contentFiles array of splFileInfo objects
     * @return array
     */
    public function getPrimaryNavigation(array $contentFiles)
    {
        $sortCriteria = ucwords(strtolower(Config::getConfig('app')->getNavigationSortCriteria()));
        $sortDirection = ucwords(strtolower(Config::getConfig('app')->getNavigationSortDirection()));

        $sortFunctionName = 'sort' . $sortDirection;
        $sortClass = '\Snowshoe\Helper\Sort\\' . $sortCriteria;

        // order the content files in the order specified in the config file
        usort($contentFiles, array($sortClass, $sortFunctionName));

        $primaryNavigation = array();

        foreach ($contentFiles as $fileInfo) {
            $url = $this->_page->getPublicFilePath($fileInfo->getPathname());
            $title = $this->_page->getPageTitle(
                $this->_fileSystem->getFile($fileInfo->getPathname()),
                $fileInfo->getFilename()
            );
            
            $primaryNavigation[] = array(
                'url' => $url,
                'title' => $title
            );
        }
        return $primaryNavigation;
    }
}
