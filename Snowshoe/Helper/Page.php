<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\Helper;

/**
 * Class that deals with Page-level functionality, such as getting the Page title
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Page
{
    /**
     * @var \Snowshoe\Formatter\Factory
     */
    protected $_formatterFactory;
    
    /**
     * @var \Snowshoe\Config\App\Snowshoe\Config\App $config
     */
    protected $_config;

    /**
     * Constructor ahoy
     *
     * @param \Snowshoe\Formatter\Factory $formatterFactory
     * @param \Snowshoe\Config\App $config
     */
    public function __construct(\Snowshoe\Formatter\Factory $formatterFactory, \Snowshoe\Config\App $config)
    {
        $this->_formatterFactory = $formatterFactory;
        $this->_config = $config;
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
        $formatter = $this->_formatterFactory->getFormatter($this->_config->getFormatter());

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
            if ($filename instanceof \splFileInfo) {
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
     * @todo add functionality to deal with the public Directory being a domain
     *
     * @param string $contentPath
     * @return string
     */
    public function getPublicFilePath($contentPath)
    {
        $publicFilePath = $this->getPublicFilename($contentPath);
        $publicFilePath = str_replace(
            APPLICATION_PATH . $this->_config->getContentDirectory(),
            APPLICATION_PATH . $this->_config->getPublicDirectory(),
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
            $this->_config->getFormatterFileExtension(),
            $this->_config->getPublicFileExtension(),
            $contentFilename
        );
    }
}
