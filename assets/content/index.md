## A static site generator written in PHP

Okay, there are much better site generators out there:

* [Phrozen](http://www.phrozn.info/en/)
* [Jekyl](https://github.com/mojombo/jekyll)
* [Hyde](http://ringce.com/hyde)

...you still here? Oh hey, so here are some features of Snowshoe:

* __Use any text formatter you want__ Snowshoe comes with Textile and Markdown but you can write your own Adapter for any other library you want
* __Use any template language you want__ Just as with text formatting you can use whatever template language you want too. Snowshoe comees with Twig but again you can write your own adapters
* __Navigation  and page titles are created automatically__

Umm... And that is about it. I said it was simple right?

### Road Map

It's early days on this project (v0.1 BETA) and loads of things suck (Exception handling anyone?). Aside from that, here are new features that will be coming, if not _soon_, then at least within the _next period of time_:

* An Event system so you can write your own observers to hook into Snowshoe's execution
* A file-watcher that will run Snowshoe whenever you save a content or layout file
* A Publish class that will upload your generated HTML files to Amazon S3, Rackspace Cloud, Softlayer, etc or to any server using SFTP
* Some minification of CSS and JS - and probably a LESS compiler
* An 'intermediate' folder for the generated site where you can work on CSS/JS locally and then a 'publish' folder where the minified production files go.
* Automatic syntax highlighting for code samples - using a port of Pygments