<?php

// Define path to application root directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)) . '/../');


require_once APPLICATION_PATH . 'Snowshoe/Vendor/Yadif/src/Yadif/Container.php';


/**
 * Dead simple autoloader that transforms a namespaced class name into a path and then loads it
 *
 * @param  string $className
 * @return void
 * @throws ErrorException
 */
function snowshoeAutoloader($className)
{
    // Only autoload Classes in the Snowshoe namespace. Other classes will need to be loaded using require_once manually
    if (strpos($className, 'Snowshoe') === FALSE) {
        return;
    }
    $className = str_replace('\\', '/', $className);

    try {
        include_once APPLICATION_PATH . $className . '.php';
    } catch (Exception $e) {

        // since we're in an autoloader, it's more helpful to print a stacktrace since knowing that a class can't be found
        // in this method isn't very useful - we'd much rather know where to call was coming from.
        $errorMsg = $e->getMessage() . "\n\n" .
                    str_pad('', 30, "*") . " STRACKTRACE " . str_pad('', 30, "*") . "\n\n" .
                    $e->getTraceAsString();

        throw new ErrorException($errorMsg);
    }
}

spl_autoload_register('snowshoeAutoloader');