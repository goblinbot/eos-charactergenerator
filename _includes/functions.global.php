<?php

// include the CSS based on global config
function EMSincludeCSS() {

  global $APP;
  $printresult = "";

  if(isset($APP["includes"]["css"]) && count($APP["includes"]["css"]) > 0) {
    foreach($APP["includes"]["css"] AS $stylesheetUrl){
      $printresult .=  "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$APP["header"] . $stylesheetUrl."\" />\n";
    }
  } else {
    // ERR:
  }
  return $printresult;
}

// include the JS based on global config
function EMSincludeJS() {

  global $APP;
  $printresult = "";

  if(isset($APP["includes"]["js"]) && count($APP["includes"]["js"]) > 0) {
    foreach($APP["includes"]["js"] AS $javascriptUrl){
      $printresult .= "\t<script type=\"text/javascript\" src=\"". $APP["header"] . $javascriptUrl ."\"></script>\n";
    }
  } else {
    // ERR:
  }
  return $printresult;
}
