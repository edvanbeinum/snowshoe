<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\Config;
/**
 * Class for setting and getting application configuration
 *
 * @package Snowshoe
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

        // Dependencies required for each class. Snowshoe uses Yadif out of the box
        'dependencies' => array(
            'Snowshoe\Config\App' => array('Snowshoe\Config\App'),
            'Snowshoe\Formatter\Factory' => array('class' => 'Snowshoe\Formatter\Factory'),
            'Snowshoe\TemplateEngine\Factory' => array('class' => 'Snowshoe\TemplateEngine\Factory'),
            'Snowshoe\Helper\FileSystem' => array('class' => 'Snowshoe\Helper\FileSystem'),
            'Snowshoe\Helper\Page' => array(
                'class' => 'Snowshoe\Helper\Page',
                'arguments' => array(
                    'Snowshoe\Formatter\Factory',
                    'Snowshoe\Config\App'
                )
            ),
            'Snowshoe\Helper\Navigation' => array(
                'class' => 'Snowshoe\Helper\Navigation',
                'arguments' => array(
                    'Snowshoe\Helper\FileSystem',
                    'Snowshoe\Helper\Page',
                    'Snowshoe\Config\App'
                )
            ),
            'Snowshoe\Builder' => array(
                'class' => 'Snowshoe\Builder',
                'arguments' => array(
                    'Snowshoe\Formatter\Factory',
                    'Snowshoe\TemplateEngine\Factory',
                    'Snowshoe\Helper\FileSystem',
                    'Snowshoe\Helper\Navigation',
                    'Snowshoe\Helper\Page',
                    'Snowshoe\Config\App'
                )
            )
        )
    );

}
