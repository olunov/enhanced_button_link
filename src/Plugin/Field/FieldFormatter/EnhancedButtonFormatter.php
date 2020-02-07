<?php

namespace Drupal\enhanced_button_link\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;

/**
 * Plugin implementation of the 'enhanced_button_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "enhanced_button_formatter",
 *   label = @Translation("Enhanced Button Link"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class EnhancedButtonFormatter extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // @TODO: add here default configuration for output of the link.
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // @TODO: add here summary for default output.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $entity = $items->getEntity();

    foreach ($items as $delta => $item) {
      $url = $this->buildUrl($item);

      // Load Link Title.
      $link_title = \Drupal::token()->replace($item->title, [$entity->getEntityTypeId() => $entity], ['clear' => TRUE]);

      // Create default output of the link.
      $element[$delta] = [
        '#type' => 'link',
        '#url' => $url,
        '#title' => $link_title,
        '#options' => [],
      ];

      // Load links options.
      $options = $url->getOptions();

      $attributes = [];
      $btn_class = [];

      // Add button style (CSS class).
      if (!empty($options['style'])) {
        $btn_class += ['btn', $options['style']];
      }

      // Add button style (CSS class).
      if (!empty($options['size'])) {
        $btn_class[] = $options['size'];
      }

      // Disable button if set to be disabled.
      // @TODO: Change checking status by defined flag, not text.
      if ($options['status'] !== 'enabled') {
        $attributes['aria-disabled'] = 'true';
        $attributes['role'] = 'button';
        $btn_class[] = 'disabled';
      }

      // Disable button if set to be disabled.
      // @TODO: Change checking target by defined flag, not text.
      if ($options['target'] && $options['target'] == 'new tab') {
        $attributes['target'] = '_blank';
      }

      // Add collected classes to attributes.
      if (!empty($btn_class)) {
        $attributes['class'] = implode(' ', $btn_class);
      }

      // Add collected attributes to the element.
      if (!empty($attributes)) {
        $element[$delta]['#options'] += ['attributes' => []];
        $element[$delta]['#options']['attributes'] += $attributes;
      }
    }

    return $element;
  }

}
