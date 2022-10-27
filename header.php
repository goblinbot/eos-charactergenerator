<?php
if (!isset($APP)) die('No direct access allowed');

if (!isset($jid) || $jid == false || $jid == null || $jid == "") {

  if (!isset($APP["loginpage"]) || $APP["loginpage"] == "" || $APP["loginpage"] == "/" || $APP["loginpage"] == "#") {
    die('You are not logged in, and no valid login page has been set. Please contact Eos IT for more information. [ ERR: 101 ]');
    exit();
  } else {

    header("location: " . $APP["loginpage"]);
    exit();
  }
}

if ( !isset($APP["allowed_groups"]) || ( isset($APP["allowed_groups"]) &&  !empty(array_intersect($jgroups, $APP["allowed_groups"])))){
$sheetArr = getCharacterSheets();
} else {
echo "Access denied. Please contact a member of the organization to be granted CharGen access.";
exit();
}
?>

<!DOCTYPE html>
<html lang="en" style="background-color:#262e3e;">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="theme-color" content="#262e3e">

  <noscript>
    <style>
      div {
        display: none !important;
      }
    </style>
  </noscript>

  <title>CHARGEN</title>

  <link rel="stylesheet" type="text/css" href="<?= $APP['header'] ?>/_includes/css/reset.css" />
  <link rel="stylesheet" type="text/css" href="<?= $APP['header'] ?>/_includes/css/style.css" />

  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <body class="notransition" onload="">

    <noscript>
      <p style="font-size:24px;padding:30px 15px;text-align:center;">This application needs JavaScript to work. Please enable JavaScript.</p>
      <p style="text-align:center;">:(</p>
    </noscript>

    <div class="grid">

      <div class="logo cell">
        <img class="responsive" src="<?= $APP['header'] ?>/img/outpost-icc-pm.png" alt="logo" title="ICC logo" />
      </div>
