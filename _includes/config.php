<?php

// config variable.
$APP = array();


// opens an array to be filled later with the CSS and JS, which will eventually be included by PHP.
$APP["includes"] = array();

// Dynamically retrieves the location of the application. for example: http://localhost/chargen/ == '/chargen'. If the application is in the ROOT, you can leave this blank.
// Get the directory of the current script (e.g., "/eoschargen" or "/")
// Get the path part of the URL (e.g., /eos-charactergenerator/exports/participants.php)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Split the path into segments
$segments = explode('/', trim($requestUri, '/'));

// Grab the first segment (the project folder name)
$projectFolderName = isset($segments[0]) ? $segments[0] : '';

// Rebuild the header path
// This will consistently return "/eos-charactergenerator"
$APP["header"] = '/' . $projectFolderName;
// define the login page to redirect to if there is no $jid set/inherited.
# $APP["loginpage"] = "/return-to-chargen"; Commented because we're using the declaration from joomla.php

// __DIR__ returns the directory of THIS file (the root)
// __DIR__ is .../project/_includes
// dirname(__DIR__) moves up one level to .../project/
define('APP_ROOT', dirname(__DIR__));

// Web Path (for Browser/HTML)
// This creates a path like "/eos-charactergenerator" 
define('WEB_ROOT', str_replace($_SERVER['DOCUMENT_ROOT'], '', APP_ROOT));