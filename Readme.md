# Rapila

## Goals

Rapila is a PHP-based CMS like many others you’ll find out there. It was designed with the following goals in mind:

* Content should be clearly separated from logic and templates. Thus, all content, even images (except those belonging to the templates, obviously) and documents are stored in the database. (MODx, I’m looking at you)
* Support of additional models in the database should be hassle-free and streamlined (unlike Silverstripe).
* All assets of the core CMS (also called `base`) should be easily extendable/overridable by plugins and the site being developed (which is not what Contao will let you do).
* Upgrading the base is as simple as replacing one folder (you’ll only find CodeIgniter-like upgrade instructions for major revision upgrades).
* Keeping the API stable (though we don’t shy away from the occasional deprecation if necessary).
* Be friendly to the site developer. There probably wont’ be any Joomla-or-WordPress-like ready-made templates for Rapila. Instead, Rapila is designed to appeal not to the end user but to the command-line-savvy developer who wants to give the end user a great interface for managing their web content.
* Rapila should run on all the cheap hosting plans (provided they run PHP 5.3 and allow access to some database).

## Diving in

Get more information at [rapi.la](http://rapi.la). You’ll find installation instructions in the [Wiki](https://github.com/rapila/cms-base/wiki/Installation).