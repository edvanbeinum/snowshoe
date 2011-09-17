<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package AFormatter
 */

namespace Husky\Formatter;
/**
 *
 * @package AFormatter
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
abstract class AAdapter
{

    /**
     * Takes a formatted string (in Markdown, Textile, etc) and returns an HTML version
     *
     * @abstract
     * @param string $formattedString
     * @return string
     */
    abstract public function execute($formattedString);

    /**
     * Returns the first <h1> tag of a given filename. If there are no matching tags then it will attempt to
     * use the first <h2> tag. Finally it will 'de-slugify' the filename and return that instead
     *
     * @param \splFileInfo $fileInfo
     * @return string
     */
    public function getPageTitle($filename, $fileContent)
    {
        $htmlContent = $this->execute($fileContent);
        $domDoc = new \DOMDocument();
        $domDoc->loadHTML($htmlContent);

        // suppress errors if h1 element is not found
        $title = @$domDoc->getElementsByTagName('h1')->item(0)->textContent;
        if (is_null($title)) {

            // no h1 tags found, try h2
            $title = @$domDoc->getElementsByTagName('h2')->item(0)->textContent;
        }
        if (is_null($title)) {

            // remove the file extension and just have the filename
            list($fileName) = explode('.', $filename);
            $title = $this->_getDeslugifiedString($fileName);
        }
        return $title;
    }


    /**
     * converts a slugged string (we guess something like: dashes or underscores used instead of spaces and all lowercase)
     * to a title case string
     * e.g. this-is-a-slug becomes This Is A Slug
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
