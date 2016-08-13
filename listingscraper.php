<?php
// error_reporting(E_ALL ^ E_NOTICE);



$arg1 = $argv[1];
// $dump= $argv[2];
$config = "config/" . $arg1 . "_config.php";
$output = 'scraped/scraped_' . $arg1 . '.txt';
$filename = "DOM/" . $arg1 . "_DOM.php";

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

$html = new simple_html_dom();
$html->load(file_get_contents($filename));

//build listing array
$listings = array();
foreach($html->find($listing_selector) as $listing){
  $listings[] = $listing;
}

//populate listing details
$field_index   = 0;
$listing_index = 0;
foreach($listings as $listing){
  foreach ($fields as $field_name => $value) {
    
  }
}
  






fclose($file);
flush();
exit();
////////////////////////////////////////
// HELPER FUNCTIONS
////////////////////////////////////////
function fwriteEcho($file,$string){
  echo $string;
  fwrite($file,$string);
  return;
}


?>
