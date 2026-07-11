<?php
// globals
require_once __DIR__ . "/../_includes/includes.php";
require_once APP_ROOT . "/_includes/functions.global.php";


(string) $_FACTION = (isset($_GET['faction']) && $_GET['faction'] != "" ? $_GET['faction'] : '%');
(string) $_BUILDING = (isset($_GET['building']) && $_GET['building'] != "" ? $_GET['building'] : 'Bastion');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sheets</title>

  <style>
    html {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      font-size: 10px;
      background: #FFF;
    }

    body {
      font-family: arial;
      font-size: 12px;
      height: 297mm;
      width: 210mm;
      margin-left: auto;
      margin-right: auto;
      margin-top: 0;
      margin-bottom: 0;
      background: #FFF;
      background-image: url('../img/32033.png');
      background-position: top right;
      background-position: 95% 60px;
      background-repeat: no-repeat;
    }

    button {
      cursor: pointer;
      padding: 8px;
    }

    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      font-size: 12px;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 2px 5px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    @media print {
      #printPageButton {
        display: none;
      }
    }
  </style>

  <style type="text/css" media="print">
    @page {
      size: auto;
      /* auto is the initial value */
      margin: 0;
      /* this affects the margin in the printer settings */
    }
  </style>
</head>

<body>

  <?php
  $offset = 0;
  $perPage = 20;

  if (isset($_GET['characterID']) && (int) $_GET['characterID'] != 0) {
    require_once './getsheet.php';
  } else {
    require_once './listsheets.php';
  }

  echo "</div>";
  ?>

</body>

</html>