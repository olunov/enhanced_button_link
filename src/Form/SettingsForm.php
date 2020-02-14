<?php

namespace Drupal\enhanced_button_link\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\enhanced_button_link\EnhancedButtonInterface;
use EnhancedButtonLinkHelper;
use EnhancedButtonLinkParseException;

/**
 * Defines a form that configures devel settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'enhanced_button_link_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'enhanced_button_link.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $configs = $this->config('enhanced_button_link.settings');

    $form['button_link_styles'] = [
      '#type' => 'textarea',
      '#title' => t('Button Link Styles'),
      '#default_value' => $configs->get('button_link_styles'),
      '#description' => t('Put here available button link styles options. There should be pairs of bootstrap button classes and their titles in format: bootstrap-class|Title, for example: btn-primary|Primary button.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $values = $form_state->getValues();

    try {
      $button_link_styles = EnhancedButtonLinkHelper::parseConfigsFromValue($values['button_link_styles']);
    } catch (EnhancedButtonLinkParseException $e) {
      $message = '';
      switch ($e->getCode()) {
        case EnhancedButtonInterface::EXC_CODE_PARSE_PAIR:
          $form_state->setErrorByName('button_link_styles', $this->t('Styles options must be entered in format: bootstrap-class|Title, for example: btn-primary|Primary button. One per line.'));
          break;
          
        case EnhancedButtonInterface::EXC_CODE_PARSE_CSS_CLASS:
          $form_state->setErrorByName('button_link_styles', $this->t('.'));
          break;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->config('enhanced_button_link.settings')
      ->set('button_link_styles', $button_link_styles)
      ->save();

    parent::submitForm($form, $form_state);
  }

}
