<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Config
 */


namespace Husky;
/**
 * Simple Config class that holds Husky's configurabvle options as class constants
 *
 * @package Husky
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
final class Config
{

    /**
     *  Which templating engine are we using. Husky ships with Twig or Mustache
     *
     * @var string
     */
    const TEMPLATINGENGINE = 'Twig';

    /**
     * Which text parser are we using. Husky ships with Markdown only
     *
     * @var string
     */
    const PARSER = 'Markdown';

    /**
     * Path, relative to APPLICATION_PATH, to the content files
     *
     * @var string
     */
    const CONTENT_PATH = 'assets/content';

    /**
     * Path, relative to APPLICATION_PATH, to the template files
     */
    const TEMPLATE_PATH = 'assets/templates';


}
