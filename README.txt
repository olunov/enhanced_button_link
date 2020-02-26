README.txt for Enhanced Button Link module
------------------------------------------

CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Included Modules and Features
 * Installation
 * Configuration
 * Author/Maintainers

INTRODUCTION
------------
This module enhances core link field widget and formatter in order to render a
link as a bootstrap button. It has the ability to configure style, size, status
(if disabled) and target.

 - For a full description of the module visit:
   https://www.drupal.org/project/enhanced_button_link

 - To submit bug reports and feature suggestions, or to track changes visit:
   https://www.drupal.org/project/issues/enhanced_button_link


REQUIREMENTS
------------

The module requires:

 - Link (Drupal core) module.

 - Bootstrap based theme.

INCLUDED MODULES AND FEATURES
-----------------------------

Enhanced Button Link Widget (EnhancedButtonLinkWidget) - Adds a widget with
extra fields for adding settings to a link field for managing button style,
size, target and status.

Enhanced Button Link Formatter (EnhancedButtonFormatter) - Adds a formatter for
rendering a link as Bootstrap button based on specified parameters in the
widget.

Configuration form to control:

 - Which button styles (types) options are available in widget and formatter.

 - Which styles options (style, size, status and target) will be available in
   the widget, so it would be possible to override default settings defined in
   the formatter.

INSTALLATION
------------

 - Install the Enhanced Button Link module as you would normally install a
   contributed Drupal module. Visit https://www.drupal.org/node/1897420 for
   further information.


CONFIGURATION
-------------
1. Navigate to Administration > Structure > Content types [Content type to
   edit] > Manage form display.
2. Select the 'Enhanced Button Link' as widget for the Link field. Save
   changes.
3. Navigate to Administration > Structure > Content types [Content type to
   edit] > Manage display.
4. Select the 'Enhanced Button Link' as formatter for the Link field. Save
   changes.
5. Navigate to Administration > Content authoring > Enhanced Button Link
   Settings to manage available button styles (types) and override options.
6. Now it is possible to manage link options to render it as a Bootstrap button.


NOTES
-----
1. There is simple library (enhanced_button_link.field) to display buttons links
   inline. In order to change the way how to display them inline it is possible
   to override library on theme level. See more information:
   https://www.drupal.org/node/2216195#override-extend
2. It is possible to extend number of available buttons styles supported by
   Bootstrap by defining buttons CSS classes in the theme styles and adding them
   to configuration form of the module.

Author/Maintainers
------------------

 - Oleksandr Lunov (alunyov) - https://www.drupal.org/u/alunyov
