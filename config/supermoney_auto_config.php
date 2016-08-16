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
 Loan Amount
  Min APR
  Min Credit Score 
  Max Credit Score 
  **Key Features**
    No Prepayment Penalty
  **Loan Type**
    Lease Purchase
    New Loan
    Refinance
  **Institution Type**
    Bank
    Credit Union
    Other
    Peer to Peer Lending
  **Availability** (STATES)
    states
 */

$fields = array(
    'Name' => array(
      'value' => 'innertext',
      'field_selector' => 'td.bizlist-logo span.hide',
      'value_contains' => '' ,
      // 'value_contains' => '' ,
    ),
    'Min APR' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-min-apr',
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
   'Key Features' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'no-prepay',
        ) ,
    ),
   'Loan Type' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'lease-purchase',    
        'new-car-loan',    
        'refinance',      
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
