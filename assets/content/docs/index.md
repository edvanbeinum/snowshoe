## Documentation

Get the source files from our friends over at [Github](http://github.com/edvanbeinum/snowshoe)

    $ git clone git@github.com:edvanbeinum/snowshoe.git


You'll also need grab the submodules too, as we make sue of a few third party libraries:

    $ cd snowshoe
    $ git submodules init
    $ git submodules update

There you go. To generate the site, from the snowshoe directory

    $ php bin/snowshoe

Then have a look in <code>public/</code> folder to see this site in all its glorious HTML.

### Folders

The pertinent folders you need to know about are

* __/assets/content__ - raw Markdown files that are the main content for the site. Filenames and folders will be replicated in the published site.
* __/assets/layout__ - the layout file, using the templating engine (Twig by default) basically the second step in the [two-step view](http://martinfowler.com/eaaCatalog/twoStepView.html) process
* __/public__ where to final site is saved to

### Configuration

Currently the application config is done through <code>Snowshoe/Config/App.php</code> class. That will probably be moved out into a JSON/YAML config file later.
For now, these are the parameters

<dl>
    <dt>is_production_mode</dt>
    <dd>In production mode, URLs will have the publish_location value prepended to them. Otherwise they
         will have the public_directory. You can switch to production mode by using the -p flag on the command line</dd>
    <dt>site_name</dt>
    <dd>The name of the site - used for page title. It will appear after the page title in the browser window  e.g: About | Site Name</dd>
    <dt>formatter</dt>
    <dd>Name of the Format type that the content is written in. Ships with Markdown or Textile</dd>
    <dt>formatter_file_extension</dt>
    <dd>File extension of the content files</dd>
    <dt>template_engine</dt>
    <dd>Name of the Template Engine. Ships with Twig or Mustache</dd>
    <dt>public_file_extension</dt>
    <dd>This is the file extension that wil be used on the public site</dd>
    <dt>content_directory</dt>
    <dd>Path, relative to Snowshoe's root folder, where the content files live</dd>
    <dd>template_path<dt></dt>
    <dd>Path, relative to Snowshoe's root folder, where the template layout file lives</dd>
    <dt>public_directory</dt>
    <dd>Path, relative to Snowshoe's root folder, where the finished files will be written to</dd>
    <dt>publish_location</dt>
    <dd>The URL of the live site where the files in the publish directory will be available at.
        This can be an absolute filepath too.
        This location will be prepended to links in the navigation and will only be used with -p flag</dd>
    <dt>navigation_sort_criteria</dt>
    <dd>What criteria should the navigation be sorted on? date | alpha</dd>
    <dt>navigation_sort_direction</dt>
    <dd>What direction should the navigation be sorted on? asc | desc</dd>
</dl>


### Production Mode

You the '-p' flag to run Snowshoe in production mode

    $ php bin/snowshoe -p

That will make the URLs on the navigation use the 'publish_location' path rather than the local path. The site is then ready for publishing.

### Extending Snowshoe

You can add your own text formatter or template engine. Snowshoe makes use of the Adapter pattern so if you want to use, let's say Mustache as the templating engine, copy the Mustache PHP library into the Vendor folder.
Then create a class called Mustache in the TemplateEngine/Adapter folder and make sure it extends the AAdapter bse class.
This will give you an execute method that you can then implement.
In the case of mustache, you would include the PHP lib, instantiate the Mustache class and call render() on it, passing though the template string and the variables. I would suggest it would look something like this:

    namespace Snowshoe\TemplateEngine\Adapter;

    /**
     * Mustache TemplateEngine Adapter. This class knows how to interact with the Mustache library
     *
     * @package Snowshoe
     * @author Ed van Beinum <e@edvanbeinum.com>
     */
    class Mustache extends \Snowshoe\TemplateEngine\AAdapter
    {

        public function __construct()
        {
            require_once APPLICATION_PATH . 'Snowshoe/Vendor/TemplateEngines/Mustache/Mustache.php';
            $this->_templateEngine = new \Mustache;
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

Then to tell Snowshoe to use the Mustache Adapter, in Snowshoe\Config\App set the <code>'template_engine' => 'Mustache'</code>
