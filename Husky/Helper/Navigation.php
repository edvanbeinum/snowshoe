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
     * @param array $fileInfoArray array of splFileInfo objects
     * @return array
     */
    public function getPrimaryNavigation(array $fileInfoArray)
    {
        $links = array();

        /* @var $contentFileInfo splFileInfo */
        foreach ($fileInfoArray as $contentFileInfo) {
            $links[] = array(
                'url' => self::getUrlFromFilePath($contentFileInfo->getPathname()),
                'title' => $this->getPageTitle($contentFileInfo)
            );
        }
        return $links;
    }

    /**
     * Takes the name of a content file and returns the public-facing filename
     * e.g. If you are using Markdown and have html files,  about.md becomes about.html
     *
     * @static
     * @param $contentFilename
     * @return string
     */
    public static function getPublicFilename($contentFilename)
    {
        return str_replace(\Husky\Config::PARSER_FILE_EXTENSION, 'html', $contentFilename);
    }


    /**
     * Replaces occurences of the PArser file extension with the Public file extension and repaces the asset/content
     * directory with the public directory
     *
     * @static
     * @param $filePath
     * @return mixed
     */
    public static function getPublicFilePath($filePath)
    {
        $publicFilePath = self::getPublicFilename($filePath);
        return str_replace(APPLICATION_PATH . \Husky\Config::CONTENT_PATH, APPLICATION_PATH . 'public/', $publicFilePath);
    }

    /**
     * This takes a full path to a content file and returns a string suitable for use in the public/ directory
     * and also replaces the parser extension type with html
     *
     * @static
     * @param string $filePath
     * @param null|string $rootUrl an optional arg, uses the Config value if not set
     * @return string
     */
    public static function getUrlFromFilePath($filePath, $rootUrl = NULL)
    {
        if (is_null($rootUrl)) {
            $rootUrl = \Husky\Config::ROOT_URL;
        }

        $url = self::getPublicFilename($filePath);

        if ($rootUrl) {
            $needle = APPLICATION_PATH . \Husky\Config::CONTENT_PATH;
            $replacement = $rootUrl;
            return str_replace($needle, $replacement, $url);
        }
        else {

            // return relative URL
            $needle = APPLICATION_PATH . rtrim(\Husky\Config::CONTENT_PATH, '/');
            $replacement = '';
            return str_replace($needle, $replacement, $url);
        }
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

        // suppress errors if h1 element is not found becuase then we will use the deslugged filename instead
        $title = @$domDoc->getElementsByTagName('h1')->item(0)->textContent;
        if (is_null($title)) {

            // remove the file extension and just have the filename
            list($fileName) = explode('.', $fileInfo->getFilename());
            $title = $this->_getDeslugifiedString($fileName);
        }
        return $title;
    }


    /**
     * converts a slugged string (we guess something like: dashes or underscores used instead of spaces and all lowercase)
     * to a title case string
     * e.g. this-is-a-slug become This Is A Slug
     *
     * @param $sluggedString
     * @return string
     */
    protected function _getDeslugifiedString($sluggedString)
    {
        $desluggedString = str_replace(array('-', '_'), ' ', $sluggedString);
        return ucwords($desluggedString);
    }
}
