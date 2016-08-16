<?php
////////////////////////////////////////////////////////////////////////////////
// SCRAPE.PHP Config format
// * your globals
// * $url: string
// * $fromWeb: boolean true if From web
// * $fields {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
// * $callback_array [][] Array of [callback_functionname, find_class_selector] tuples
////////////////////////////////////////////////////////////////////////////////
 $listing_selector = 'div.res-schumer-box ';

 /*
 Card Name
 Lender Name
 Purchase Intro APR
 Balance Transfer Intro APR
 Regular APR
 Annual Fee
 Credit Needed
 */

$fields = array(
    'Lender Name' => array(
      'value' => 'innertext',
      'field_selector' => 'p.issuer',
      'value_contains' => '' ,
      // 'value_contains' => '' ,
    ),
    'Card Name' => array(
      'value' => 'innertext',
      'field_selector' => 'a[id]',
      'value_contains' => '' ,
    ),
    'Details' => array(
      'value' => 'innertext',
      'field_selector' => 'dd',
      'value_contains' => '' ,
    ),
  
  );

?>
