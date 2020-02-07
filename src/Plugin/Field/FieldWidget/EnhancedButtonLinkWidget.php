<?php

namespace Drupal\enhanced_button_link\Plugin\Field\FieldWidget;

use Drupal\enhanced_button_link\EnhancedButtonInterface;
use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Enhanced button link' widget.
 *
 * @FieldWidget(
 *   id = "link_enhanced_button",
 *   label = @Translation("Enhanced Button Link"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class EnhancedButtonLinkWidget extends LinkWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['options']['style'] = [
      '#type' => 'select',
      '#title' => $this->t('Style'),
      '#default_value' => isset($items[$delta]->options['style']) ? $items[$delta]->options['style'] : EnhancedButtonInterface::STYLE_DEFAULT,
      '#description' => $this->t('Select the style of the button.'),
      '#options' => [
        EnhancedButtonInterface::STYLE_DEFAULT => $this->t('Default'),
        'btn-primary' => $this->t('btn-primary'),
        'btn-secondary' => $this->t('btn-secondary'),
        'btn-success' => $this->t('btn-success'),
        'btn-danger' => $this->t('btn-danger'),
        'btn-warning' => $this->t('btn-warning'),
        'btn-info' => $this->t('btn-info'),
        'btn-light' => $this->t('btn-light'),
        'btn-dark' => $this->t('btn-dark'),
        'btn-link' => $this->t('btn-link'),
        'btn-outline-primary' => $this->t('btn-outline-primary'),
        'btn-outline-secondary' => $this->t('btn-outline-secondary'),
        'btn-outline-success' => $this->t('btn-outline-success'),
        'btn-outline-danger' => $this->t('btn-outline-danger'),
        'btn-outline-warning' => $this->t('btn-outline-warning'),
        'btn-outline-info' => $this->t('btn-outline-info'),
        'btn-outline-light' => $this->t('btn-outline-light'),
        'btn-outline-dark' => $this->t('btn-outline-dark'),
      ],
    ];

    $element['options']['size'] = [
      '#type' => 'select',
      '#title' => $this->t('Size'),
      '#default_value' => isset($items[$delta]->options['size']) ? $items[$delta]->options['size'] : EnhancedButtonInterface::SIZE_DEFAULT,
      '#description' => $this->t('Select the size of the button.'),
      '#options' => [
        EnhancedButtonInterface::SIZE_DEFAULT => $this->t('Default'),
        EnhancedButtonInterface::SIZE_NORMAL => $this->t('Normal'),
        EnhancedButtonInterface::SIZE_BIG => $this->t('Big'),
        EnhancedButtonInterface::SIZE_SMALL => $this->t('Small'),
      ],
    ];

    $element['options']['status'] = [
      '#type' => 'select',
      '#title' => $this->t('Status'),
      '#default_value' => isset($items[$delta]->options['status']) ? $items[$delta]->options['status'] : EnhancedButtonInterface::STATUS_ENABLED,
      '#description' => $this->t('Select the status of the button.'),
      '#options' => [
        EnhancedButtonInterface::STATUS_ENABLED => $this->t('Enabled'),
        EnhancedButtonInterface::STATUS_DISABLED => $this->t('Disabled'),
      ],
    ];

    $element['options']['target'] = [
      '#type' => 'select',
      '#title' => $this->t('Target'),
      '#default_value' => isset($items[$delta]->options['target']) ? $items[$delta]->options['target'] : EnhancedButtonInterface::TARGET_SAME_WINDOW,
      '#description' => $this->t('Select the link target.'),
      '#options' => [
        EnhancedButtonInterface::TARGET_SAME_WINDOW => $this->t('Same Window'),
        EnhancedButtonInterface::TARGET_NEW_TAB => $this->t('New Tab'),
      ],
    ];

    return $element;
  }

}
