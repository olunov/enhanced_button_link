<?php

namespace Drupal\enhanced_button_link\Plugin;

/**
 * Defines an interface for the Enhanced Button Formatter.
 */
interface EnhancedButtonInterface {

  /**
   * Specifies whether the button's status is enabled.
   */
  const STATUS_ENABLED = 'enabled';

  /**
   * Specifies whether the button's status is disabled.
   */
  const STATUS_DISABLED = 'disabled';

  /**
   * Specifies whether the link should open in new tab.
   */
  const TARGET_NEW_TAB = 'new tab';

}
