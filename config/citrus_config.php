<?php
////////////////////////////////////////////////////////////////////////////////
// SCRAPE.PHP Config format
// * $fromWeb: bool of if from web or page
// * $url: string of source
// * $fileds {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
// * $callback_array [][] Array of [callback_functionname, find_class_selector] tuples
////////////////////////////////////////////////////////////////////////////////

$fromWeb = 0;
$url = 'https://citruscredit.com/Loans?id=8871dbad-9278-4a48-3672-08d3583f61a4';
// $url ='http://smartycredit.app:8000';


$fields = array(
  'Name' => array('.offer-logo', 'src'),
  'Interest %' => array('.int-rate', 'innertext'),
  'Max Loan' => array('.max-loan', 'innertext'),
  'Min Score' => array('.min-score', 'innertext'),
  'Orig Fee' => array('.orig-fee', 'innertext'),
);


$callback_array =[
  array('hide_all','div[ng-show].col-xs-12'),
  array('fix','.ng-binding, .offer-logo, .offer-lead-following'),
];




////////////////////////////////////////////////////////////////////////////////
// CALL BACK FUNCTIONS
////////////////////////////////////////////////////////////////////////////////


//  hides all $hide_all ////////////////////////////////////////////////////////
function hide_all($element){
  $hide_all = 'ng-hide';
  $class = $element->class;
  if (strpos($class,$hide_all)!== FALSE){
    $element->outertext='';
    $element->class='';
    // echo "hid $hide_all\n";
  }

}


//  relables classes  ////////////////////////////////////////////////////////
function fix($element){
  $class = $element->class;
  // echo "CLAS: {$class} \t\n";
  $innertext = trim($element->innertext,"\x00..\x1F");
  // $innertext = trim($innertext);
  // echo "innertext: $innertext \n";
  if ($element->tag=='img'){
      $status = $element->src;
      preg_match("#([^/_]+)(?=[_\d]*\..{2,6}$)#",$status, $match);
      if(! empty($match)){
        $element->src = $match[0];
      }
    }
  else if ( strpos($class,'offer-lead-following')!== FALSE){
    // echo " offer-lead inner: $innertext \n";
    if(strpos($innertext,'%')!== FALSE){
      $element->class ='ng-binding int-rate offer-lead-following';
    }
    if(strpos($innertext,'$')!== FALSE){
      $element->class ='ng-binding max-loan offer-lead-following';
    }

  }
  else{

    if((strpos($innertext,'%')!== FALSE) or  (strpos($class,'None')!== FALSE) ){
      $element->class ='ng-binding orig-fee';
      $element->innertext = trim($element->innertext);
    }
    else if((empty(trim(trim($innertext), '+-.,0123456789')) and !empty($innertext)) or (strpos($class,'n/a')!== FALSE) ){
      $element->class ='ng-binding min-score';
      $element->innertext = trim($element->innertext);
    }
    else{
      // echo "DEAD  $class\n";
        // $element->outertext = '';
    }
  }
  $class = $element->class;
  // flush();
  // echo "CLASS: {$class} \t\n";
  $innertext = trim($element->innertext,"\x00..\x1F");
  // flush();
  // $innertext = trim($element->innertext);
  // echo "innertext: $innertext \n";

}



?>
