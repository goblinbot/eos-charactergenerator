<?php
// globals
// config variable.
$APP = array();

// define the login page to redirect to if there is no $jid set/inherited.
#$APP["loginpage"] = "/component/users/?view=login";
include_once __DIR__ . "/../_includes/includes.php";
include_once('../db.php');
include_once("../_includes/functions.global.php");
include_once('current-players.php');
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="../_includes/css/allergy-report.css">
</head>

<body>
  <?php
  $sql = "SELECT title FROM jml_eb_events where id = $EVENTID;";
  $res = $UPLINK->query($sql);
  $row = mysqli_fetch_array($res);

  echo '<h1>Diet/Allergy report for ' . $row['title'] . '</h1>';
  $sql = "SELECT count(v4.field_value) as no_restrictions
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 55)
  WHERE r.event_id = $EVENTID AND v4.field_value='No'
  AND $notCancelled";
  $res = $UPLINK->query($sql);
  $row = mysqli_fetch_array($res);

  echo '<h2><strong>Deelnemers zonder dieetbeperkingen of allergenen:</strong>' . $row['no_restrictions'] . '</h2>';
  date_default_timezone_set('Europe/Amsterdam');
  $date = date('d-m-y h:i:s');
  echo '<h3>Printed on:' . $date . '</h3>';
  $stmt = db::$conn->prepare("SELECT replace( replace(v2.field_value, ']',''), '[', '') as result
    from joomla.jml_eb_registrants r
    join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 56)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 55)
    WHERE r.event_id = $EVENTID
    AND $notCancelled ORDER by result");

  $res_pdo = $stmt->execute();
  $results = $stmt->fetchAll();

  $diet_array = [];
  $allergie_array = [];

  foreach ($results as $result) {
    $items_array = explode(',', $result['result']);

    foreach ($items_array as $item) {
      $item = str_replace('"', '', $item);
      $item = str_replace('\\/', '/', $item);
      $item = str_replace('u00cb', 'u00eb', $item);
      $item = str_replace('\u', 'u', $item);
      $item = preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $item);
      $item = strtolower($item);

      if (strpos($item, 'dieet') !== false) {
        $item = str_replace('dieet: ', '', $item);
        $diet_array[] = $item;
      }

      if (strpos($item, 'allergie') !== false) {
        $item = str_replace('allergie: ', '', $item);
        $allergie_array[] = $item;
      }
    }
  }

  $allergy_count = array_count_values($allergie_array);
  arsort($allergy_count);
  $diet_count = array_count_values($diet_array);
  arsort($diet_count);

  echo '<p><button class="button" id="printPageButton" style="width: 100px;" onClick="window.print();">Print</button></p>';
  echo '<div id="summary">';
  echo "<h2 align='left'>Summary</h2>";
  echo "<table style='float: left;' width='50%'><font size=3>";
  echo "<th>Dieet</th>";
  echo "<th>hoeveelheid</th>";
  foreach ($diet_count as $key => $val) {
    echo "<tr>";
    echo "<td>" . $key . "</td><td>" . $val . "</td></tr>";
  }
  echo "</font></table>";
  echo '</table>';
  echo '<table>';
  echo "<table style='float: left;' width='50%'><font size=3>";
  echo "<th>Allergieen</th>";
  echo "<th>hoeveelheid</th>";
  foreach ($allergy_count as $key => $val) {
    echo "<tr>";
    echo "<td>" . $key . "</td><td>" . $val . "</td></tr>";
  }
  echo "</font></table>";
  echo '</div>'; # end summary div
  echo '<div class="single_record"></div>';
  echo "<h2>Detail</h2>";
  $sql = "SELECT count(v4.field_value) as restrictions
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 55)
  WHERE r.event_id = $EVENTID AND v4.field_value='Yes'
  AND $notCancelled";
  $res = $UPLINK->query($sql);
  $row = mysqli_fetch_array($res);

  echo '<h2><strong>Deelnemers met dieetbeperkingen of allergenen:</strong>' . $row['restrictions'] . '</h2>';
  echo "<table class='main' width='100%'>";
  echo "<thead><th>Name</th><th>E-Mail</th> </th><th>Allergie</th><th>Dieet</th><th>Other Allergies</th></thead>";

  $stmt2 = db::$conn->prepare("SELECT concat(r.first_name,' ', COALESCE(tussenvoegsel.field_value,' '), ' ',r.last_name) as name, email, replace( replace(v2.field_value, ']',''), '[', '') as result,
  v3.field_value as other
  from joomla.jml_eb_registrants r
  join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 56)
  left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 57)
  left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
  WHERE r.event_id = $EVENTID
  AND $notCancelled ORDER by name");
  $res_pdo2 = $stmt2->execute();
  $results2 = $stmt2->fetchAll();

  // $sql = "SELECT replace(replace(replace(v2.field_value,'[',''),']',','),\"Allium(ui,prei,knoflook,bieslook,etc)\", \"Allium(ui;prei;knoflook;bieslook;etc)\") as diet, concat(r.first_name,' ', COALESCE(tussenvoegsel.field_value,' '), ' ',r.last_name) as name, 
  //     v3.field_value as other from joomla.jml_eb_registrants r
  //       join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 56)
  //       left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 57)
  //       left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
  //       left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
  //       WHERE r.event_id = $EVENTID
  //       AND $notCancelled  ORDER BY diet desc;";

  foreach ($results2 as $row) {
    echo "<tr><td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    //Store the item in an array for
    $item = str_replace('"', '', $row['result']);
    $item = str_replace('\\/', '/', $item);
    $item = str_replace('u00cb', 'u00eb', $item);
    $item = str_replace('\u', 'u', $item);
    $item = preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $item);
    $item = strtolower($item);
    $row_things = explode(",", $item);
    echo "<td>";
    for ($x = 0; $x < count($row_things); $x++) {
      if (preg_match("/allergie.*$/i", $row_things[$x]) == 1) {
        echo str_replace("allergie: ", '', $row_things[$x]) . "<br>";
      }
    };
    echo "</td><td>";
    arsort($row_things);
    for ($x = 0; $x < count($row_things); $x++) {
      if (preg_match("/dieet:.*$/i", $row_things[$x]) == 1) {
        echo str_replace("dieet: ", '', $row_things[$x]) . "<br>";
      }
    };
    echo "<td>" . $row['other'] . "</td></tr>";
  };
  echo "</table>";
  ?>
  <br>
</body>

</html>