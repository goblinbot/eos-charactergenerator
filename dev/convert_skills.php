<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");


echo "<style>th,td { padding: 0 5px; }</style>";

// $sql = "SELECT id, char_sheet_id FROM `ecc_char_skills` ORDER BY char_sheet_id ASC";

$sql = "SELECT count(id) FROM ecc_char_skills";
$res = mysqli_fetch_assoc($UPLINK->query($sql));

(int)$LIMIT = 200;
(int)$COUNT = $res['count(id)'];
$RATIO = $COUNT / $LIMIT;
$ROUND = ceil($RATIO);

echo "Count: $COUNT <br/>";
echo "Limit: $LIMIT <br/>";
echo "Ratio: $RATIO<br/>";
echo "Round: $ROUND<br/>";

$NEXT = ((int)$_GET['limit'] + 1);
echo "Next: $NEXT<br/>";

if(isset($_GET['limit']) && (int)$_GET['limit'] < 0) {
  exit('Input Error.');
}

if(!isset($_GET['limit']) || $_GET['limit'] == "" || $_GET['limit'] == 0) {

  $FROM = 0;

} else if (isset($_GET['limit']) && $_GET['limit'] != "" && (int)$_GET['limit'] > 0) {

  $FROM = (((int)$_GET['limit'] * $LIMIT) + 1 );


} else if($_GET['limit'] > $ROUND) {
  echo "<h3>Done!</h3>";

  $sql = "ALTER TABLE `ecc_char_skills` CHANGE `char_sheet_id` `charID` INT(11) NOT NULL";
  $res = $UPLINK->query($sql);
  exit();

} else {
  exit('Uncaught error..');
}



$LIMITBY = "LIMIT $FROM, $LIMIT";

$sql = "SELECT s.id as id, s.char_sheet_id as char_sheet_id, h.charSheetID, h.characterID as characterID
  FROM ecc_char_skills s
  LEFT JOIN ecc_char_sheet h ON s.char_sheet_id = h.charSheetID
  ORDER BY char_sheet_id ASC
  $LIMITBY";

$res = $UPLINK->query($sql);

if($res) {
  if(mysqli_num_rows($res) > 0) {

    // echo "<table>
    // <tr>
    // <th style=\"width: 50px;\">#ID</th>
    //   <th style=\"width: 50px;\">SheetID</th>
    //   <th style=\"width: 550px;\">Character ID</th>
    // </tr>";

    while($row = mysqli_fetch_assoc($res)){

      if($row['characterID'] == NULL || $row['characterID'] == "") {


        // echo "<tr>
        // <td style=\"width: 50px;\">#{$row['id']}</td>
        // <td style=\"width: 50px;\">{$row['char_sheet_id']}</td>
        // <td style=\"width: 550px;\">Character not found! Removing leftovers..</td>
        // </tr>";

        // DELETE UITGEZET: DIT DOEN WE IVM PERFORMANCE/TIMEOUTS EEN ANDERE KEER
        // $sql3 = "DELETE FROM `ecc_char_skills` WHERE id = '".$row['id']."' ";
        // $res3 = $UPLINK->query($sql3);

      } else {

        // echo "<tr>
        //   <td style=\"width: 50px;\">#{$row['id']}</td>
        //   <td style=\"width: 50px;\">{$row['char_sheet_id']}</td>
        //   <td style=\"width: 550px;\"> => {$row['characterID']}</td>
        // </tr>";

        $sql2 = "UPDATE `ecc_char_skills`
          SET `char_sheet_id` = '{$row['characterID']}'
          WHERE id = '{$row['id']}'
          LIMIT 1";
        $update = $UPLINK->query($sql2) or trigger_error(mysqli_error($UPLINK));

      }

      // echo "<tr><td colspan=\"5\">$i</td></tr>";
    }

    // echo "</table>";

    echo '<script type="text/javascript">window.location = "convert_skills.php?limit='.$NEXT.'"</script>';

  } else {
    echo "<br/><h1>Update complete.</h1>";
    exit();
  }
} else {
  echo "<br/><h1>Update complete.</h1>";
  exit();
}
