<?php

namespace Drupal\enhanced_button_link;

/**
 * Defines an interface for the Enhanced Button Formatter.
 */
interface EnhancedButtonInterface {

  /**
   * Specifies whether the button's style is to be used as default.
   */
  const TYPE_DEFAULT = 'default';

  /**
   * Specifies whether the button's size is to be used as default.
   */
  const SIZE_DEFAULT = 'default';

  /**
   * Specifies whether the button's size is normal.
   */
  const SIZE_NORMAL = 'normal';

  /**
   * Specifies whether the button's size is big.
   */
  const SIZE_BIG = 'big';

  /**
   * Specifies whether the button's size is small.
   */
  const SIZE_SMALL = 'small';

  /**
   * Specifies whether the button's status is to be used as default.
   */
  const STATUS_DEFAULT = 'default';

  /**
   * Specifies whether the button's status is enabled.
   */
  const STATUS_ENABLED = 'enabled';

  /**
   * Specifies whether the button's status is disabled.
   */
  const STATUS_DISABLED = 'disabled';

  /**
   * Specifies whether the button's target is to be used as default.
   */
  const TARGET_DEFAULT = 'default';

  /**
   * Specifies whether the link should open in same window.
   */
  const TARGET_SAME_WINDOW = 'same_window';

  /**
   * Specifies whether the link should open in new tab.
   */
  const TARGET_NEW_TAB = 'new_tab';

}
