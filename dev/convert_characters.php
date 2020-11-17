<?php
// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");
include_once($APP["root"] . "/_includes/functions.sheet.php");


echo "<style>th,td { padding: 0 5px; }</style>";

// STAP 0: kijk of de update niet al gedaan is.
$sql = "SELECT aantal_events FROM `ecc_characters`";
$res = $UPLINK->query($sql);

if ($res) {
  echo "Update is already done. Exitting.";
  exit();

  if (mysqli_num_rows($res) > 0) {
    echo "Update is already done. Exitting.";
    exit();
  }
} else {
  echo "Time to update. <br/>";
  // exit();
}

// 1: verander OC name naar aantal_events, en zet hem om naar een int.
$sql = "ALTER TABLE `ecc_characters` CHANGE `oc_name` `aantal_events` INT(11) NOT NULL DEFAULT '0';";
$res = $UPLINK->query($sql);

// 2: haal de bestaande aantal_events uit SHEETS op en voeg ze toe aan CHARACTERS.
$sql = "SELECT charSheetID, characterID, MAX(aantal_events) AS aantal_events, versionNumber FROM `ecc_char_sheet` GROUP BY characterID ORDER BY characterID ASC";
$res = $UPLINK->query($sql);

if ($res) {
  if (mysqli_num_rows($res) > 0) {

    echo "<table>";
    echo "<tr>
        <th>charID</th>
        <th>sheetID</th>
        <th>EXP</th>
        <th>Version</th>
      </tr>";

    while ($row = mysqli_fetch_assoc($res)) {

      echo "<tr>
          <td>{$row['characterID']}</td>
          <td>{$row['charSheetID']}</td>
          <td>{$row['aantal_events']}</td>
          <td>{$row['versionNumber']}</td>
        </tr>";

      $sql2 = "UPDATE `ecc_characters`
          SET `aantal_events` = '{$row['aantal_events']}'
          WHERE characterID = '{$row['characterID']}'
          LIMIT 1";
      $update = $UPLINK->query($sql2) or trigger_error(mysqli_error($UPLINK));
    }

    echo "</table>";
  }
}
