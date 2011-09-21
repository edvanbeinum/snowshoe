<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 17/09/2011
 * @package Navigation
 */

namespace Husky\Helper;
use \Husky\Config\Factory as Config;
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
     * @var \Husky\Formatter\Factory
     */
    protected $_formatterFactory;

    /**
     * Construct ahoy!
     *
     * @param FileSystem $fileSystem
     * @param \Husky\Formatter\Factory $formatterFactory
     */
    public function __construct(FileSystem $fileSystem, \Husky\Formatter\Factory $formatterFactory)
    {
        $this->_fileSystem = $fileSystem;
        $this->_formatterFactory = $formatterFactory;
    }

    /**
     * Takes and array of splFileInfo objects and returns an associative array of url and title for each file given
     *
     * @param array $contentFiles array of splFileInfo objects
     * @return array
     */
    public function getPrimaryNavigation(array $contentFiles)
    {
        // @TODO move 'Sorters' into a seperate class
        $sortCriteria = Config::getConfig('app')->getNavigationOrder();
        usort($contentFiles, array('\Husky\Helper\Navigation', 'sortBy' . ucwords(strtolower($sortCriteria))));

        $primaryNavigation = array();
        $formatter = $this->_formatterFactory->getFormatter(Config::getConfig('app')->getFormatter());

        foreach ($contentFiles as $fileInfo) {
            $primaryNavigation[] = array(
                'url' => $this->getPublicPath($fileInfo->getPathname()),
                'title' => $formatter->getPageTitle($fileInfo->getFilename(), $this->_fileSystem->getFile($fileInfo->getPathname()))
            );
        }
        return $primaryNavigation;
    }

    /**
     * Used by usort to order blog entries by date for the Primary Navigation
     *
     * @param $a
     * @param $b
     * @return int
     */
    public function sortByDate($a, $b)
    {
        $aDate = $a->getCTime();
        $bDate = $b->getCTime();

        if ($aDate === $bDate) {
            return 0;
        } else if ($aDate > $bDate) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Helper function that takes a path to the content directory and converts it into a path to the public directory
     * It also converts the file extension from the formatter extension to the template engine extension
     *
     * @param string $contentPath
     * @return string
     */
    public function getPublicPath($contentPath)
    {
        $publicFilePath = $this->_getPublicFilename($contentPath);
        $publicFilePath = str_replace(
            APPLICATION_PATH . Config::getConfig('app')->getContentDirectory(),
            APPLICATION_PATH . Config::getConfig('app')->getPublicDirectory(),
            $publicFilePath
        );
        return $publicFilePath;
    }

    /**
     * Helper function that converts the file extension from the formatter extension to the template engine extension
     *
     * @param $contentFilename
     * @return string
     */
    protected function _getPublicFilename($contentFilename)
    {
        return str_replace(
            Config::getConfig('app')->getFormatterFileExtension(),
            Config::getConfig('app')->getPublicFileExtension(),
            $contentFilename
        );
    }
}
