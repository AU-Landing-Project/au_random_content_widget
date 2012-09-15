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

$options = array(
    'types' => array('object'),
    'subtypes' => $subtypes,
    'limit' => $widget->numdisplay ? $widget->numdisplay: 5,
    'order_by' => 'RAND()',
    'full_view' => false,
    'pagination' => false
);

$content = elgg_list_entities($options);

if ($content) {
  echo $content;
}
else {
  echo elgg_echo('au_random_content:no:results');
}