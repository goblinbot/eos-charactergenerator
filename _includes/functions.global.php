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


// builds the left menu
function generateMenu($param = 'Home') {

  global $APP;

  class moduleObj {

    var $title = "title";
    var $icon = "fa fa-home";
    var $url = "/";

     function __construct() {
        //  print "In moduleObj constructor\n";
     }
  }

  $menuItems = array();

  $menuItems['home'] = new moduleObj();
  $menuItems['home']->title = 'Home';
  $menuItems['home']->url = '/';
  $menuItems['home']->icon = 'fa fa-home';

  $menuItems['characters'] = new moduleObj();
  $menuItems['characters']->title = 'Characters';
  $menuItems['characters']->url = '/';
  $menuItems['characters']->icon = 'fa fa-user';

  $menuItems['back'] = new moduleObj();
  $menuItems['back']->title = 'Back to site';
  $menuItems['back']->url = '/';
  $menuItems['back']->icon = 'fa fa-arrow-left';



}
