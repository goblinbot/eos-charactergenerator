<?php

// database connection parameters
$HOST  =    '127.0.0.1'; // if hosting on localhost, use 127.0.0.1 instead of localhost : this is SECONDS faster in performance when handling big data.
$USER  =    'username';
$PASS  =    'passcode';
$DB    =    'my_database';

// create the mysqli connection.
$UPLINK = mysqli_connect($HOST, $USER, $PASS, $DB);
unset($HOST);
unset($USER);
unset($PASS);
unset($DB);
