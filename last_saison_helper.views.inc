<?php

/**
 * @file
 * The module file.
 */

/**
 * Implements hook_views_data().
 */
function last_saison_helper_views_data() {
  $data['views']['table']['group'] = t('Custom Global');
  $data['views']['table']['join'] = [
    // #global is a special flag which allows a table to appear all the time.
    '#global' => [],
  ];

  $data['views']['last_saison_field'] = [
    'title' => t('Dernière saison en date'),
    'help' => t('La saison la plus récente (selon le champs date_de_debut).'),
    'field' => [
      'id' => 'last_saison_field',
    ],
  ];
  return $data;
}