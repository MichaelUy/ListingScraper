<?php
////////////////////////////////////////////////////////////////////////////////
// SCRAPE.PHP Config format
// * your globals
// * $url: string
// * $fromWeb: boolean true if From web
// * $fields {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
// * $callback_array [][] Array of [callback_functionname, find_class_selector] tuples
////////////////////////////////////////////////////////////////////////////////

  $first_credit = ""; 
  $current_credit = ""; 
  $count = 0;
  $count_insert = 0;
  $count_finish = 0;
  $started = 0;
  $first_name = '';
 

$fromWeb = 0;
$url = 'https://www.supermoney.com/reviews/personal-loans';
// $url ='http://smartycredit.app:8000';


$fields = array(
  'Name' => array('tr td.bizlist-logo span.hide', 'innertext'),
  'Interest %' => array('tr>td.bizlist-icons>div.compare-interest-rate ', 'innertext'),
  'Loan Amount' => array('tr>td.bizlist-icons>div.compare-loan-amount', 'innertext'),
  'Orig. Fee' => array('tr>td.bizlist-icons>div.compare-origination-fee-pct', 'innertext'),
  'Min credit' => array('.min-credit', 'innertext'),
  'Max credit' => array('.max-credit', 'innertext'),
);


$callback_array =[
  array('hide_all_but','article[id=content] div[id=tfilterComp]>tbody>tr'),
  array('get_credit_personal','*'),
];


if($dump == 'dump'){
  $callback_array []= array('hide_all_but','h2.company-table-cell-title, .min-credit, .max-credit');

}

?>