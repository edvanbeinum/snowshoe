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
 * @package Adapter
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class MustacheAdapter implements IAdapter{
    
    protected $_engine;

    public function __construct()
    {
        require_once APPLICATION_PATH .  '/Vendor/TemplateEngines/Mustache/mustache.php';
        $this->_engine = new Mustache;
    }

    public function render($encodedString)
    {
        return $this->_engine->render($encodedString);
    }
}
