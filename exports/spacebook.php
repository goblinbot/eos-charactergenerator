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

      $sql = "SELECT `characterID`, `character_name`, `faction`, `rank` FROM `ecc_characters` WHERE `rank` LIKE '%conc%' OR `rank` like '%Governor of E%' AND `characterID` IN $EVENTIDS";
      $res = $UPLINK->query($sql);

      if($res) {
        if(mysqli_num_rows($res) > 0) {

          $count = 0;

          while($row = mysqli_fetch_assoc($res)) {

            if($count == 0) {
              echo "<div style=\"float: left; margin: 5px; border: 1px solid #222; width: 336px; height: 192px;\">";
              $count = 1;
            }

            echo "<div style=\"padding: 5px; float: left; height: 86px; width: 100%;\">"
                . "<img src=\"../img/passphoto/".$row['characterID'].".jpg\" style=\"height: 80px; width: 80px; float: left; border-radius: 100%;\" />"

                . "<p style=\"position: relative; padding-left: 5px;\">"
                  ."<strong>" . ucfirst($row['character_name']) . "</strong>"
                  . "<br/>" . ucfirst($row['rank'])
                  . "<br/>" .ucfirst($row['faction'])
                ."</p>"

              . "</div>";

            if($count == 2) {
              echo "</div>";
              $count = 0;
            } else if($count == 1) {
              $count = 2;
            }

          }

          // echo "</div>";
        }
      }

      $sql = "SELECT `characterID`, `character_name`, `faction`, `rank` FROM `ecc_characters` WHERE `rank` NOT LIKE '%Conclav%' OR `rank` NOT LIKE '%Governor of%' AND `characterID` IN $EVENTIDS ORDER BY `faction`, `rank`";
      $res = $UPLINK->query($sql);

      if($res) {
        if(mysqli_num_rows($res) > 0) {

          $count = 0;

          while($row = mysqli_fetch_assoc($res)) {

            if($count == 0) {
              echo "<div style=\"float: left; margin: 5px; border: 1px solid #222; width: 336px; height: 192px;\">";
              $count = 1;
            }

            echo "<div style=\"padding: 5px; float: left; height: 86px; width: 100%;\">"
                . "<img src=\"../img/passphoto/".$row['characterID'].".jpg\" style=\"height: 80px; width: 80px; float: left; border-radius: 100%;\" alt=\"x\"/>"

                . "<p style=\"position: relative; padding-left: 5px;\">"
                  ."<strong>" . ucfirst($row['character_name']) . "</strong>"
                  . "<br/>" . ucfirst($row['rank'])
                  . "<br/>" .ucfirst($row['faction'])
                ."</p>"

              . "</div>";

            if($count == 2) {
              echo "</div>";
              $count = 0;
            } else if($count == 1) {
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
