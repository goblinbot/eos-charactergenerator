<?php
// globals
require_once "../_includes/includes.php";
//if there is no active session, start one
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($jid) || $jid == false || $jid == null || $jid == "") {

  if (!isset($APP["loginpage"]) || $APP["loginpage"] == "" || $APP["loginpage"] == "/" || $APP["loginpage"] == "#") {
    die('You are not logged in, and no valid login page has been set. Please contact Eos IT for more information. [ ERR: 101 ]');
    exit();
  } else {
      header("location: " . "/return-to-charsheet");
      exit();
    }
  }
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
      background-position: 95% 5px;
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
  require_once './show_sheet.php';
  ?>

</body>

</html>