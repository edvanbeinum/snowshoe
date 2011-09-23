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
 * config class for the Dependency Injection Container
 *
 * @package App
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Dic extends AConfig
{
    protected $_config = array(

        // Dependencies required for each class. Snowshoe uses Yadif out of the box
        'dependencies' => array(
            'Snowshoe\Formatter\Factory' => array('class' => 'Snowshoe\Formatter\Factory'),
            'Snowshoe\TemplateEngine\Factory' => array('class' => 'Snowshoe\TemplateEngine\Factory'),
            'Snowshoe\Helper\FileSystem' => array('class' => 'Snowshoe\Helper\FileSystem'),
            'Snowshoe\Helper\Page' => array(
                'class' => 'Snowshoe\Helper\Page',
                'arguments' => array('Snowshoe\Formatter\Factory')
            ),
            'Snowshoe\Helper\Navigation' => array(
                'class' => 'Snowshoe\Helper\Navigation',
                'arguments' => array(
                    'Snowshoe\Helper\FileSystem',
                    'Snowshoe\Helper\Page'
                )
            ),
            'Snowshoe\Builder' => array(
                'class' => 'Snowshoe\Builder',
                'arguments' => array(
                    'Snowshoe\Formatter\Factory',
                    'Snowshoe\TemplateEngine\Factory',
                    'Snowshoe\Helper\FileSystem',
                    'Snowshoe\Helper\Navigation',
                    'Snowshoe\Helper\Page'
                )
            )
        )
    );
}
