<?php

namespace Drupal\enhanced_button_link\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Path\PathValidatorInterface;
use Drupal\Core\Utility\Token;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\enhanced_button_link\EnhancedButtonInterface;

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
   * The token replacement instance.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * Constructs a new LinkFormatter.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Third party settings.
   * @param \Drupal\Core\Path\PathValidatorInterface $path_validator
   *   The path validator service.
   * @param \Drupal\Core\Utility\Token $token
   *   The token replacement instance.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, PathValidatorInterface $path_validator, Token $token) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings, $path_validator);
    $this->token = $token;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('path.validator'),
      $container->get('token')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'type' => 'btn-primary',
      'size' => EnhancedButtonInterface::SIZE_NORMAL,
      'status' => EnhancedButtonInterface::STATUS_ENABLED,
      'target' => EnhancedButtonInterface::TARGET_SAME_WINDOW,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();

    $form['type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#default_value' => !empty($settings['type']) ? $settings['type'] : 'btn-primary',
      '#options' => [
        'btn-primary' => $this->t('Primary button'),
        'btn-secondary' => $this->t('Secondary button'),
        'btn-success' => $this->t('Success button'),
        'btn-danger' => $this->t('Danger button'),
        'btn-warning' => $this->t('Warning button'),
        'btn-info' => $this->t('Info button'),
        'btn-light' => $this->t('Light button'),
        'btn-dark' => $this->t('Dark button'),
        'btn-outline-primary' => $this->t('Primary outline button'),
        'btn-outline-secondary' => $this->t('Secondary outline button'),
        'btn-outline-success' => $this->t('Success outline button'),
        'btn-outline-danger' => $this->t('Danger outline button'),
        'btn-outline-warning' => $this->t('Warning outline button'),
        'btn-outline-info' => $this->t('Info outline button'),
        'btn-outline-light' => $this->t('Light outline button'),
        'btn-outline-dark' => $this->t('Dark outline button'),
      ],
      '#required' => TRUE,
    ];

    $form['size'] = [
      '#type' => 'select',
      '#title' => $this->t('Size'),
      '#default_value' => !empty($settings['size']) ? $settings['size'] : EnhancedButtonInterface::SIZE_NORMAL,
      '#options' => [
        EnhancedButtonInterface::SIZE_NORMAL => $this->t('Normal'),
        EnhancedButtonInterface::SIZE_BIG => $this->t('Big'),
        EnhancedButtonInterface::SIZE_SMALL => $this->t('Small'),
      ],
      '#required' => TRUE,
    ];

    $form['status'] = [
      '#type' => 'select',
      '#title' => $this->t('Status'),
      '#default_value' => !empty($settings['status']) ? $settings['status'] : EnhancedButtonInterface::STATUS_ENABLED,
      '#options' => [
        EnhancedButtonInterface::STATUS_ENABLED => $this->t('Enabled'),
        EnhancedButtonInterface::STATUS_DISABLED => $this->t('Disabled'),
      ],
      '#required' => TRUE,
    ];

    $form['target'] = [
      '#type' => 'select',
      '#title' => $this->t('Target'),
      '#default_value' => !empty($settings['target']) ? $settings['target'] : EnhancedButtonInterface::TARGET_SAME_WINDOW,
      '#options' => [
        EnhancedButtonInterface::TARGET_SAME_WINDOW => $this->t('Same Window'),
        EnhancedButtonInterface::TARGET_NEW_TAB => $this->t('New Tab'),
      ],
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    $summary = [];

    $summary[] = $this->t('Button Type: @text', ['@text' => $settings['type']]);
    $summary[] = $this->t('Button Size: @text', ['@text' => $settings['size']]);
    $summary[] = $this->t('Button Status: @text', ['@text' => $settings['status']]);
    $summary[] = $this->t('Button Target: @text', ['@text' => $settings['target']]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $settings = $this->getSettings();
    $entity = $items->getEntity();

    foreach ($items as $delta => $item) {
      $url = $this->buildUrl($item);

      // Load links options.
      $options = $url->getOptions();

      // Load Link Title.
      $link_title = $this->token->replace($item->title, [$entity->getEntityTypeId() => $entity], ['clear' => TRUE]);

      // Create default output of the link.
      $element[$delta] = [
        '#type' => 'link',
        '#url' => $url,
        '#title' => $link_title,
        '#options' => [],
      ];

      $attributes = [];
      $btn_class = [];

      // Add button type.
      $button_link_type = (empty($options['type']) || $options['type'] == EnhancedButtonInterface::TYPE_DEFAULT) ? $settings['type'] : $options['type'];

      if (!empty($button_link_type)) {
        $btn_class += ['btn', $button_link_type];
      }

      // Add button size.
      $button_link_size = (empty($options['size']) || $options['size'] == EnhancedButtonInterface::SIZE_DEFAULT) ? $settings['size'] : $options['size'];

      $size_css_class = '';
      switch ($button_link_size) {
        case EnhancedButtonInterface::SIZE_BIG:
          $size_css_class = 'btn-lg';
          break;

        case EnhancedButtonInterface::SIZE_SMALL:
          $size_css_class = 'btn-sm';
          break;
      }

      $btn_class[] = $size_css_class;

      // Add button status.
      $button_link_status = (empty($options['status']) || $options['status'] == EnhancedButtonInterface::STATUS_DEFAULT) ? $settings['status'] : $options['status'];

      // Disable button if set to be disabled.
      if ($button_link_status == EnhancedButtonInterface::STATUS_DISABLED) {
        $attributes['aria-disabled'] = 'true';
        $attributes['role'] = 'button';
        $btn_class[] = 'disabled';
      }

      // Add button target.
      $button_link_target = (empty($options['target']) || $options['target'] == EnhancedButtonInterface::TARGET_DEFAULT) ? $settings['target'] : $options['target'];

      // Add target to the link.
      if ($button_link_target == EnhancedButtonInterface::TARGET_NEW_TAB) {
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
