<?php
////////////////////////////////////////////////////////////////////////////////
// listingscraoer.php Config format
// * $listing_selector: jquery style element selector of the listings themselves 
// * $fields {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
////////////////////////////////////////////////////////////////////////////////

  $listing_selector = 'table[id=tfilterComp] tr[id]';


           
/*
Business:
  interest-apr
  desired-loan
  **Target Credit Score
  credit-required
  **Funding Timeline
  minute
  day
  week
  **Key Features
  no-origin
  no-prepay
  **Min Business Revenue
  min-revenue
  **Min Years in Business
  min-year
  **Max Origination Fee
  .compare-origination-fee-pct
  **Credit Type Offered
  credit-type-offered-110 unsecured term loan
  .
  .
  .
  **Intended Use of Funds
  intended-use-of-funds-130 Business Debt Refinancing
  .
  .
  .
  **Institution Type
  institution-type-33 bank
  .
  .
  .
  **States Offered
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
   'Funding Timeline' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'minute',    
        'day',    
        'week'  
        ) ,
    ),
   'Key Features' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'no-origin',    
        'no-prepay'
        ) ,
    ),
   'Business Revenue' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-min-revenue',
      'value_contains' => '',
    ),
   'Years in Business' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-min-years-in-business',
      'value_contains' => '',
    ),
   'Max Origination Fee' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-origination-fee-pct',
      'value_contains' => '',
    ),
   'Credit Type Offered' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'credit-type-offered',    
        ) ,
    ),
   'Intended Use of Funds' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.table-tag',
      'value_contains' => array(
        'intended-use-of-funds',    
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
