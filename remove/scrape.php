<?php
// MAIN ///////////////////////////////
///////////////////////////////////////

// error_reporting(E_ALL ^ E_NOTICE);

function fwriteEcho($file,$string){
  echo $string;
  fwrite($file,$string);
  return;
}

$arg1 = $argv[1];
$dump= $argv[2];
$config = "config/" . $arg1 . "_config.php";
$output = 'scraped/scraped_' . $arg1 . '.txt';
$page = "DOM/" . $arg1 . "_DOM.php";




// include callback functions
include('callbacks.php');

echo "including {$config}\n";
if(! file_exists($config)){
  echo "\nERROR: No file named {$config}";
  return;
}
// include the corresponding config
include($config);

$ret = 0;
if(! isset($url)){
  echo "\nERROR: {$config} does not set \$url";
  $ret = 1;
}
if(! isset($fields)){
  echo "\nERROR: {$config} does not set \$fields as an assoc. array";
  $ret = 1;
}
if(! isset($callback_array)){
  echo "\nERROR: {$config} does not set \$callback_array";
  $ret = 1;
}
if(! isset($fromWeb)){
  echo "\nERROR: {$config} does not set Boolean \$fromWeb";
  $ret = 1;
}
if($ret){
  exit;
}


  if($fromWeb){
    include('myScraper_fromWeb.php');
    echo "\nSCRAPING FROM WEB: @ $url\n";
    $page = $url;
  }
  else{
    include('myScraper_fromText.php');
    echo "\nSCRAPING FROM Text File: @ {$page}\nSourced from {$url}\n";
  }




$keys = array_keys($fields);
$len = count($keys);

echo "Opened " .$output."\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\t==SCRAPING INITIATED==\n\n";
$scraped_offers =   scrapeFor($page,$fields,$callback_array,$dump); // download page


$file = fopen( $output, 'w');

fwriteEcho($file, "Source:\t{$url}\n");
date_default_timezone_set('America/Los_Angeles');
fwriteEcho($file, "Date:\t" . date('l jS \of F Y h:i:s A') . "\n");
fwriteEcho($file, "# of Offers:\t" . count($scraped_offers) . "\n");
fwriteEcho($file, "Fields||Targets:\n");
foreach ($fields as $key => $value) {
  fwriteEcho($file, "\t{$key}\t||{$value[0]}\n");
}
fwriteEcho($file, "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");


$i=0;
foreach ($scraped_offers as $offer) {

  for ($j=0; $j < $len; $j++) {
    if($j==0){
      if(! isset($scraped_offers[$i][$j])){
        fclose($file);
        exit;
      }
      fwriteEcho($file, "Offer:\t" . $i ."\n");
    }
    if(isset($scraped_offers[$i][$j])){
      $val = $scraped_offers[$i][$j];
      if (strlen($val)==0){
        fwriteEcho($file, "\t" . $keys[$j] . ":\t\tN/A\n" );
      }
      else{
      fwriteEcho($file, "\t" . $keys[$j] . ":\t\t" . $val ."\n");
      }
    }
    else{
      fwriteEcho($file, "\t" . $keys[$j] . ":\t\tN/A\n" );
    }
  }
  fwriteEcho($file, "\n");
  $i++;
  // if($i==5)
    // exit;
}

fclose($file);
flush();



?>
