<?php
$url = 'http://smartycredit.app:8000/personal-loans';
$fields = array(
  'ID' => array('.lender-logo', 'src'),
  'Amount' => array('div.amount', 'innertext'),
  'Mo.Pay' => array('div.mo-pay', 'innertext'),
  'Term' => array('div.term', 'innertext'),
  'APR' => array('div.apr', 'innertext'),
);


function fix($element){
if ($element->tag=='img'){
    $status = $element->src;
    preg_match("#([^/]+)(?=\.[^\.]*$)#",$status, $match);
    $element->src = $match[0];
  }
}


?>
