<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 22/09/2011
 * @package Page
 */

namespace Snowshoe\Helper;
use \Snowshoe\Config\Factory as Config;
/**
 * Class that deals with Page-level functionaity, such as getting the Page title
 *
 * @package Page
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Page
{
    /**
     * @var \Snowshoe\Formatter\Factory
     */
    protected $_formatterFactory;

    public function __construct(\Snowshoe\Formatter\Factory $formatterFactory)
    {
        $this->_formatterFactory = $formatterFactory;
    }

    /**
     * Returns the first <h1> tag of a given filename. If there are no matching tags then it will attempt to
     * use the first <h2> tag. Finally it will de-slugify the filename and return that instead
     *
     * @param string $fileContent
     * @param string | splFileInfo $filename
     * @return string
     */
    public function getPageTitle($fileContent, $filename)
    {
        $formatter = $this->_formatterFactory->getFormatter(Config::getConfig('app')->getFormatter());

        $htmlContent = $formatter->execute($fileContent);
        $domDoc = new \DOMDocument();
        $domDoc->loadHTML($htmlContent);

        // suppress errors if h1 element is not found
        $title = @$domDoc->getElementsByTagName('h1')->item(0)->textContent;
        if (is_null($title)) {

            // no h1 tags found, try h2
            $title = @$domDoc->getElementsByTagName('h2')->item(0)->textContent;
        }

        // Looks like no h1 or h2 tags so grab the filename and deslugify it
        if (is_null($title)) {
            if ($filename instanceof splFileInfo) {
                $filename = $filename->getFilename();
            }
            // remove the file extension and just have the filename
            list($cleanFilename) = explode('.', $filename);
            $title = String::getDeslugified($cleanFilename);
        }
        return $title;
    }

    /**
     * Helper function that takes a path to the content directory and converts it into a path to the public directory
     * It also converts the file extension from the formatter extension to the template engine extension
     *
     * @param string $contentPath
     * @return string
     */
    public function getPublicFilePath($contentPath)
    {
        $publicFilePath = $this->getPublicFilename($contentPath);
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
    public function getPublicFilename($contentFilename)
    {
        return str_replace(
            Config::getConfig('app')->getFormatterFileExtension(),
            Config::getConfig('app')->getPublicFileExtension(),
            $contentFilename
        );
    }
}
