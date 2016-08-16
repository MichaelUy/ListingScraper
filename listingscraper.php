<?php
// error_reporting(E_ALL ^ E_NOTICE);
require_once "support/http.php";
require_once "support/web_browser.php";
require_once "support/simple_html_dom.php";



$arg1 = $argv[1];
// second arg is config if given
// if(isset($arg2)){
//   $config = "config/" . $arg2 . "_config.php";
// }
// else{
  $config = "config/" . $arg1 . "_config.php";
//}

$output = 'scraped/scraped_' . $arg1 . '.txt';
$filename = "DOM/" . $arg1 . "_DOM.html";
echo "including {$config}\n";
if(! file_exists($config)){
  echo "\nERROR: No file named {$config}";
  return;
}

// include the corresponding config
include($config);

$ret = 0;
if(! isset($listing_selector)){
  echo "\nERROR: {$config} does not set \$listing_selector as an assoc. array";
  $ret = 1;
}
if(! isset($fields)){
  echo "\nERROR: {$config} does not set \$fields as an assoc. array";
  $ret = 1;
}
if($ret){
  exit;
}

$keys = array_keys($fields);
$len = count($keys);

$leading_space = 0;
foreach ($keys as $key) {
  if ( (strlen($key) > $leading_space )) {
    $leading_space = strlen($key);
  }
}

//calls scrape 
// $scraped_offers =   scrape($page,$fields,$callback_array,$dump); // download page
// echo "Opened " .$output."\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\t==SCRAPING INITIATED==\n\n";
// $keys = array_keys($fields);
// $len = count($keys);
$file = fopen( $output, 'w');
// fwriteEcho($file, "Source:\t{$url}\n");
// date_default_timezone_set('America/Los_Angeles');
// fwriteEcho($file, "Date:\t" . date('l jS \of F Y h:i:s A') . "\n");
// fwriteEcho($file, "# of Offers:\t" . count($scraped_offers) . "\n");
// fwriteEcho($file, "Fields||Targets:\n");
// foreach ($fields as $key => $value) {
//   fwriteEcho($file, "\t{$key}\t||{$value[0]}\n");
// }
// fwriteEcho($file, "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");



// echo "\nSCRAPING FROM Text File: @ {$page}\nSourced from {$url}\n";

// passed text file name and $fields {}[] Assoc array of field_names labeling [class_selector, attribute] tuples
// returns array of tuple of min credit and max credit scores
echo "Opened " .$output."\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\t==SCRAPING INITIATED==\n\n";
$file = fopen( $output, 'w');



$html = new simple_html_dom();
$html->load(file_get_contents($filename));

//build listing array
$listings = array();
foreach($html->find($listing_selector) as $listing){
  $listings[] = $listing;
}







// fwriteEcho($file, "Source:\t{$url}\n");
date_default_timezone_set('America/Los_Angeles');
fwriteEcho($file, "Date:\t" . date('l jS \of F Y h:i:s A') . "\n");
fwriteEcho($file, "# of Offers:\t" . count($listings) . "\n");
fwriteEcho($file, "Fields:\n");
foreach ($fields as $key => $value) {
  fwriteEcho($file, "\t{$key}:\n");
}
fwriteEcho($file, "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");




