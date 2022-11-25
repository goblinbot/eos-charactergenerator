<?php
// globals
// config variable.
$APP = array();

$APP["loginpage"] = "/component/users/?view=login";

include_once('../db.php');
include_once("../_includes/functions.global.php");

include_once('current-players.php');

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
  <!-- BEGIN BASTION SECTION -->
  <?php
  $building = 'Bastion';
  $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
  $res2 = $UPLINK->query($sql2);
  $row2 = mysqli_fetch_array($res2);
  $sql = "select r.id, ifnull(eetlocatie.field_value,slaaplocatie.field_value) as building, r.first_name as oc_fn, v3.field_value as oc_tv, 
  r.last_name as oc_ln, substring_index(v1.field_value,' - ',1) as ic_name, eetlocatie.field_value as eetlocatie_override 
from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
left join joomla.jml_eb_field_values slaaplocatie on (slaaplocatie.registrant_id = r.id and slaaplocatie.field_id = 36)
left join joomla.jml_eb_field_values eetlocatie on (eetlocatie.registrant_id = r.id and eetlocatie.field_id = 58)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 16)
left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 14)
where ifnull(eetlocatie.field_value,slaaplocatie.field_value) = '$building' AND v4.field_value = 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
(r.published in (0,1) AND r.payment_method = 'os_offline'))
UNION
select r.id, ifnull(eetlocatie.field_value,coalesce(figu_slaap.field_value,sl_slaap.field_value)) as building, r.first_name as oc_fn, v3.field_value as oc_tv, 
  r.last_name as oc_ln, NULL as ic_name, eetlocatie.field_value as eetlocatie_override 
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values figu_slaap on (figu_slaap.registrant_id = r.id and figu_slaap.field_id = 72)
  left join joomla.jml_eb_field_values sl_slaap on (sl_slaap.registrant_id = r.id AND sl_slaap.field_id = 73)
  left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 16)
  left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
  left join joomla.jml_eb_field_values eetlocatie on (eetlocatie.registrant_id = r.id and eetlocatie.field_id = 58)
  WHERE ifnull(eetlocatie.field_value,\"tweede gebouw\") = '$building' AND soort_inschrijving.field_value != 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
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
    echo "<tr>" . "<td>";
    if (isset($row['eetlocatie_override'])) {
    echo "<span style=\"color:red;\">****</span>" ; } 
    echo $row['oc_fn'] . " " . $row['oc_tv'] . " " . $row['oc_ln'];
    if (isset($row['eetlocatie_override'])) {
      echo "<span style=\"color:red;\">****</span>" ; }
    echo "</td>";
    echo '<td>' . $row['ic_name'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
  // END BASTION SECTION
  // BEGIN TWEEDE GEBOUW SECTION
  echo '<p class="single_record"></p>';
  $building = 'tweede gebouw';
  $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
  $res2 = $UPLINK->query($sql2);
  $row2 = mysqli_fetch_array($res2);
  $sql = "select r.id, ifnull(eetlocatie.field_value,slaaplocatie.field_value) as building, r.first_name as oc_fn, v3.field_value as oc_tv, 
  r.last_name as oc_ln, substring_index(v1.field_value,' - ',1) as ic_name, eetlocatie.field_value as eetlocatie_override
  from joomla.jml_eb_registrants r
  join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
  left join joomla.jml_eb_field_values slaaplocatie on (slaaplocatie.registrant_id = r.id and slaaplocatie.field_id = 36)
  left join joomla.jml_eb_field_values eetlocatie on (eetlocatie.registrant_id = r.id and eetlocatie.field_id = 58)
  left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 16)
  left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 14)
  where ifnull(eetlocatie.field_value,slaaplocatie.field_value) = '$building' AND v4.field_value = 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
  (r.published in (0,1) AND r.payment_method = 'os_offline'))
  UNION
  select r.id, ifnull(eetlocatie.field_value,coalesce(figu_slaap.field_value,sl_slaap.field_value)) as building, r.first_name as oc_fn, v3.field_value as oc_tv, 
  r.last_name as oc_ln, NULL as ic_name, eetlocatie.field_value as eetlocatie_override 
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values figu_slaap on (figu_slaap.registrant_id = r.id and figu_slaap.field_id = 72)
  left join joomla.jml_eb_field_values sl_slaap on (sl_slaap.registrant_id = r.id AND sl_slaap.field_id = 73)
  left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 16)
  left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
  left join joomla.jml_eb_field_values eetlocatie on (eetlocatie.registrant_id = r.id and eetlocatie.field_id = 58)
  WHERE ifnull(eetlocatie.field_value,\"tweede gebouw\") = '$building' AND soort_inschrijving.field_value != 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
  (r.published in (0,1) AND r.payment_method = 'os_offline')) ORDER BY oc_fn";
  $res = $UPLINK->query($sql);
  $row_count = mysqli_num_rows($res);
  echo '<font size="5">Eating Locations for ' . $row2['title'] . '</font> - '
    . "<font size='4'>Zonnedauw ($row_count)</font>";
  echo "<table>";
  echo "<th>OC Name</th>";
  echo "<th>IC Name</th>";
  echo "</tr>";

  while ($row = mysqli_fetch_array($res)) {
    echo "<tr>" . "<td>";
    if (isset($row['eetlocatie_override'])) {
    echo "<span style=\"color:red;\">****</span>" ; } 
    echo $row['oc_fn'] . " " . $row['oc_tv'] . " " . $row['oc_ln'];
    if (isset($row['eetlocatie_override'])) {
      echo "<span style=\"color:red;\">****</span>" ; }
    echo "</td>";
    echo '<td>' . $row['ic_name'] . "</td>";
    echo "</tr>";
  }
  echo "</table></p>";
  // END TWEEDE GEBOUW SECTION
  ?>
</body>

</html>