<?php
/**
 * 
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/09/2011
 * @package MarkdownAdapter 
 */
 
 namespace Husky\Parser\Adapter;
 /**
 * 
 * @package MarkdownAdapter
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Markdown implements IAdapter {

    /**
     * @var Markdown_Parser
     */
    protected $_parseEngine;

    public function __construct()
    {
        require_once APPLICATION_PATH . 'Husky/Vendor/Parsers/Markdown/markdown.php';

        $this->_parseEngine = new \Markdown_Parser;
    }

    /**
     * Runs the Parser Engine on the given $content and returns the parsed result
     *
     * @param $content
     * @return string
     */
    public function execute($content)
    {
        return $this->_parseEngine->transform($content);
    }


}
