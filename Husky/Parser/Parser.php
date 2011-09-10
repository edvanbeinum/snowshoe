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

    public function __construct($parserName)
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
}
