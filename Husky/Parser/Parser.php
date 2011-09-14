<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 10/09/2011
 * @package Parser
 */

namespace Husky\Parser;
/**
 *
 * @package Parser
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Parser
{

    protected $_parserName;

    protected static $_parser;

    /**
     * Pass in the name of the Parser to be used.
     * Defaults ot 'Markdown'
     *
     * @param string $parserName
     */
    public function __construct($parserName = 'Markdown')
    {
        $this->_parserName = $parserName;
    }

    /**
    * @return \Husky\Parser\Adapter\IAdapter
     */
    public function getParserEngine()
    {
        if (!is_null(self::$_parser)) {
            return self::$_parser;
        }
        $className = 'Husky\Parser\Adapter\\' . $this->_parserName;
        return new $className;
    }

    public function setParserEngine($parser)
    {
        self::$_parser = $parser;
    }

    /**
     * Run the content at the given file path through the parser
     *
     * @param $contentFilePath
     * @return String
     */
    public function parseContent($contentFilePath)
    {

        $rawContent = file_get_contents($contentFilePath);
        return $this->getParserEngine()->execute($rawContent);
    }

     /**
     * Returns the first <h1> tag of a given filename. If there are no matching tags then it will attempt to
     * 'de-slugify' the filename and return that instead
     *
     * @static
     * @param \splFileInfo $fileInfo
     * @return string
     */
    public function getPageTitle($fileInfo)
    {
        $htmlContent = $this->parseContent($fileInfo->getPathname());
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

