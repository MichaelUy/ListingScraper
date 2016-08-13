<?php
////////////////////////////////////////////////////////////////////////////////
// CALL BACK FUNCTIONS
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
/*
Directory:
hide_all_but
hide_all_company_filter
get_credit_business
get_credit_personal
*/
////////////////////////////////////////////////////////////////////////////////


//  hides all but ////////////////////////////////////////////////////////
function hide_all_but($element){
 //lol it doesn't need a call back 
}

//  hide_all  ////////////////////////////////////////////////////////
function hide_all_company_filter($element){
  $hide_all = 'company-filter';
  $class = $element->class;
  if (strpos($class,$hide_all)!== FALSE){
    $element->outertext='';
    $element->class='';
    echo "hid $hide_all\n";
  }

}


//  get_credit_personal  ////////////////////////////////////////////////////////
function get_credit_personal($element){
  global $first_credit ; 
  global $current_credit ; 
  global $count;
  global $count_insert;
  global $count_finish;
  global $started;
  global $name;
  global $state;
  global $first_name; 

  if($first_credit == 'red'){
    return;
  }

  $class = $element->class;
  $tag = $element->tag;
  $innertext = trim($element->innertext,"\x00..\x1F");
  

          if( substr($innertext,0,8) ==='bizname-' ){
            

            if($name == $innertext){
            }
            else{
              
              if($started and $name != $innertext){
                 if ($first_name == $innertext){
                  $first_credit = 'red';
                  return;
                }

                echo $innertext . "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
                $element->innertext = $current_credit;
              $element->class = 'ignore';
      
                $tempMin = "<div class=\"min-credit\"></div>\n";
                $tempMax = "<div class=\"max-credit\"></div>\n";    

              $name = $innertext;
              echo $count_insert ."insert\n" . "\tstarted: $started\n" . "\tname: $name\n". "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n" ;
              echo "$count started\n" . "\tstarted: $started\n" . "\tname: $name\n";

                $element->outertext =   $tempMin . $tempMax .$element->outertext ;
              $count++;
              $count_finish++;
              $count_insert ++;
              }
              else if($started==0 and $name != $innertext){
                $name = $innertext;
                if ($first_name == $innertext){
                  $first_credit = 'red';
                  return;
                }
                if($count==0){
                  $first_name = $name;
                }
                $started =1;
                echo "$count started\n" . "\tstarted: $started\n" . "\tname: $name\n";
                $count++;

                $count_insert =0;
              }
              else
              $name = $innertext;
            }
          }

  if($started){
 
      if ( $class=='hide table-tag'){
        // if first/min credit has been found aka $first_credit !=0
        if( $first_credit){    
          // and this element is a credit  
           if(strpos($innertext,'credit-required')!== FALSE){
            // relable innertext
            if($innertext == 'credit-required-116')
              $element->innertext = 'Excellent (750-850)';
            if($innertext == 'credit-required-115')
              $element->innertext = 'Good(700-749)';
            if($innertext == 'credit-required-114')
              $element->innertext = 'Fair (640-699)';
            if($innertext == 'credit-required-113')
              $element->innertext = 'Poor (560-639)';
            if($innertext == 'credit-required-132')
              $element->innertext = 'Deficient (559 or below)';
     
              // set current_credit to current inner index 
              $current_credit= $element->innertext;
            }
            else{// if this element is NOT a credit

              // force current elemet to become our last/maxcredit 
              // clear globals
              $element->innertext = $current_credit;
              $element->class = 'ignore';
              $temp = "<div class=\"max-credit\">". $current_credit . "</div>\n";

              $started = 0;
              $first_credit = '';
              $current_credit = '';
              echo $count_finish ."finish- innertext:" .$element->innertext  ."\n" . "\tstarted: $started\n" . "\tname: $name\n" ;
             
              $temp2 = $element->outertext;
              $element->outertext =   $temp ."\n". $temp2;
              $count_finish++;
              if($count_insert>1){
                echo "======================INSERTED ON FINISH\n";
                 $tempMin = "<div class=\"min-credit\"></div>\n";
                $tempMax = "<div class=\"max-credit\"></div>\n";
               $element->outertext =   $tempMin . $tempMax. $element->outertext  ; 
              }
              $count_insert =0;

            }
        }
        else{// if first/min credit has NOT been found aka $first_credit == 0

          // if this element is credit
          if(strpos($innertext,'credit-required')!== FALSE){
            // relable innertext
            if($innertext == 'credit-required-116')
              $element->innertext = 'Excellent (750-850)';
            if($innertext == 'credit-required-115')
              $element->innertext = 'Good(700-749)';
            if($innertext == 'credit-required-114')
              $element->innertext = 'Fair (640-699)';
            if($innertext == 'credit-required-113')
              $element->innertext = 'Poor (560-639)';
            if($innertext == 'credit-required-132')
              $element->innertext = 'Deficient (559 or below)';

              // mark element as first/min credit
              $element->class = 'min-credit';
              $innertext = $element->innertext;
              $first_credit= $innertext;
              $current_credit= $innertext;
            }
            else{// if this element is NOT a credit

          }
        }
      }
  }
}


