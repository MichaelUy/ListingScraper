<?php
require_once "support/http.php";
require_once "support/web_browser.php";
require_once "support/simple_html_dom.php";

//passed a string and selector 
//return array of selected rows froms string
function finds($string,$find){
  $html = new simple_html_dom();
  $html->load($string);

	$ret = array();
    foreach ($html->find($find) as $row ) {//foreach param
      $ret[] = $row;
    }
  return $ret;
}


?>
