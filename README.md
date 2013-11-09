\mainpage

## Rigging ##

Rigging is an exceedingly simple PHP web framework. It is largely MVC inspired,
with an emphasis on separation of interests. While it deviates somewhat in
design from a classical MVC framework. All deviations are in the spirit of
better meeting the needs of a web application.

### Requirements ###

* PHP5
* Scurvy Template Engine (included as a submodule)

### Setting the framework ###

It is recommended that you keep Rigging separate from any web apps you build
with it. The cleanest way to do this is by cloning rigging into a separate
directory, and modifying your PHP path to include Rigging's new home.

To clone, run the following commands:

	git clone git@github.com:dburkart/rigging.git
	git submodule init
	git submodule update

To add Rigging to your PHP include path, modify / add the following to your
php.ini file:

	include_path =  ".:/path/to/rigging/dir"

If this line already exists, make sure you preserve the previous include_path's
contents.

### Features ###

* Dependency Injection
* Separation of concerns (somewhat enforced)

### Planned Features ###

* Object-Relational mapped layers
* Configuration management
* Multi-argument Module initialization
* Plugins

### Documentation ###

Head to the wiki: https://github.com/dburkart/rigging/wiki
