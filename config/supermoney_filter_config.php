<?php
////////////////////////////////////////////////////////////////////////////////
// SCRAPE.PHP Config format
// * your globals
// * $url: string
// * $fromWeb: boolean true if From web
// * $fields {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
// * $callback_array [][] Array of [callback_functionname, find_class_selector] tuples
////////////////////////////////////////////////////////////////////////////////
 $listing_selector = 'div.company-filter div.select-area tr[id]';

$fields = array(
    'Name' => array(
      'value' => 'innertext',
      'field_selector' => 'td.bizlist-logo span.hide',
      'value_contains' => '' ,
      // 'value_contains' => '' ,
    ),
    'Interest APR' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-loan-term-years',
      'value_contains' => '' ,
    ),

}

?>