<?php

namespace Drupal\last_saison_helper\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\ViewExecutable;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("last_saison_field")
 */
class View extends FieldPluginBase {

  /**
   * The current display.
   *
   * @var string
   *   The current display of the view.
   */
  protected $currentDisplay;

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->currentDisplay = $view->current_display;
  }

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    // First check whether the field should be hidden if the value(hide_alter_empty = TRUE) /the rewrite is empty (hide_alter_empty = FALSE).
    $options['hide_alter_empty'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */

  public function render(ResultRow $values) {
   // $entity = $values->_entity;
 //   if ($entity instanceof EntityInterface) {
      $saison_groups = \Drupal::entityTypeManager()
        ->getStorage('group')
        ->loadByProperties(['type' => 'saison']);

   // Sort the groups by the "field_date_debut" field in descending order.
  uasort($saison_groups, function ($a, $b) {
    $dateA = strtotime($a->get('field_date_debut')->getValue()[0]['value']);
    $dateB = strtotime($b->get('field_date_debut')->getValue()[0]['value']);
    if ($dateA == $dateB) {
      return 0;
    }
    return ($dateA < $dateB) ? 1 : -1;
  });
  // Get the most recent Saison group.
  $most_recent_saison_group = reset($saison_groups);
  if ($most_recent_saison_group) {
        // Return the id of the most recent Saison group.
        return $most_recent_saison_group->id();
    }
  }
}