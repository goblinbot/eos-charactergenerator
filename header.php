<?php
  if (!isset($APP)) die('No direct access allowed');


  if(!isset($jid) || $jid == false || $jid == null || $jid == "") {
    die('You are not logged in. If this message keeps showing, please contact Eos IT. [ERR 101]');
  }

  $CSSVERSION = "?" . time();

  $COMINGEVENT = "Frontier9";
  $sheetArr = getCharacterSheets();
?>

<!DOCTYPE html>
<html lang="en" style="background-color:#262e3e;">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <noscript>
    <style>div { display:none!important; }</style>
  </noscript>

  <title>CHARGEN</title>

  <link rel="stylesheet" type="text/css" href="<?=$APP['header']?>/_includes/css/reset.css" />
  <link rel="stylesheet" type="text/css" href="<?=$APP['header']?>/_includes/css/style.css<?=EMS_echo($CSSVERSION)?>" />
</head>
<body class="notransition" onload="">

  <noscript>
    <p style="font-size:24px;padding:30px 15px;text-align:center;">This application needs JavaScript to work. Please enable JavaScript.</p>
    <p style="text-align:center;">:(</p>
  </noscript>

  <div class="grid">

    <div class="logo cell">
      <img class="responsive" src="<?=$APP['header']?>/img/outpost.png" alt="OUTPOST" title="OUTPOST"/>
    </div>
