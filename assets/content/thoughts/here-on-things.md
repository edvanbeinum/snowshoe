# Slim Framework for PHP 5

Thank you for choosing the Slim Framework, a micro framework for PHP 5 inspired by [Sinatra](http://sinatrarb.com) released under the MIT public license.

## Features

The Slim Framework for PHP 5 provides the following notable features out-of-the-box:

* Clean and simple DSL for writing powerful web applications
* HTTP routing
  * Supports all standard and custom HTTP request methods
  * Named routes w/ `urlFor()` helper
  * Route passing
  * Route redirects
  * Route halting
  * Custom **Not Found** handler
  * Custom **Error** handler
  * Optional route segments... /archive(/:year(/:month(/:day)))
* Easy app configuration
* Easy templating with custom Views (ie. Twig, Smarty, Mustache, ...)
* Secure sessions
* Signed cookies with AES-256 encryption
* Flash messaging
* HTTP caching (ETag and Last-Modified)
* Logging
* Error and Exception handling
* Supports PHP 5+

## "Hello World" application (PHP 5 >= 5.3)

The Slim Framework for PHP 5 supports anonymous functions. This is the preferred method of defining Slim application routes.

    <?php
    require 'Slim/Slim.php';
    $app = new Slim();
    $app->get('/hello/:name', function ($name) {
        echo "Hello, $name!";
    });
    $app->run();
    ?>