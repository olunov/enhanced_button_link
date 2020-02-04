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
 *   label = @Translation("Enhanced button formatter"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class EnhancedButtonFormatter extends LinkFormatter
{

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings()
    {
        return [
        'btn_type' => 'btn-light',
        'btn_size' => 'btn-sm',
        'btn_status' => 'active',
        'target' => '',
        ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state)
    {

        $settings = $this->getSettings();
    
        $form['btn_type'] = [
        '#type' => 'dropbutton',
        '#title' => $this->t('Button type'),
        '#default_value' => $settings['btn_type'],
        '#options' => [
        'btn-primary' => $this->t('Primary button'),
        'btn-secondary' => $this->t('Secondary button'),
        'btn-success' => $this->t('Success button'),
        'btn-danger' => $this->t('Danger button'),
        'btn-warning' => $this->t('Warning button'),
        'btn-info' => $this->t('Info button'),
        'btn-light' => $this->t('Light button'),
        'btn-dark' => $this->t('Dark button'),
        ],
        '#required' => true,
        ];

        $form['btn_size'] = [
        '#type' => 'dropbutton',
        '#title' => $this->t('Button Size'),
        '#default_value' => $settings['btn_size'],
        '#options' => [
        'btn-lg' => $this->t('Large Button'),
        'btn-sm' => $this->t('Small Button'),
        ],
        ];
    
        $form['btn_status'] = [
        '#type' => 'dropbutton',
        '#title' => $this->t('Button status'),
        '#default_value' => $settings['btn_status'],
        '#options' => [
        'active' => $this->t('Active Button'),
        'disabled' => $this->t('Disabled Button'),
        ],
        '#required' => true,
        ];
    
        $form['target'] = [
        '#type' => 'dropbutton',
        '#title' => $this->t('Target window'),
        '#target' => $settings['target'],
        '#default_value' => $settings['target'],
        '#options' => [
        '' => $this->t('Current window'),
        '_blank' => $this->t('New window'),
        ],
        '#required' => true,
        ];
    
        return $form + parent::settingsForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary()
    {
    
        $settings = $this->getSettings();
        $summary = [];
    
        $summary[] = $this->t('Button type: @text', ['@text' => $settings['btn_type']]);
        $summary[] = $this->t('Button size: @text', ['@text' => $settings['btn_size']]);
        $summary[] = $this->t('Button status: @text', ['@text' => $settings['btn_status']]);
        if (!empty($settings['target'])) {
            $summary[] = $this->t('Open link in new window');
        }

        return $summary;
    }

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode)
    {
        $elements = [];
        $settings = $this->getSettings();
    
        foreach ($items as $delta => $item) {
            $url = $this->buildUrl($item);
            $urlTitle = $url->toString();
            $elements[$delta] = [
            '#url_title' => $urlTitle,
            '#url' => $url,
            '#type' => $settings['btn_type'],
            '#size' => $settings['btn_size'],
            '#status' => $settings['btn_status'],
            ];
        }

        return $elements;
    }

}