//  get_credit_business  ////////////////////////////////////////////////////////
function get_credit_business($element){
  global $first_credit ; 
  global $current_credit ; 
  global $count;
  global $count_insert;
  global $count_finish;
  global $started;
  global $name;
  global $state;
  global $first_name; 

  if($first_credit == 'red'){
    return;
  }

  $class = $element->class;
  $tag = $element->tag;
  $innertext = trim($element->innertext,"\x00..\x1F");
  

          if( substr($innertext,0,8) ==='bizname-' ){
            

            if($name == $innertext){
            }
            else{
              
              if($started and $name != $innertext){
                 if ($first_name == $innertext){
                  $first_credit = 'red';
                  return;
                }

                echo $innertext . "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
                $element->innertext = $current_credit;
              $element->class = 'ignore';
      
                $tempMin = "<div class=\"min-credit\"></div>\n";
                $tempMax = "<div class=\"max-credit\"></div>\n";    

              $name = $innertext;
              echo $count_insert ."insert\n" . "\tstarted: $started\n" . "\tname: $name\n". "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n" ;
              echo "$count started\n" . "\tstarted: $started\n" . "\tname: $name\n";

                $element->outertext =   $tempMin . $tempMax .$element->outertext ;
              $count++;
              $count_finish++;
              $count_insert ++;
              }
              else if($started==0 and $name != $innertext){
                $name = $innertext;
                if ($first_name == $innertext){
                  $first_credit = 'red';
                  return;
                }
                if($count==0){
                  $first_name = $name;
                }
                $started =1;
                echo "$count started\n" . "\tstarted: $started\n" . "\tname: $name\n";
                $count++;

                $count_insert =0;
              }
              else
              $name = $innertext;
            }
          }

  if($started){
 
      if ( $class=='hide table-tag'){
        // if first/min credit has been found aka $first_credit !=0
        if( $first_credit){    
          // and this element is a credit  
           if(strpos($innertext,'credit-required')!== FALSE){
            // relable innertext
            if($innertext == 'credit-required-116')
              $element->innertext = 'Excellent (750-850)';
            if($innertext == 'credit-required-115')
              $element->innertext = 'Good(700-749)';
            if($innertext == 'credit-required-114')
              $element->innertext = 'Fair (640-699)';
            if($innertext == 'credit-required-113')
              $element->innertext = 'Poor (560-639)';
            if($innertext == 'credit-required-132')
              $element->innertext = 'Deficient (559 or below)';
     
              // set current_credit to current inner index 
              $current_credit= $element->innertext;
            }
            else{// if this element is NOT a credit

              // force current elemet to become our last/maxcredit 
              // clear globals
              $element->innertext = $current_credit;
              $element->class = 'ignore';
              $temp = "<div class=\"max-credit\">". $current_credit . "</div>\n";

              $started = 0;
              $first_credit = '';
              $current_credit = '';
              echo $count_finish ."finish- innertext:" .$element->innertext  ."\n" . "\tstarted: $started\n" . "\tname: $name\n" ;
             
              $temp2 = $element->outertext;
              $element->outertext =   $temp ."\n". $temp2;
              $count_finish++;
              $count_insert =0;

            }
        }
        else{// if first/min credit has NOT been found aka $first_credit == 0

          // if this element is credit
          if(strpos($innertext,'credit-required')!== FALSE){
            // relable innertext
            if($innertext == 'credit-required-116')
              $element->innertext = 'Excellent (750-850)';
            if($innertext == 'credit-required-115')
              $element->innertext = 'Good(700-749)';
            if($innertext == 'credit-required-114')
              $element->innertext = 'Fair (640-699)';
            if($innertext == 'credit-required-113')
              $element->innertext = 'Poor (560-639)';
            if($innertext == 'credit-required-132')
              $element->innertext = 'Deficient (559 or below)';

              // mark element as first/min credit
              $element->class = 'min-credit';
              $innertext = $element->innertext;
              $first_credit= $innertext;
              $current_credit= $innertext;
            }
            else{// if this element is NOT a credit

          }
        }
      }
  }
}

