<?php
////////////////////////////////////////////////////////////////////////////////
// SCRAPE.PHP Config format
// * your globals
// * $url: string
// * $fromWeb: boolean true if From web
// * $fields {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
// * $callback_array [][] Array of [callback_functionname, find_class_selector] tuples
////////////////////////////////////////////////////////////////////////////////


 $listing_selector = 'table[id=tfilterComp] tr[id]';

/*
Max Loan
  **Type of Mortgage**
    Adjustable Rate 
    Fixed Rate  
    Home Equity Loans and Lines of Credit 
    Hybrid Mortgage 
    Jumbo Loan  
    Reverse Mortgage  
  **Mortgage Programs**
    FHA 
    FHA 203k  
    HARP  
    HomePath  
    USDA  
    VA  
  **Intended Use**
    Primary Residence 
    Estate/Trust/Retirement
*/

$fields = array(
    'Name' => array(
      'value' => 'innertext',
      'field_selector' => 'td.bizlist-logo span.hide',
      'value_contains' => '' ,
      // 'value_contains' => '' ,
    ),
    'Max Loan' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-max-loan',
      'value_contains' => '' ,
    ),
    'Type of Mortgage' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'adjustable',
        'fixed',
        'home-equity',
        'hybrid',
        'jumbo',
        'reverse',
        ) ,
    ),
    'Intended Use' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'primary',
        'estate',
        ) ,
    ),
  );

?>
