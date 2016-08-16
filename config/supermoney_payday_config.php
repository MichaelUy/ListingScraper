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
    'Advanced Fee APR' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-apr',
      'value_contains' => '' ,
    ),
    'Desired Loan Amount' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-desired-loan-amount',
      'value_contains' => '' ,
    ),
    'No Credit Check' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => 'no-credit' ,
    ),
    'Min Monthly Income' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-min-monthly-income',
      'value_contains' => '' ,
    ),
    'No Other Outstanding Loans' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => 'no-other' ,
    ),  
    'Benefits' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'direct',
        'Instant',
        'online',
        ) ,
    ),
   // 'States Offered' => array(
   //    'value' => 'innertext',
   //    'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
   //    'value_contains' => array(
   //      'new-loan',    
   //      'refinance'
   //      ) ,
   //  ),
  );

?>
