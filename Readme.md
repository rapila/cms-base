# Rapila [![Build status](https://travis-ci.com/rapila/cms-base.svg?branch=master)](https://travis-ci.org/rapila/cms-base)

Rapila is a PHP-based CMS like many others you’ll find out there.

## Goals

Rapila was designed with the following goals in mind:

* Content should be clearly separated from logic and templates. Thus, all content, even images (except those belonging to the templates, obviously) and documents are stored in the database. (MODx, I’m looking at you)
* Support of additional models in the database should be hassle-free and streamlined (unlike Silverstripe).
* All assets of the core CMS (also called `base`) should be easily extendable/overridable by plugins and the site being developed (which is not what Contao will let you do).
* Upgrading the base is as simple as replacing one folder (you’ll only find CodeIgniter-like upgrade instructions for major revision upgrades).
* Keeping the API stable (though we don’t shy away from the occasional deprecation if necessary).
* Be friendly to the site developer. There probably won’t be any Joomla-or-WordPress-like ready-made templates for Rapila. Instead, Rapila is designed to appeal not to the end user but to the command-line-savvy developer who wants to give the end user a great interface for managing their web content.
* Rapila should run on all the cheap hosting plans (provided they run PHP 5.3 and allow access to some database).

Disclaimer: We actually use and love to use (most of) the products that we’re comparing rapila to. We recognise that the points we think we solved better were trade-offs neessary to reach these products’ design goals. We just chose to have different goals – which is what we tried to illustrate here.

## Diving in

Get more information at [rapi.la](http://rapi.la). You’ll find installation instructions in the [Wiki](https://github.com/rapila/cms-base/wiki/Installation).

## License

Rapila is freely distributable under the terms of an MIT-style license.

Copyright (c) 2011 The Rapila Team, http://rapi.la/

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

### Use of other software

The following libraries necessary to use rapila (or parts thereof) are included as submodules of (or linked to at runtime by) the base cms or some of its plugins:

* [jQuery](http://jquery.com/)/[jQuery UI](http://jqueryui.com/) ([MIT-style licensed](http://jquery.org/license/))
* [PHP-CSS-Parser](https://github.com/sabberworm/PHP-CSS-Parser) (MIT-style licensed)
* [Propel](http://www.propelorm.org) (MIT-style licensed)
* [Phing](http://www.phing.info) ([LGPL v3](http://www.phing.info/trac/wiki/Users/License))
* [jQuery-Popover](https://github.com/BrazilianJoe/jquery-popover) (MIT-style licensed)
* [html5-formdata](https://github.com/francois2metz/html5-formdata) (MIT-style licensed)
