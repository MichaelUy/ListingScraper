<?php
////////////////////////////////////////////////////////////////////////////////
// listingscraoer.php Config format
// * $listing_selector: jquery style element selector of the listings themselves 
// * $fields {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
////////////////////////////////////////////////////////////////////////////////

  $listing_selector = 'article[id=content] div[id=tfilterComp]>tbody>tr'

  /*
  $fields = array(
    'field_name' => array(
      'target_value' => 'innertext', (ex. class,href,src,background,innertext)
      'field_selector' => 'td.bizlist-logo span.hide',
      'target_value_cond' => 'innertext' (optional; defaults to TRUE)  
    ),
  );
  */
  /*
Student:
Name
Loan Term
**Eligible Borrowers
  Graduate Students   
  Parents   
  Undergraduate Students    
**Key Features
  Good Student Rewards    
  No Origination Fee    
  Unemployment Protection   
**Loan Limit
  Up to Cost of Attendance    
**Loan Type
  New Loan    
  Refinance
*/
  $fields = array(
    'Name' => array(
      'value' => 'innertext',
      'field_selector' => 'tr td.bizlist-logo span.hide',
      'value_contains' => '' ,
      'value_beginswith' => '' ,
      'value_starts' => '' ,
    ),
    'Loan Term' => array(
      'value' => 'innertext',
      'field_selector' => 'tr>td.bizlist-icons>div.compare-loan-term-years',
      'value_contains' => '' ,
      'value_beginswith' => '' ,
      'value_starts' => '' ,
    )
  );
?>
