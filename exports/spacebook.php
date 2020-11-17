<?php
include_once('current-players.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>


  <!-- 336 breed 192 hoog -->

  <style media="screen">
    body {
      font-family: arial;
      color: white;
    }

    p {
      margin-top: 2px;
    }
  </style>
</head>

<body>
  <div class="" style="max-width: 700px;">

    <?php

    include_once('../db.php');

    $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as characterID, c1.character_name, c1.faction, c1.rank
				from jml_eb_registrants r
				join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
				join ecc_characters c1 on c1.characterID = SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1)
				where r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
				(r.published in (0,1) AND r.payment_method = 'os_offline')) AND (`rank` LIKE '%conc%' OR `rank` like '%Governor%') ORDER by character_name;";
    $res = $UPLINK->query($sql);


    if ($res) {
      if (mysqli_num_rows($res) > 0) {

        $count = 0;

        while ($row = mysqli_fetch_assoc($res)) {

          if ($count == 0) {
            echo "<div style=\"float: left; margin: 5px; border: 1px solid #222; width: 336px; height: 192px;\">";
            $count = 1;
          }

          echo "<div style=\"padding: 5px; float: left; height: 86px; width: 100%;\">"
            . "<img src=\"../img/passphoto/" . $row['characterID'] . ".jpg\" style=\"height: 80px; width: 80px; float: left; border-radius: 100%;\" />"

            . "<p style=\"position: relative; padding-left: 5px;\">"
            . "<strong>" . ucfirst($row['character_name']) . "</strong>"
            . "<br/>" . ucfirst($row['rank'])
            . "<br/>" . ucfirst($row['faction'])
            . "</p>"

            . "</div>";

          if ($count == 2) {
            echo "</div>";
            $count = 0;
          } else if ($count == 1) {
            $count = 2;
          }
        }

        // echo "</div>";
      }
    }

    $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as characterID, c1.character_name, c1.faction, c1.rank
				from jml_eb_registrants r
				join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
				join ecc_characters c1 on c1.characterID = SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1)
				where (r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method = 'os_paypal')) OR (r.published in (0,1) AND r.payment_method = 'os_offline'))) 
				AND (c1.rank NOT LIKE '%Conclav%' AND c1.rank NOT LIKE '%Governor of%') ORDER by c1.faction, c1.character_name 	;";
    $res = $UPLINK->query($sql);

    if ($res) {
      if (mysqli_num_rows($res) > 0) {

        $count = 0;

        while ($row = mysqli_fetch_assoc($res)) {

          if ($count == 0) {
            echo "<div style=\"float: left; margin: 5px; border: 1px solid #222; width: 336px; height: 192px;\">";
            $count = 1;
          }

          echo "<div style=\"padding: 5px; float: left; height: 86px; width: 100%;\">"
            . "<img src=\"../img/passphoto/" . $row['characterID'] . ".jpg\" style=\"height: 80px; width: 80px; float: left; border-radius: 100%;\" alt=\"x\"/>"

            . "<p style=\"position: relative; padding-left: 5px;\">"
            . "<strong>" . ucfirst($row['character_name']) . "</strong>"
            . "<br/>" . ucfirst($row['rank'])
            . "<br/>" . ucfirst($row['faction'])
            . "</p>"

            . "</div>";

          if ($count == 2) {
            echo "</div>";
            $count = 0;
          } else if ($count == 1) {
            $count = 2;
          }
        }

        // echo "</div>";
      }
    }

    ?>
  </div>
</body>

</html>