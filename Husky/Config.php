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
    const TEMPLATING_ENGINE = 'Twig';

    const TEMPLATING_ENGINE_FILE_EXTENSION = 'html';

    /**
     * Which text parser are we using. Husky ships with Markdown only
     *
     * @var string
     */
    const PARSER = 'Markdown';

    const PARSER_FILE_EXTENSION = 'md';

    /**
     * Path, relative to APPLICATION_PATH, to the content files
     *
     * @var string
     */
    const CONTENT_PATH = 'assets/content/';

    /**
     * Path, relative to APPLICATION_PATH, to the template files
     */
    const TEMPLATE_PATH = 'assets/templates/';

    const PRODUCTION_MODE = FALSE;

    /**
     * The path to the pubic directory as seen by the published site. This can be an absolute path for local dev
     * or a URL or left empty and the links on the site wll be created relative
     */
    const ROOT_URL = '/Users/evanbeinum/Dropbox/sites/personal/ubuntuhost/husky/public/';


}
