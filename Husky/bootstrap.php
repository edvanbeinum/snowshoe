<?php

// Define path to application root directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)) . '/../');


/**
 * Dead simple autoloader that transforms a namespaced class name into a path and then loads it
 *
 * @param  string $className
 * @return void
 */
function huskyAutoloader($className)
{
    // Only autoload Classes in the Husky namespace. Other classes will need to be loaded using require_once manually
    if (strpos($className, 'Husky') === FALSE) {
        return;
    }
    $className = str_replace('\\', '/', $className);

    try {
        include_once APPLICATION_PATH . $className . '.php';
    } catch (Exception $e) {

        // since we're in an autoloader, it's more helpful to print a stacktrace since knowing that a class can't be found
        // in this method isn't very helpful - we'd much rather know where to call was coming from.
        $errorMsg = $e->getMessage() . "\n\n" .
                    str_pad('', 30, "*") . " STRACKTRACE " . str_pad('', 30, "*") . "\n\n" .
                    $e->getTraceAsString();
        
        throw new ErrorException($errorMsg);
    }
}

spl_autoload_register('huskyAutoloader');

// Ensure library/ is on include_path
//set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/lib'), get_include_path())));