<?php
// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");
include_once($APP["root"] . "/_includes/functions.sheet.php");

echo "<style>th,td { padding: 0 5px; }</style>";

$sql = "SELECT modifierID, sheetID, accountID, description FROM `ecc_char_implants` ORDER BY accountID ASC";
$res = $UPLINK->query($sql);

if ($res) {
  if (mysqli_num_rows($res) > 0) {

    echo "<table>
    <tr>
    <th style=\"width: 50px;\">#ID</th>
      <th style=\"width: 50px;\">SheetID</th>
      <th style=\"width: 50px;\">CharID</th>
      <th>text</th>
    </tr>";

    while ($row = mysqli_fetch_assoc($res)) {

      $sql2 = "SELECT characterID FROM `ecc_char_sheet` WHERE charSheetID = '" . $row['sheetID'] . "' LIMIT 1";
      $res2 = $UPLINK->query($sql2);
      $row2 = mysqli_fetch_assoc($res2);


      echo "<tr>
        <td style=\"width: 50px;\">#{$row['modifierID']}</td>
        <td style=\"width: 50px;\">{$row['sheetID']}</td>
        <td style=\"width: 50px;\"> => {$row2['characterID']}</td>
        <td>" . substr($row['description'], 0, 49) . "</td>
      </tr>";


      $sql3 = "UPDATE `ecc_char_implants`
        SET `sheetID` = '{$row2['characterID']}'
        WHERE modifierID = '{$row['modifierID']}'
        AND accountID = '{$row['accountID']}'
        LIMIT 1";
      $update = $UPLINK->query($sql3) or trigger_error(mysqli_error($UPLINK));

      echo "<tr><td colspan=\"5\">&nbsp;</td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
    }

    echo "</table>";

    //
    $sql = "ALTER TABLE `ecc_char_implants` CHANGE `sheetID` `charID` INT(11) NOT NULL";
    $res = $UPLINK->query($sql);
  } else {
    echo "Update complete.";
  }
} else {
  echo "Update complete.";
}
