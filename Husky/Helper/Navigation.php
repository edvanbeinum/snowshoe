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
     * @param \Husky\Parser\Parser $parser
     */
    public function __construct(\Husky\Parser\Parser $parser)
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
    public function getPrimaryNavigation(array $fileInfoArray)
    {
        $links = array();

        /* @var $contentFileInfo splFileInfo */
        foreach ($fileInfoArray as $contentFileInfo) {
            $links[] = array(
                'href' => str_replace(\Husky\Config::PARSER_FILE_EXTENSION, 'html', $contentFileInfo->getFilename()),
                'title' => $this->getPageTitle($contentFileInfo)
            );
        }
        return $links;
    }

    /**
     * Returns the first <h1> tag of a given filename. If there are no matching tags then it will attempt to
     * 'de-slugify' the filename and return that instead
     *
     * @static
     * @param splFileInfo $fileInfo
     * @return string
     */
    public function getPageTitle($fileInfo)
    {
        $htmlContent = $this->_parser->parseContent($fileInfo->getPathname());
        $domDoc = new \DOMDocument();
        $domDoc->loadHTML($htmlContent);

        // suppress errors if h1 element is not found
        $title = @$domDoc->getElementsByTagName('h1')->item(0)->textContent;
        if(is_null($title)) {

            // remove the file extension and just have the filename
            list($fileName) = explode('.', $fileInfo->getFilename());
            $title = $this->_getDeslugifiedString($fileName);
        }
        return $title;

    }

    protected function _getDeslugifiedString($sluggedString)
    {
        $desluggedString = str_replace(array('-', '_'), ' ', $sluggedString);
        return ucwords($desluggedString);
    }
}
