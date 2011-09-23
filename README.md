# Snowshoe / Snowshoe

## A static site generator written in PHP

OK so PHP isn't really the most appropriate language for this. In fact it should probably be Ruby. And if it were in Ruby
then I should be using Jekyll instead. I started this because I wanted to write a small project from scratch - not using
any trendy framework, just pure coding and figuring out the best architecture.

This is really simple, aimed at geeks who want a simple blog with code samples and no whizzy things like their latest
hilarious tweets in a sidebar. And if you do, just do that with Javascript yeah?

Namespaced code using the Zend 2.0 naming conventions
http://weierophinney.net/matthew/archives/181-Migrating-OOP-Libraries-and-Frameworks-to-PHP-5.3.html

## Folders

* /assets/content - raw MD/Textile files where folder structure will be recreated on the site
* /assest/layout - the layout file, basically the second step in the two-step view process
* /public where to final site is saved to

## Install Snowshoe

Snowshoe used a few third party libraries such as a PHP Markdown parser, the textile parser, Twig template engine and Yadif dependency injection container. They are bundled with Snowshoe as git submodules. You will need to install them:

    $ git clone git@github.com:edvanbeinum/snowshoe.git
    $ cd snowshoe
    $ git submodules init
    $ git submodules update


## To run Snowshow:

    $ php bin/snowshoe

## TODO


    [ ] Check that Textile is working and not just returning strings formatted with pre
    [*] Use a proper config thing for Yadif
    [*] What are we goingto do about config? Make own static Config class with array of params
    [ ] Add event observer pattern so we can hook into parts of the system: things like run LESS compiler, or publish to S3
    [ ] Need a prepare script that creates the CSS and js for the public directory?
    [*] Page Titles
    [ ] Favicon
    [*] Create Page class for page titles,


## Issues:

    [ ] How sane is the config system - accessing configs through a factory?
    [ ] I think the exception handling system is WEAK.