//populate listing details
$ret = array();
$finds = array();
$i=0;
// for each offer (n)
foreach($listings as $listing){
  fwriteEcho($file, "\nOffer:\t" . $i ."\n");

  $j=0;
  $ret[$i] = array();
  
  // for each field (n)(m)
  foreach ($fields as $field_name => $value) {
    $echo_string = "\t" . $keys[$j] . ":" . str_repeat(' ', $leading_space - strlen($keys[$j])) . "\t\t";
    $spacing = "\t" . str_repeat(' ', $leading_space) . "\t\t";
    $k =0;
    
    // $finds = all field_selector fields
    $finds = $listing->find($value['field_selector']); 
    $temp_array = array();
    
    // foreach found field (n)(m)(2)
    foreach ($finds as $find) {
      $temp = 0;  
      $temp = $find->$value['value'];
      if($temp == "") continue;

      // // if there is value_beginswith arg passed 
      // if($value['value_beginswith']){
        
      //   // and if it were an array 
      //   if(is_array($value['value_beginswith'])){
      //     $contin = 1;
        
      //     // test if it is any of these 
      //     foreach ($value['value_beginswith'] as $filter) {
        
      //       if( (substr($temp, 0, strlen($filter)) === $value['value_beginswith'])){
      //         $contin =0;
      //       }
      //     }
      //     if($contin) continue;
      //   }
      //   else{
      //     if(! (substr($temp, 0, strlen($value['value_beginswith'])) === $value['value_beginswith'])) {

      //       // does not pass, do not assign
      //       continue;
      //     }
      //   }
      // }
      if ($value['value_contains']){
        
        // and if it were an array 
        if(is_array($value['value_contains'])){
          $contin = 1;
        
          // test if it is any of these 
          foreach ($value['value_contains'] as $filter) {
        
            if( (strpos($temp,$filter)!== FALSE)) {
              $contin =0;
            }
          }
          if($contin) continue;
        }
        else{
          if(! (strpos($temp,$value['value_contains'])!== FALSE)) {
            // does not pass, do not assign
            continue;
          }
        }
      }
      // translate into readable
      $temp = decode_value($temp, $keys[$j]);

      if($keys[$j] == 'Details'){
        $apr_array = array('Purchase Intro APR',
         'Balance Transfer Intro APR',
         'Regular APR',
         'Annual Fee',
         'Credit Needed');
        if($k ==0) $echo_string .= "\n";
        $echo_string .= "\t" . $apr_array[$k] . ":" . "\t";
        $echo_string .= $temp . "\n";
      }
      else{
        if($k!=0) $echo_string .= $spacing ;
        $echo_string .= $temp . "\n";
        
      }
      $k++;

      // append each $find that passes to $temp_array  
      $temp_array[] = $temp;
    }
    // if empty print N/A
    if(empty($temp_array)){
        $echo_string .= "N/A\n";
    }
    fwriteEcho($file, $echo_string );
    // set the return array at 
    $ret[$i][$j] = $temp_array;
    $j++; 
  }

  $i++;
}

fclose($file);
flush();
exit();


////////////////////////////////////////
// HELPER FUNCTIONS
////////////////////////////////////////

// echos then fwrites 
function fwriteEcho($file,$string){
  echo $string;
  fwrite($file,$string);
  return;
}

