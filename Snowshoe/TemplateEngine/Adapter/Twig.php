<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 15/09/2011
 * @package Snowshoe
 */
namespace Snowshoe\TemplateEngine\Adapter;

/**
 * Markdown Formatter Adapter. This class knows how to interact with the MArkdown library
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
class Twig extends \Snowshoe\TemplateEngine\AAdapter
{

    public function __construct()
    {
        require_once APPLICATION_PATH . 'Snowshoe/Vendor/TemplateEngines/twig/lib/Twig/Autoloader.php';
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_String();

        // Turn auto escaping off because we will be passing HTML Entites as variables as the output of the parsed MD files
        $this->_templateEngine = new \Twig_Environment($loader, array('autoescape' => FALSE));
    }

    /**
     * Takes a templated string and the variables to be injected and returns the result
     *
     * @param string $templateString
     * @param array $templateVars
     * @return string
     */
    public function execute($templateString, array $templateVars = array())
    {
        return $this->_templateEngine->render($templateString, $templateVars);
    }

}
