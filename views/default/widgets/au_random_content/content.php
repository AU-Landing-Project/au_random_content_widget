<?php

$widget = $vars['entity'];

$registered_entities = elgg_get_config('registered_entities');

$subtypes = array();
foreach ($registered_entities['object'] as $subtype) {
  $attribute = 'subtype_' . $subtype;
  
  if ($widget->$attribute) {
    $subtypes[] = $subtype;
  }
}

if (!count($subtypes)) {
  echo elgg_echo('au_random_content:no:subtypes');
  return;
}

$created_time_lower = strtotime($widget->mintime) ? strtotime($widget->mintime) : strtotime('-1 year');

// note that two queries here is more efficient than using order_by RAND()
$options = array(
    'types' => array('object'),
    'subtypes' => $subtypes,
    'created_time_lower' => $created_time_lower,
    'limit' => 0,
    'callback' => FALSE
);

$results = elgg_get_entities($options);
if (!is_array($results)) {
  $results = array();
}

$num = $widget->numdisplay ? $widget->numdisplay : 5;

// make sure we don't try to get more than is possible
while ($num > count($results)) {
  $num--;
}

if ($num > 0) {
  $keys = array_rand($results, $num);
  $guids = array();
  foreach ($keys as $key) {
    $guids[] = $results[$key]->guid;
  }
  
  echo elgg_list_entities(array(
      'types' => array('object'),
      'subtypes' => $subtypes,
      'guids' => $guids,
      'full_view' => FALSE,
      'pagination' => FALSE,
  ));
}
else {
  echo elgg_echo('au_random_content:no:results');
}