//decodes salty text to human readable text
function decode_value($text, $field_name){
  if($field_name == 'Lender Name' ){
   preg_match('/(?<=.{3}).*(?=.{3}<)/',$text,$match);
   return $match[0];
  }
  if($field_name == 'Target Credit Score' ){
    if($text == 'credit-required-116')
      return 'Excellent (750-850)';
    if($text == 'credit-required-115')
      return 'Good(700-749)';
    if($text == 'credit-required-114')
      return 'Fair (640-699)';
    if($text == 'credit-required-113')
      return 'Poor (560-639)';
    if($text == 'credit-required-132')
      return 'Deficient (559 or below)';
  }
  elseif($field_name == 'Credit Type Offered'){
    if($text == 'credit-type-offered-110')return 'Unsecured Term Loan';
    if($text == 'credit-type-offered-111')return 'Secured Term Loan';
    if($text == 'credit-type-offered-182')return 'SBA Loan';
    if($text == 'credit-type-offered-112')return 'Line Of Credit';
    if($text == 'credit-type-offered-181')return 'Merchant Cash Advance';
    if($text == 'credit-type-offered-183')return 'Invoice Financing';
  }
  elseif($field_name == 'Intended Use of Funds'){
    if($text == 'intended-use-of-funds-130')return 'Business Debt Refinance';
    if($text == 'intended-use-of-funds-118')return 'Equipment Purchase';
    if($text == 'intended-use-of-funds-122')return 'Lease Improvments';
    if($text == 'intended-use-of-funds-123')return 'New Location';
    if($text == 'intended-use-of-funds-124')return 'Product or Service Expansion';
    if($text == 'intended-use-of-funds-126')return 'working Capital';
  }
  elseif($field_name == 'Institution Type'){
    if($text == 'institution-type-33')return 'Bank';
    if($text == 'institution-type-34')return 'Credit Union';
    if($text == 'institution-type-102')return 'Direct Lender';
    if($text == 'institution-type-117')return 'Other';
    if($text == 'institution-type-109')return 'Peer to Peer Lending';

  }
  elseif($field_name == 'States Offered'){
    if($text == 'states-offered-43')return 'AK - Alaska';
    if($text == 'states-offered-44')return 'AL - Alabama';
    if($text == 'states-offered-45')return 'AR - Arkansas';
    if($text == 'states-offered-46')return 'AS - AmericanSamoa';
    if($text == 'states-offered-47')return 'AZ - Arizona';
    if($text == 'states-offered-48')return 'CA - California';
    if($text == 'states-offered-49')return 'CO - Colorado';
    if($text == 'states-offered-50')return 'CT - Connecticut';
    if($text == 'states-offered-51')return 'DC - Washington, DC';
    if($text == 'states-offered-52')return 'DE - Delaware';
    if($text == 'states-offered-53')return 'FL - Florida';
    if($text == 'states-offered-54')return 'FM - FederatedStates of Micronesia';
    if($text == 'states-offered-55')return 'GA - Georgia';
    if($text == 'states-offered-56')return 'GU - Guam';
    if($text == 'states-offered-57')return 'HI - Hawaii';
    if($text == 'states-offered-58')return 'IA - Iowa';
    if($text == 'states-offered-59')return 'ID - Idaho';
    if($text == 'states-offered-60')return 'IL - Illinois';
    if($text == 'states-offered-61')return 'IN - Indiana';
    if($text == 'states-offered-62')return 'KS - Kansas';
    if($text == 'states-offered-63')return 'KY - Kentucky';
    if($text == 'states-offered-64')return 'LA - Louisiana';
    if($text == 'states-offered-65')return 'MA - Massachusetts';
    if($text == 'states-offered-66')return 'MD - Maryland';
    if($text == 'states-offered-67')return 'ME - Maine';
    if($text == 'states-offered-68')return 'MH - Marshall Islands';
    if($text == 'states-offered-69')return 'MI - Michigan';
    if($text == 'states-offered-70')return 'MN - Minnesota';
    if($text == 'states-offered-71')return 'MO - Missouri';
    if($text == 'states-offered-72')return 'MP - Northern Mariana Islands';
    if($text == 'states-offered-73')return 'MS - Mississippi';
    if($text == 'states-offered-74')return 'MT - Montana';
    if($text == 'states-offered-75')return 'NC - North Carolina';
    if($text == 'states-offered-76')return 'ND - North Dakota';
    if($text == 'states-offered-77')return 'NE - Nebraska';
    if($text == 'states-offered-78')return 'NH - New Hampshire';
    if($text == 'states-offered-79')return 'NJ - New Jersey';
    if($text == 'states-offered-80')return 'NM - New Mexico';
    if($text == 'states-offered-81')return 'NV - Nevada';
    if($text == 'states-offered-82')return 'NY - New York';
    if($text == 'states-offered-83')return 'OH - Ohio';
    if($text == 'states-offered-84')return 'OK - Oklahoma';
    if($text == 'states-offered-85')return 'OR - Oregon';
    if($text == 'states-offered-86')return 'PA - Pennsylvania';
    if($text == 'states-offered-87')return 'PR - PuertoRico';
    if($text == 'states-offered-88')return 'PW - Palau';
    if($text == 'states-offered-89')return 'RI -Rhode Island';
    if($text == 'states-offered-90')return 'SC -South Carolina';
    if($text == 'states-offered-91')return 'SD -South Dakota';
    if($text == 'states-offered-92')return 'TN - Tennessee';
    if($text == 'states-offered-93')return 'TX - Texas';
    if($text == 'states-offered-94')return 'UT - Utah';
    if($text == 'states-offered-95')return 'VA - Virginia';
    if($text == 'states-offered-96')return 'VI - Virgin Islands';
    if($text == 'states-offered-97')return 'VT - Vermont';
    if($text == 'states-offered-98')return 'WA - Washington';
    if($text == 'states-offered-99')return 'WI - Wisconsin';
    if($text == 'states-offered-100')return 'WV - West Virginia';
    if($text == 'states-offered-101')return 'WY - Wyoming';
  }
  
  return $text;
}

?>
