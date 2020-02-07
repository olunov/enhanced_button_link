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
      $link_title = $this->token->replace($item->title, [$entity->getEntityTypeId() => $entity], ['clear' => TRUE]);

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

      $size_css_class = '';
      switch ($options['size']) {
        case EnhancedButtonInterface::SIZE_BIG:
          $size_css_class = 'btn-lg';
          break;

        case EnhancedButtonInterface::SIZE_SMALL:
          $size_css_class = 'btn-sm';
          break;
      }

      $btn_class[] = $size_css_class;

      // Disable button if set to be disabled.
      if ($options['status'] == EnhancedButtonInterface::STATUS_DISABLED) {
        $attributes['aria-disabled'] = 'true';
        $attributes['role'] = 'button';
        $btn_class[] = 'disabled';
      }

      // Disable button if set to be disabled.
      if ($options['target'] && $options['target'] == EnhancedButtonInterface::TARGET_NEW_TAB) {
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
