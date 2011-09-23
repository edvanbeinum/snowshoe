<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 18/09/2011
 * @package App
 */

namespace Snowshoe\Config;
/**
 *
 * @package App
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class App extends AConfig
{
    protected $_config = array(
        
        // Name of the Format type that the content is written in. Ships with Markdown or Textile
        'formatter' => 'Markdown',

        // File extension of the content files
        'formatter_file_extension' => '.md',

        // Name of the Template Engine. Ships with Twig or Mustache
        'template_engine' => 'Twig',

        // This is the file extension that wil be used on the public site
        'public_file_extension' => '.html',

        // Path, relative to Snowshoe's root folder, where the content files live
        'content_directory' => 'assets/content',

        // Path, relative to Snowshoe's root folder, where the template layout file lives
        'template_path' => 'assets/template/layout.html',

        // Path, relative to Snowshoe's root folder, where the finished public files will be written to
        'public_directory' => 'public',

        // What criteria should the navigation be sorted on? date | alpha
        'navigation_sort_criteria' => 'alpha',

        // What criteria should the navigation be sorted on? asc | desc
        'navigation_sort_direction' => 'asc',
    );

}