//  get_credit_business  ////////////////////////////////////////////////////////
function get_child_student($element){
  global $first_credit ; 
  global $current_credit ; 
  global $count;
  global $count_insert;
  global $count_finish;
  global $started;
  global $name;
  global $state;
  global $first_name; 

  if($first_credit == 'red'){
    return;
  }

  $class = $element->class;
  $tag = $element->tag;
  $innertext = trim($element->innertext,"\x00..\x1F");
  

          if( substr($innertext,0,8) ==='bizname-' ){
            if($name == $innertext){
            //  revisited
            }
            else{
              if($first_credit == $innertext){
                $first_credit = 'red';
              }
              $name = $innertext;
              //new offer
              $started = 1;
            }
          }

  if($started){
      if ( $class=='hitem-title'){
        // if first/min credit has been found aka $first_credit !=0
        if( $first_credit){    
          // and this element is a credit  
           if(strpos($innertext,'credit-required')!== FALSE){
            // relable innertext
            if($innertext == 'credit-required-116')
              $element->innertext = 'Excellent (750-850)';
            if($innertext == 'credit-required-115')
              $element->innertext = 'Good(700-749)';
            if($innertext == 'credit-required-114')
              $element->innertext = 'Fair (640-699)';
            if($innertext == 'credit-required-113')
              $element->innertext = 'Poor (560-639)';
            if($innertext == 'credit-required-132')
              $element->innertext = 'Deficient (559 or below)';
     
              // set current_credit to current inner index 
              $current_credit= $element->innertext;
            }
            else{// if this element is NOT a credit

              // force current elemet to become our last/maxcredit 
              // clear globals
              $element->innertext = $current_credit;
              $element->class = 'ignore';
              $temp = "<div class=\"max-credit\">". $current_credit . "</div>\n";

              $started = 0;
              $first_credit = '';
              $current_credit = '';
              echo $count_finish ."finish- innertext:" .$element->innertext  ."\n" . "\tstarted: $started\n" . "\tname: $name\n" ;
             
              $temp2 = $element->outertext;
              $element->outertext =   $temp ."\n". $temp2;
              $count_finish++;
              $count_insert =0;

            }
        }
        else{// if first/min credit has NOT been found aka $first_credit == 0

          // if this element is credit
          if(strpos($innertext,'credit-required')!== FALSE){
            // relable innertext
            if($innertext == 'credit-required-116')
              $element->innertext = 'Excellent (750-850)';
            if($innertext == 'credit-required-115')
              $element->innertext = 'Good(700-749)';
            if($innertext == 'credit-required-114')
              $element->innertext = 'Fair (640-699)';
            if($innertext == 'credit-required-113')
              $element->innertext = 'Poor (560-639)';
            if($innertext == 'credit-required-132')
              $element->innertext = 'Deficient (559 or below)';

              // mark element as first/min credit
              $element->class = 'min-credit';
              $innertext = $element->innertext;
              $first_credit= $innertext;
              $current_credit= $innertext;
            }
            else{// if this element is NOT a credit

          }
        }
      }
  }
}



?>