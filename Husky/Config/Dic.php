<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 18/09/2011
 * @package App
 */

namespace Husky\Config;
/**
 * config class for the Dependency Injection Container
 *
 * @package App
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Dic extends AConfig
{
    protected $_config = array(

        // Dependencies required for each class. Husky uses Yadif out of the box
        'dependencies' => array(
            'Husky\Formatter\Factory' => array('class' => 'Husky\Formatter\Factory'),
            'Husky\TemplateEngine\Factory' => array('class' => 'Husky\TemplateEngine\Factory'),
            'Husky\Helper\FileSystem' => array('class' => 'Husky\Helper\FileSystem'),
            'Husky\Helper\Navigation' => array(
                'class' => 'Husky\Helper\Navigation',
                'arguments' => array(
                    'Husky\Helper\FileSystem',
                    'Husky\Formatter\Factory'
                )
            ),
            'Husky\Builder' => array(
                'class' => 'Husky\Builder',
                'arguments' => array(
                    'Husky\Formatter\Factory',
                    'Husky\TemplateEngine\Factory',
                    'Husky\Helper\FileSystem',
                    'Husky\Helper\Navigation'
                )
            )
        )
    );
}
