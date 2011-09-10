<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 10/09/2011
 * @package Navigation
 */

namespace Husky\Helper;
/**
 * Helper Class to create all Navigation elements on the site. This is really just for the main homepage table of
 * contents
 *
 * @package Navigation
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Navigation
{

    protected $_parser;

    /**
     * @param \Husky\Parser\Adapter\IAdapter $parser
     */
    public function __construct(\Husky\Parser\Adapter\IAdapter $parser)
    {
        $this->_parser = $parser;
    }
    /**
     * Builds an associative array of links based on the contents for the Content folder.
     * This is used to generate the main table of contents
     *
     * @param array $fileInfoArray
     * @return array
     */
    public function buildPrimaryNavigation(array $fileInfoArray)
    {
        $links = array();

        /* @var $contentFileInfo splFileInfo */
        foreach ($fileInfoArray as $contentFileInfo) {
            $links[] = array(
                'href' => $contentFileInfo->getFilename(),
                'title' => self::getPageTitle($contentFileInfo->getPathname())
            );
        }
        return $links;
    }

    /**
     * Returns the first <h1> tag of a given filename. If there are no matching tags then it will attempt to
     * 'de-slugify' the filename and return that instead
     *
     * @static
     * @param string $filePath
     * @return string
     */
    public static function getPageTitle($filePath)
    {
        $contents = file($filePath, FILE_SKIP_EMPTY_LINES);
//
//        foreach ($contents as $contentLine) {
//            // does the line have an h1 tag
//        }

        return 'TEST';
    }

    protected function _getDeslugifiedString()
    {

    }
}
