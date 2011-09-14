# Husky / Snowshoe

## A static site generator written in PHP

OK so PHP isn't really the most appropriate language for this. In fact it should probably be Ruby. And if it were in Ruby
then I should be using Jekyll instead. I started this because I wanted to write a small project from scratch - not using
any trendy framework, just pure coding and figuring out the best architecture.

This is really simple, aimed at geeks who want a simple blog with code samples and no whizzy things like their lastest
hilarious tweets in a sidebar. And if you do, just do that with Javascript yeah?

Namespaced code using the Zend 2.0 naming conventions
http://weierophinney.net/matthew/archives/181-Migrating-OOP-Libraries-and-Frameworks-to-PHP-5.3.html

Naming Conventions

Folders

/assets - raw MD/Textile files where folder structure will be recreated on te site
/public where to final site is saved to
/intermediate - where Husky puts files as the site is being made

The basic execution flow is:
* set Template Engine (Twig, mustache, etc)
* set Parser (MD, Textile, etc)
* recreate folder structure of assets
* convert each content file (that is blog entries) into HMTL using the correct parser (MD, Textile, etc)
* Then each content file is run through the Template Engine to create the final pages

todo:
[ ] Add exception handling
[*] Setup unit testing
[*] Setup vfsStream
[*] Add support for multiple files and dirs in content
[*] Add parsing for getting the title of each blog entry
[ ] Add Pygment code parsing
[ ] Add default stylesheet
[ ] Add navigation ordered by date created - SplFileInfo::getCTime - make available to templates?
[ ] Fix naming conventions on methods for invoking the Parser and Temaplate Engine
[ ] Put Twig, Mustache, Bootstrap, Markdown as Git Submodules
[ ] Add 'base url' or similar var for template so we can link up CSS /JS

Upcoming features
* HTML5BP build script integration
* S3 auto update

Issues

Resolve issue with creating absolute vs relative URLs for nav links
- maybe have a project URL - can be either a URL or absolute path

Add yaml or Zend config for config rather than a loader of class constants

Move getPageTitle out of Nav class and into Parser

Distinguish between internal path (e.g. for writing the site) and exterrnal (e.g. for accessing the site)
