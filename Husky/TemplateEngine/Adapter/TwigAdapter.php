<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package Adapter
 */

namespace Husky\TemplateEngine\Adapter;
/**
 *
 * @package Husky
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class TwigAdapter implements IAdapter
{

    protected $_engine;

    public function __construct()
    {
       require_once APPLICATION_PATH . 'Husky/Vendor/TemplateEngines/Twig/lib/Twig/Autoloader.php';
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_String();

        // Turn auto escaping off because we will be passing HTML Entites as variables as the output of the parsed MD files
        $this->_engine = new \Twig_Environment($loader, array('autoescape' => FALSE));
    }

    /**
     * Converts a string written in Twig and returns HTML
     *
     * @param string $encodedString
     * @param array $vars
     * @return string
     */
    public function render($encodedString, array $vars = array())
    {
        return $this->_engine->render($encodedString, $vars);
    }
}
