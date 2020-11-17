<?php
// globals
// config variable.
$APP = array();

// opens an array to be filled later with the CSS and JS, which will eventually be included by PHP.
$APP["includes"] = array();

// location of the application. for example: http://localhost/chargen/ == '/chargen'. If the application is in the ROOT, you can leave this blank.
$APP["header"] = "/eoschargen";

// define the root folder by adding the header (location) to the server root, defined by PHP.
$APP["root"] = $_SERVER["DOCUMENT_ROOT"] . $APP["header"];

// define the login page to redirect to if there is no $jid set/inherited.
$APP["loginpage"] = "https://new.eosfrontier.space/component/users/?view=login";

// $jid = 451;
include_once($_SERVER["DOCUMENT_ROOT"] . '/eoschargen/db.php');
include_once($APP["root"] . "/_includes/functions.global.php");

include_once($APP["root"] . '/exports/current-players.php');


?>
<!DOCTYPE html>
<html>

<head>
  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 2px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    body {
      font-family: arial;
      font-size: 10px;
      height: 297mm;
      width: 210mm;
      margin-left: auto;
      margin-right: auto;
      margin-top: 0;
      margin-bottom: 0;
      background: #FFF;
      background-image: url('../img/32033.png');
      background-position: top right;
      background-position: 65% 0px;
      background-repeat: no-repeat;
    }

    .single_record {
      page-break-after: always;
    }

    .button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }

    @media print {
      #printPageButton {
        display: none;
      }

      * {
        -webkit-print-color-adjust: exact;
      }
    }
  </style>
</head>
<?php

$sql = "SELECT title FROM jml_eb_events where id = $EVENTID;";
$res = $UPLINK->query($sql);
$row = mysqli_fetch_array($res);

echo '<h1>Allergy report for ' . $row['title'] . '</h1>';
?>

<body>
  <?php

  $sql = "select replace(replace(v2.field_value,'[',''),']',',') as diet from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 56)
WHERE r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
(r.published in (0,1) AND r.payment_method = 'os_offline')) ORDER BY diet;";
  $res = $UPLINK->query($sql);

  $all_allergies = '';
  while ($row = mysqli_fetch_array($res)) {
    $all_allergies .= str_replace(
      "\\u00eb",
      "e",
      str_replace("\\u00cb", "E", $row['diet'])
    );
  };
  // echo($all_allergies) . "</br>";
  $allergy_array = explode("\",\"", rtrim(ltrim($all_allergies, "\""), "\","));

  $allergy_counts = array_count_values($allergy_array);
  arsort($allergy_counts);
  echo '<p><button class="button" id="printPageButton" style="width: 100px;" onClick="window.print();">Print</button></p>';

  echo "<font size=5>Summary</font>";
  echo "<table><font size=3>";
  foreach ($allergy_counts as $key => $val) {
    echo "<tr>";
    echo "<td>" . $key . "</td><td>" . $val . "</td></tr>";
  }
  echo "</font></table>";
  echo '<p class="single_record"></p>';
  echo "<font size=5>Detail</font>";
  echo "<table>";
  echo "<th>Name</th><th>Allergie</th><th>Dieet</th><th>Other Allergies</th>";
  $sql = "select replace(replace(v2.field_value,'[',''),']',',') as diet, concat(r.first_name,' ',r.last_name) as name, v3.field_value as other from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 56)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 57)
WHERE r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
(r.published in (0,1) AND r.payment_method = 'os_offline')) ORDER BY diet desc;";
  $res = $UPLINK->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    echo "<tr><td>" . $row['name'] . "</td>";
    //Store the item in an array for
    $item = rtrim(str_replace("Allium(ui,prei,knoflook,bieslook,etc)", "Allium(ui;prei;knoflook;bieslook;etc)", str_replace(
      "\\/",
      "/",
      str_replace(
        "\"",
        "",
        str_replace(
          "\",\"",
          ",  ",
          str_replace(
            "\\u00eb",
            "e",
            str_replace("\\u00cb", "E", $row['diet'])
          )
        )
      )
    )), ",");
    $row_things = explode(",", $item);
    echo "<td>";
    for ($x = 0; $x < count($row_things); $x++) {
      if (preg_match("/Allergie.*$/i", $row_things[$x]) == 1) {
        echo str_replace("Allergie: ", '', $row_things[$x]) . ",";
      }
    };
    echo "</td><td>";
    for ($x = 0; $x < count($row_things); $x++) {
      if (preg_match("/Dieet:.*$/i", $row_things[$x]) == 1) {
        echo str_replace("Dieet: ", '', $row_things[$x]) . ",";
      }
    };
    //echo $x . " " . $row_things[$x];

    //for ($x = 0; $x < count($row_things); $x++) {
    //   echo $x . " " . $row_things[$x] . " " . preg_match('/Dieet:.*$/i', $row_things[$x]) . "<br>";
    //   if (preg_match('/Dieet:.*$/i', $row_things[$x]) === 1){
    //     echo str_replace('Dieet: ','',$row_things[$x]) . ",";
    //};

    // echo "</td>";
    echo "<td>" . $row['other'] . "</td></tr>";
  };


  echo "</table>";
  ?>
</body>

</html>