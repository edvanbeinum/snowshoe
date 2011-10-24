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
    protected static $_config = array(

        // In production mode, URLs will have the publidsh_location value prepended to them. Otherwise they
        // will have the public_directory. You can switch to production mode by using the -p flag on the command line
        'is_production_mode' => FALSE,

        // The name of the site - used for page title. It will appear after the page title in the browser wondow  e.g: About | Site Name
        'site_name' => 'Snowshoe',

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

        // Path, relative to Snowshoe's root folder, where the finished files will be written to
        'public_directory' => 'public',

        // The URL of the live site where the files in the publish directory will be available at
        // This can be an absolute filepath too
        // This location will be prepended to links in the navigation and will only be used with -p flag
        'publish_location' => 'http://getsnowshoe.com',

        // What criteria should the navigation be sorted on? date | alpha
        'navigation_sort_criteria' => 'alpha',

        // What criteria should the navigation be sorted on? asc | desc
        'navigation_sort_direction' => 'desc',

        // For auto-publishing the site, these contains the API credentials for Amazon
        // if true, then wehen snowshoe is run with the -p flag (i.e. is in production mode) then the generated site
        // will be uploaded to the following publisher
        'is_auto_publish' => TRUE,
        'publisher' => 'S3', // more services to be added in due course
        's3_key' => 'YOUR_KEY',
        's3_secret_key' => 'YOUR_SECRET_KEY',
        's3_bucket_name' => 'BUCKET_NAME',

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
            'Snowshoe\Publisher\Factory' => array(
                'class' => 'Snowshoe\Publisher\Factory',
                'arguments' => array(
                    'Snowshoe\Config\App'
                )
            ),
            'Snowshoe\Builder' => array(
                'class' => 'Snowshoe\Builder',
                'arguments' => array(
                    'Snowshoe\Formatter\Factory',
                    'Snowshoe\TemplateEngine\Factory',
                    'Snowshoe\Publisher\Factory',
                    'Snowshoe\Helper\FileSystem',
                    'Snowshoe\Helper\Navigation',
                    'Snowshoe\Helper\Page',
                    'Snowshoe\Config\App'
                )
            )
        )
    );

}
