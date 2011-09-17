<?php
#!/usr/bin/env php

// Run the Husky static site generator from cmd line
require_once dirname(__FILE__) . '/../Husky/bootstrap.php';

$yadifconfig = array(
    'Husky\Formatter\Factory' => array('class' => 'Husky\Formatter\Factory'),
    'Husky\TemplateEngine\Factory' => array('class' => 'Husky\TemplateEngine\Factory'),
    'Husky\Helper\FileSystem' => array('class' => 'Husky\Helper\FileSystem'),
    'Husky\Builder\Navigation' => array('class' => 'Husky\Builder\Navigation'),
    'Husky\Builder' => array(
        'class' => 'Husky\Builder',
        'arguments' => array('Husky\Formatter\Factory', 'Husky\TemplateEngine\Factory', 'Husky\Helper\FileSystem' , 'Husky\Builder\Navigation')
    )
);

$yadif = new Yadif_Container($yadifconfig);
$builder = $yadif->getComponent('Husky\Builder');
$builder->execute();

echo "Husky has run. See your new site at: \n\n", realpath(APPLICATION_PATH . $GLOBALS['huskyConfig']->publicDirectory), "\n";