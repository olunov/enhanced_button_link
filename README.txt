README.txt for Enhanced Button Link module
---------------------------

CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Included Modules and Features
 * Installation
 * Configuration
 * Maintainers

INTRODUCTION
------------

Enhanced Button Link module contains:

 - Enhanced Button Link Widget for adding Bootstrap options to link.

 - Enhanced Button Link Formatter for rendering a link as a Bootstrap button.

This module is in active development for now, it is not recommended to use it on
a production site.

 - For a full description of the module visit:
   https://www.drupal.org/project/enhanced_button_link

 - To submit bug reports and feature suggestions, or to track changes visit:
   https://www.drupal.org/project/issues/enhanced_button_link


REQUIREMENTS
------------

The module requires Link (Drupal core) module.


INCLUDED MODULES AND FEATURES
-----------------------------

Enhanced Button Link Widget (EnhancedButtonLinkWidget) - Adds a widget with
extra fields for adding settings to a link field for managing button style,
size, target and status.

Enhanced Button Link Formatter (EnhancedButtonFormatter) - Adds a formatter for
rendering a link as Bootstrap button based on specified parameters in the
widget.


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
5. Now it is possible to manage link options to render it as a Bootstrap button.

Author/Maintainers
------------------

 - Oleksandr Lunov (alunyov) - https://www.drupal.org/u/alunyov
