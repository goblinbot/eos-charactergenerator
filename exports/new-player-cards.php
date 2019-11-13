<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
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

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>New Card Needed</h2>
<?php

$sql = "SELECT character_name, faction, ICC_number, card_id, characterID from ecc_characters WHERE characterID in 

(SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as id from jml_eb_registrants r
    join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
    join jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 14)
    where v2.field_value = 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method = 'os_paypal')) OR 
    (r.published in (0,1) AND r.payment_method = 'os_offline'))) AND card_id is NULL
    ORDER BY faction, character_name";
$res = $UPLINK->query($sql);
echo "<table>";
echo "<th>Faction</th>";
echo "<th>Name</th>";
echo "<th>ICC Number</th>";
echo "<th>Image Name</th>";
echo "</tr>";

while($row = mysqli_fetch_array($res))
{
    echo "<tr>";
    echo "<td>" . $row['faction'] . "</td>";
    echo "<td>" . $row['character_name'] . "</td>";
    echo "<td>" . $row['ICC_number'] . "</td>";
    echo "<td>" . $row['characterID'] . ".jpg</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>