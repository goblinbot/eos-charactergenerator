<?php

include_once('db.php');

// config variable.
$APP = array();

// opens an array to be filled later with the CSS and JS, which will eventually be included by PHP.
$APP["includes"] = array();

// location of the application. for example: http://localhost/chargen/ == '/chargen'. If the application is in the ROOT, you can leave this blank.
$APP["header"] = "/eos-charactergenerator";

// define the root folder by adding the header (location) to the server root, defined by PHP.
$APP["root"] = $_SERVER["DOCUMENT_ROOT"] . $APP["header"];

// default includes. These stylesheets will be included into the HEADER.
$APP["includes"]["css"] = array(
  "/_includes/css/reset.css"
  ,"/_includes/css/style.css"
);

// default includes. These javascripts will be set in the FOOTER.
$APP["includes"]["js"] = array(
  "/_assets/js/jquery.min.js"
  ,"/_includes/js/functions.js"
);
