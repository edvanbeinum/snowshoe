<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Adapter
 */

namespace Husky\TemplateEngine;
/**
 *
 * @package Adapter
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class TwigAdapter implements Adapter\IAdapter
{

    protected $_engine;

    public function __construct()
    {
       require_once APPLICATION_PATH . 'Husky/Vendor/TemplateEngines/Twig/lib/Twig/Autoloader.php';
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_String();
        $this->_engine = new \Twig_Environment($loader);
    }

    /**
     * Converts a string written in Twig and returns HTML
     *
     * @param string $encodedString
     * @return string
     */
    public function render($encodedString)
    {
        return $this->_engine->render($encodedString);
    }
}
