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
    'Interest APR' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-interest-rate',
      'value_contains' => '' ,
    ),
    'Desired Loan Amount' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-loan-amount',
      'value_contains' => '' ,
    ),
    'Target Credit Score' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => 'credit-required',
    ),
   'Lend to Military' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => 'lend-to-military',
    ),
   'Pre-Approved Soft Credit Inquiry' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => 'pre-approved',
    ),
   'Origination Fee' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-origination-fee-pct',
      'value_contains' => '',
    ),
   'No Origination Fee' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'no-origination',    
        ) ,
    ),
   'Institution Type' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'institution-type',    
        ) ,
    ),
   // 'States Offered' => array(
   //    'value' => 'innertext',
   //    'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
   //    'value_contains' => array(
   //      'states-offered',    
   //      ) ,
   //  ),
  );

?>
