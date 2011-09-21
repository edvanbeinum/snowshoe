<?php
#!/usr/bin/env php

use Husky\Config\Factory as Config;

// Run the Husky static site generator from cmd line
require_once dirname(__FILE__) . '/../Husky/bootstrap.php';


$yadif = new Yadif_Container(Config::getConfig('dic')->getDependencies());
$builder = $yadif->getComponent('Husky\Builder');
$builder->execute();
echo "Husky has run. See your new site at: \n\n", realpath(APPLICATION_PATH . Config::getConfig('app')->getPublicDirectory()), "\n";