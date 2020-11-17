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
    body {
      background: #262e3e;
      color: white;
    }

    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
      color: white;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 2px 4px;
      font-size: 16px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
      color: black;
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

      body {
        background-color: #fff;
        color: #000;
        font-size: 10px;
      }

      table {
        color: #000;
        border-collapse: collapse;
        padding: 1px 5px;
        font-size: 8px;
        width: 95%;
        margin-left: auto;
        margin-right: auto;
      }

      td,
      th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 0px 0px;
        font-size: 10px;
      }

      .single_record {
        page-break-after: always;
      }
    }
  </style>
</head>

<body>
  <?php
  $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
  $res2 = $UPLINK->query($sql2);
  $row2 = mysqli_fetch_array($res2);
  $sql = "select r.id, v2.field_value as building, r.first_name as oc_fn, v3.field_value as oc_tv, r.last_name as oc_ln, substring_index(v1.field_value,' - ',1) as ic_name 
from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 58)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 16)
where v2.field_value = 'Bastion' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
(r.published in (0,1) AND r.payment_method = 'os_offline')) ORDER BY oc_fn";
  $res = $UPLINK->query($sql);
  $row_count = mysqli_num_rows($res);
  echo '<button class="button" id="printPageButton" style="width: 100px;" onClick="window.print();">Print</button>';
  echo '<font size="5">Eating Locations for ' . $row2['title'] . '</font> - '
    . "<font size='4'>Bastion ($row_count)</font>";
  echo "<table>";
  echo "<th>OC Name</th>";
  echo "<th>IC Name</th>";
  echo "</tr>";

  while ($row = mysqli_fetch_array($res)) {
    echo "<tr>";
    echo "<td>" . $row['oc_fn'] . " " . $row['oc_tv'] . " " . $row['oc_ln'] . "</td>";
    echo '<td>' . $row['ic_name'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
  ?>
  <?php
  echo '<p class="single_record"></p>';
  $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
  $res2 = $UPLINK->query($sql2);
  $row2 = mysqli_fetch_array($res2);
  $sql = "select r.id, v2.field_value as building, r.first_name as oc_fn, v3.field_value as oc_tv, r.last_name as oc_ln, substring_index(v1.field_value,' - ',1) as ic_name 
from joomla.jml_eb_registrants r
left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 58)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 16)
where v2.field_value = 'Zonnedauw' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
(r.published in (0,1) AND r.payment_method = 'os_offline'))
UNION
select r.id, v2.field_value as building, r.first_name as oc_fn, v3.field_value as oc_tv, r.last_name as oc_ln, substring_index(v1.field_value,' - ',1) as ic_name 
from joomla.jml_eb_registrants r
left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 58)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 16)
where (r.is_group_billing != 1 AND v2.field_value is NULL) AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
(r.published in (0,1) AND r.payment_method = 'os_offline')) ORDER by oc_fn;";
  $res = $UPLINK->query($sql);
  $row_count = mysqli_num_rows($res);
  echo '<font size="5">Eating Locations for ' . $row2['title'] . '</font> - '
    . "<font size='4'>Zonnedauw ($row_count)</font>";
  echo "<table>";
  echo "<th>OC Name</th>";
  echo "<th>IC Name</th>";
  echo "</tr>";

  while ($row = mysqli_fetch_array($res)) {
    echo "<tr>";
    echo "<td>" . $row['oc_fn'] . " " . $row['oc_tv'] . " " . $row['oc_ln'] . "</td>";
    echo '<td>' . $row['ic_name'] . "</td>";
    echo "</tr>";
  }
  echo "</table></p>";
  ?>
</body>

</html>