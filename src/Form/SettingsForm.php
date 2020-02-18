<?php

namespace Drupal\enhanced_button_link\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\enhanced_button_link\EnhancedButtonLinkInterface;
use Drupal\enhanced_button_link\EnhancedButtonLinkHelper;
use Drupal\enhanced_button_link\EnhancedButtonLinkParseException;

/**
 * Defines a form that configures enhanced button link settings.
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
    $button_link_styles_options = $configs->get('button_link_styles');
    $button_link_styles_value = EnhancedButtonLinkHelper::makeValueFromConfigs($button_link_styles_options);

    // Get number of style options.
    $rows_number = count($button_link_styles_options);

    $form['button_link_styles'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Button Link Styles'),
      '#default_value' => $button_link_styles_value,
      '#rows' => $rows_number,
      '#description' => $this->t('Put here available button link styles options. There should be pairs of bootstrap button classes and their titles in format: bootstrap-class|Style Title, for example: btn-primary|Primary button.'),
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
      $button_link_styles_options = EnhancedButtonLinkHelper::parseConfigsFromValue($values['button_link_styles']);
    }
    catch (EnhancedButtonLinkParseException $e) {
      switch ($e->getCode()) {
        case EnhancedButtonLinkInterface::EXC_CODE_PARSE_PAIR:
          $form_state->setErrorByName('button_link_styles', $this->t('Styles options must be entered in format: bootstrap-class|Title, for example: btn-primary|Primary button. One per line.'));
          break;

        case EnhancedButtonLinkInterface::EXC_CODE_PARSE_CSS_CLASS:
          $form_state->setErrorByName('button_link_styles', $this->t("Some css class doesn\'t corresponds to correct format."));
          break;

        case EnhancedButtonLinkInterface::EXC_CODE_PARSE_NAME:
          $form_state->setErrorByName('button_link_styles', $this->t('Some style option name has special characters.'));
          break;
      }

      return;
    }

    $form_state->setValue('button_link_styles_options', $button_link_styles_options);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $button_link_styles_options = $values['button_link_styles_options'];
    $this->config('enhanced_button_link.settings')
      ->set('button_link_styles', $button_link_styles_options)
      ->save();

    parent::submitForm($form, $form_state);
  }

}
