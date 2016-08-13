<?php
require_once "support/http.php";
require_once "support/web_browser.php";
require_once "support/simple_html_dom.php";


function scrapeFor ($page,$findArgs,$callback_array,$dump){
  // Simple HTML DOM tends to leak RAM like
  // a sieve.  Declare what you will need here.
  // Objects are reusable.

  $html = new simple_html_dom();
 


	$ret = array();
  $rows = array();


  // parse the html with each successive call_back
  if(isset($callback_array)){
    echo "callback_array is set \t Count == " . count($callback_array)."\n\n";
    global $started;
    for($i=0;$i<count($callback_array);$i++){
      $started =0;
      echo "callback_array[$i]\n";

      // load
      if($i==0){
        $html->load(file_get_contents($page));
      }
      else{
        $html->clear();
        $html->load($rows);
      }

      //set call back
      echo "\t Set \t callback: " . $callback_array[$i][0]."\n";
      $html->set_callback($callback_array[$i][0]);

      //find prospective lines
      echo "\t Set \t find: " . $callback_array[$i][1]."\n";
      $rows = $html->find($callback_array[$i][1]);
      echo "row count ==" . count($rows) . "\n\n";
      //invoke callbacks on all lines
      $newrows = array();
      foreach ($rows as $row) {
        // invoke callback
        echo substr($row,0,0);
        array_push($newrows, $row);
      }
      $rows= join("\n",$newrows);
      
    }
    echo "Pre-processing Complete \n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
    $html->clear();
    $html->load($rows);
    if($dump == 'dump'){
      echo " OUPUT DUMPED TO credit_dump.php";
      $file2 = fopen( "credit_dump.php", 'w');
       fwrite ($file2,$rows);
      fclose($file2);
      flush();
      exit;
    }

  }


  $i=0;
  foreach ($findArgs as $ele) {
    $j =0;
    $rows = $html->find($ele[0]);
  	foreach ($rows as $row)
  	{
      $ret [$j][$i]=  $row->$ele[1];
      $j++;
      if($j==125){
        // die("125+ items. Canceling");
        // break;
      }
    }
    $i++;
    if($i==10){
      die("10+ parameters per item. Canceling");
      break;
    }
  }
  flush();
  return $ret;
}


?>
