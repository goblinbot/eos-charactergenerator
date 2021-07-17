<?php
// include the db.php connection. This file is not available on my github for security reasons.
// to make your own, see db.sample.php
// config variable.
$APP = array();

include_once($_SERVER["DOCUMENT_ROOT"] . '/eoschargen/db.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/eoschargen/_includes/joomla.php');


// opens an array to be filled later with the CSS and JS, which will eventually be included by PHP.
$APP["includes"] = array();

// location of the application. for example: http://localhost/chargen/ == '/chargen'. If the application is in the ROOT, you can leave this blank.
$APP["header"] = "/eoschargen";

// define the root folder by adding the header (location) to the server root, defined by PHP.
$APP["root"] = $_SERVER["DOCUMENT_ROOT"] . $APP["header"];

// define the login page to redirect to if there is no $jid set/inherited.
$APP["loginpage"] = "/return-to-chargen";

// $jid = 451;

