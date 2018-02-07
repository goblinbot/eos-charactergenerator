<?php
  if (!isset($APP)) die('No direct access allowed');


  $TIJDELIJKEID = 451;
  $COMINGEVENT = "Frontier9";
  $sheetArr = getCharacterSheets();
?>

<!DOCTYPE html>
<html lang="en" style="background-color:#262e3e;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CHARGEN</title>

  <link rel="stylesheet" type="text/css" href="<?=$APP['header']?>/_includes/css/reset.css" />
  <link rel="stylesheet" type="text/css" href="<?=$APP['header']?>/_includes/css/style.css" />

</head>
<body class="notransition">
  <div class="grid">

    <div id="topcell" class="logo cell">

    </div>
