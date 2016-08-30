<?php
require_once "support/http.php";
require_once "support/web_browser.php";
require_once "support/simple_html_dom.php";



$arg1 = $argv[1]; // name of config/dom/txt file
// $arg1 = $argv[2];  // true if offline 
// $arg1 = $argv[3];  // 
// TODO: Allow for multiple cl args for online/offline

$online = FALSE;
// second arg is config if given
// if(isset($arg2)){
//   $config = "config/" . $arg2 . "_config.php";
//   $online = TRUE;
// }
// else{
  $config = "config/" . $arg1 . "_config.php";
//}

$output = 'scraped/scraped_' . $arg1 . '.txt';

$filename = "DOM/" . $arg1 . "_DOM.php";

// echo "including {$config}\n";
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




$html = new simple_html_dom();

if($online === TRUE){
  $url = "http://www.somesite.com/something/";
  $web = new WebBrowser();
  $result = $web->Process($url);
  if (!$result["success"])  echo "Error retrieving URL.  " . $result["error"] . "\n";
  else if ($result["response"]["code"] != 200)  echo "Error retrieving URL.  Server returned:  " . $result["response"]["code"] . " " . $result["response"]["meaning"] . "\n";
  else{
    $html->load($result['body']);
  }
}
else{
  $html->load(file_get_contents($filename));
}

$file = fopen( $output, 'w');





//build listing array
$listings = array();
foreach($html->find($listing_selector) as $listing){
  $listings[] = $listing;
}



//populate listing details
$ret = array();
$finds = array();
$i=0;
// for each tile (n)
foreach($listings as $listing){

  // if you want to push to database, create an assoc array w/ names and defaults 
  $tile = array(
  'field1' => 'default1',
  'field2'  => '',        // defaults to nothing
  );

  $j=0;
  $ret[$i] = array();
  
  // for each field (n)(m)
  foreach ($fields as $field_name => $value) {
    $k =0;
    
    // $finds = all field_selector fields
    $finds = $listing->find($value['field_selector']); 
    $temp_array = array();
    
    // foreach found field (n)(m)(2)
    foreach ($finds as $find) {
      $temp = 0;  
      $temp = $find->$value['value'];

      if($temp == ""){
        continue;
      }


      if ($value['value_contains']){
        
        // and if it were an array 
        if(is_array($value['value_contains'])){
          $contains = 1;
        
          // test if it is any of these 
          foreach ($value['value_contains'] as $filter) {
        
            if( (strpos($temp,$filter)!== FALSE)) {
              $contains =0;
            }
          }
          if($contains) continue;
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

      // TO DO: turn in to a halper function
      // if the fields are unlabled siblings in a listing
      // but are in a predictable order
      if($keys[$j] == 'Details'){
        $apr_array = array(
          'purchase_intro_apr', 
          'balance_transfer_intro_apr',
          'apr',
          'annual_fee',
          'credit_needed');
        $field = $apr_array[$k];

        if($field == 'apr') {
          if(is_numeric(substr($temp, 0, 1))) {
            $strings = preg_replace("/[\s%]/", "", $temp);
            $strings = explode('-', $strings);
            if($strings[0] != 0){
              $tile['min_apr'] = $strings[0];
            }
            if(isset($strings[1])){      
              // $strings = explode(' ', $strings[1]);          
              $tile['max_apr'] = $strings[1]; 
            }  
          }   
        }
        elseif($field == 'credit_needed') {
          if(is_numeric(substr($temp, 0, 1))){
            $strings = preg_split("#[,/\s]#", "", $temp);
            $scores= array('Excellent','Good');
            foreach ($strings as $string) {
              if($string=='Excellent')$string='4';
              elseif($string=='Good')$string='3';
              elseif($string=='Fair')$string='2';
              elseif($string=='Bad')$string='1';
              elseif($string=='No')$string='0';
            }
            if(is_numeric($string)){
              foreach ($strings as $string) {
                if($string<$tile['min_score'])$tile['min_score'] = $string;      
                if($string>$tile['max_score'])$tile['max_score'] = $string;      
              }        
            }
          }
        }
      }
      $k++;


      // TO DO: Turn in to helper function
      //  data validation and how should the scraped values be saved
      if($value['ret']){
          $field = $value['ret'];
          $main_fields = array('client_name', 'max_score', 'min_score', 'max_amount', 'min_amount', 'max_apr', 'min_apr', 'term',);
          if(in_array($field,$main_fields)){
            $tile[$field] = $temp;
            if($field=='client_name'){
              $image_name = $temp;
              //Lower case everything
              $image_name = strtolower($image_name);
              //Make alphanumeric (removes all other characters)
              $image_name = preg_replace("/[^a-z0-9_\s-]/", "", $image_name);
              //Clean up multiple dashes or whitespaces
              $image_name = preg_replace("/[\s-]+/", " ", $image_name);
              //Convert whitespaces and underscore to dash
              $image_name = preg_replace("/[\s_]/", "-", $image_name);
              $tile['image_path'] = 'assets/images/logos/' . $image_name .".png";
            }
          }
          elseif($field == 'apr' or $field == 'amount'){
            $strings = explode('-', $temp);
            if($strings[0]!=0){
              $tile['min_' . $field] = $strings[0];   
            }
            elseif($tile_type == 'auto'){
              $tile['min_' . $field] = $strings[0];   
            }  
             
            $tile['max_' . $field] = $strings[1];      
          }
          elseif($field =='score'){
            if($temp>$tile['max_score']){
              $tile['max_score'] = $temp;
            }
            if($temp<$tile['min_score']){
              $tile['min_score'] = $temp;      
            }
          }
        }
      // append each $find that passes to $temp_array  
      $temp_array[] = $temp;
    }
 
    $ret[$i][$j] = $temp_array;
    $j++; 
  }
  curl_submit_tile($tile,$arg1);

  $i++;
}

// fclose($file);
flush();
exit();


////////////////////////////////////////
// HELPER FUNCTIONS
////////////////////////////////////////

// TODO: multi_arg() // accept multiple cl args

// TODO: unlabled_save() // what to do with fields that are unlabled but ordered

// TODO: labled_save() // what to do with fields


// echos then fwrites 
function fwriteEcho($file,$string){
  echo $string;
  fwrite($file,$string);
  return;
}

function curl_submit_tile($tile,$tables,$arg1){

  $url =""; // if inserting to a database, add web url here

  $tile_string =http_build_query($tile);

  // Setup cURL
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_POST,count($tile));
  curl_setopt($ch,CURLOPT_POSTFIELDS,$tile_string);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

  $result = curl_exec($ch);
  if($result)var_dump($result);
  curl_close($ch);
}


// if you want to save values as diffrent values add switch case here
function decode_value($text, $field_name){

  if($field_name == 'Target Credit Score' ){
    if($text == 'Excellent')
      return '4';
    if($text == 'Good')
      return '3';
    if($text == 'Fair')
      return '2';
    if($text == 'Poor')
      return '1';
    if($text == 'Very Poor')
      return '0';
  }
}
// if you want to save a file like an image
function save_file($img,$fullpath){
  // $fullpath = './logos/';
  $ch = curl_init ($img);
  // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
  $rawdata=curl_exec($ch);
  curl_close ($ch);
  if(file_exists($fullpath)){
    unlink($fullpath);
  }
  $fp = fopen($fullpath,'x');
  fwrite($fp, $rawdata);
  fclose($fp); 
}

?>
