<?php

namespace Drupal\enhanced_button_link\Plugin\Field\FieldWidget;

use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Enhanced button link' widget.
 *
 * @FieldWidget(
 *   id = "link_enhanced_button",
 *   label = @Translation("Enhanced Link"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class EnhancedButtonLinkWidget extends LinkWidget {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'placeholder_style' => '',
      'placeholder_size' => '',
      'placeholder_status' => '',
      'placeholder_target' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['attributes']['style'] = [
      '#type' => 'select',
      '#title' => $this->t('Style'),
      '#placeholder' => $this->getSetting('placeholder_style'),
      '#default_value' => !empty($items[$delta]->options['attributes']['style']) ? $items[$delta]->options['attributes']['style'] : '',
      '#description' => $this->t('Select the style of the button.'),
      '#options' => [
        0 => $this->t('btn-primary'),
        1 => $this->t('btn-secondary'),
        2 => $this->t('btn-success'),
        3 => $this->t('btn-danger'),
        4 => $this->t('btn-warning'),
        5 => $this->t('btn-info'),
        6 => $this->t('btn-light'),
        7 => $this->t('btn-dark'),
        8 => $this->t('btn-link'),
        9 => $this->t('btn-outline-primary'),
        10 => $this->t('btn-outline-secondary'),
        11 => $this->t('btn-outline-success'),
        12 => $this->t('btn-outline-danger'),
        13 => $this->t('btn-outline-warning'),
        14 => $this->t('btn-outline-info'),
        15 => $this->t('btn-outline-light'),
        16 => $this->t('btn-outline-dark'),
      ],
    ];

    $element['attributes']['size'] = [
      '#type' => 'select',
      '#title' => $this->t('Size'),
      '#placeholder' => $this->getSetting('placeholder_size'),
      '#default_value' => !empty($items[$delta]->options['attributes']['size']) ? $items[$delta]->options['attributes']['size'] : '',
      '#description' => $this->t('Select the size of the button.'),
      '#options' => [
        0 => '',
        1 => $this->t('btn-lg'),
        2 => $this->t('btn-sm'),
      ],

    ];

    $element['attributes']['status'] = [
      '#type' => 'select',
      '#title' => $this->t('Status'),
      '#placeholder' => $this->getSetting('placeholder_status'),
      '#default_value' => !empty($items[$delta]->options['attributes']['status']) ? $items[$delta]->options['attributes']['status'] : '',
      '#description' => $this->t('Select the status of the button.'),
      '#options' => [
        0 => $this->t('enabled'),
        1 => $this->t('disabled'),
      ],
    ];

    $element['attributes']['target'] = [
      '#type' => 'select',
      '#title' => $this->t('Target'),
      '#placeholder' => $this->getSetting('placeholder_target'),
      '#default_value' => !empty($items[$delta]->options['attributes']['target']) ? $items[$delta]->options['attributes']['target'] : '',
      '#description' => $this->t('Select the link target.'),
      '#options' => [
        0 => $this->t('same window'),
        1 => $this->t('new tab'),
      ],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['placeholder_style'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for button style'),
      '#default_value' => $this->getSetting('placeholder_style'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    $elements['placeholder_size'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for button size'),
      '#default_value' => $this->getSetting('placeholder_size'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    $elements['placeholder_status'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for button status'),
      '#default_value' => $this->getSetting('placeholder_status'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    $elements['placeholder_target'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for button target'),
      '#default_value' => $this->getSetting('placeholder_target'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

}
