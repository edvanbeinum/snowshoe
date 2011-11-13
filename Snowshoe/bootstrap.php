<?php

// Define path to application root directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)) . '/../');


require_once APPLICATION_PATH . 'Snowshoe/Vendor/Yadif/src/Yadif/Container.php';

// we're using Zend components so make sure the Zend directory is in the include path
set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/Snowshoe/Vendor'), get_include_path())));

error_reporting(E_ALL);

/**
 * converts errors into ErrorExceptions
 *
 * @throws ErrorException
 * @param $severity
 * @param $message
 * @param $filename
 * @param $lineNum
 * @return
 */
function exceptionErrorHandler($severity, $message, $filename, $lineNum) {
  if (error_reporting() == 0) {
    return;
  }
  else {
    throw new ErrorException($message, 0, $severity, $filename, $lineNum);
  }
}

set_error_handler('exceptionErrorHandler');


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
    $path = str_replace('\\', '/', $className);

    try {
        include_once APPLICATION_PATH . $path . '.php';
    } catch (ErrorException $e) {

        // since we're in an autoloader, it's more helpful to print a stacktrace since knowing that a class can't be found
        // in this method isn't very useful - we'd much rather know where to call was coming from.
        $errorMsg = "The class $className was trying to be loaded from " . (APPLICATION_PATH . $path . '.php') . " \n\n" .
                    $e->getMessage() . "\n\n" .
                    str_pad('', 30, "*") . " STRACKTRACE " . str_pad('', 30, "*") . "\n\n" .
                    $e->getTraceAsString();

        throw new \Snowshoe\Exception\ClassNotFound($errorMsg);
    }
}

spl_autoload_register('snowshoeAutoloader');