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

    $EVENTIDS = '(1,36,37,38,39,40,41,42,43,45,46,47,48,49,50,51,52,53,54,55,56,58,59,61,62,64,65,66,67,68,69,71,72,73,74,75,78,79,80,81,82,83,84,86,87,88,90,93,97,98,99,100,102,103,104,105,106,107,108,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,135,136,137,139,140,141,143,144,145,147,154,155,164,168,170,176,179,183,186,192,195,197,200,203,204,206,209,211,215,231,234)';

    $password = "MAATI420";

    if(isset($_POST['submit'])){
      if($_POST['password'] == $password){

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

        $sql = "SELECT `characterID`, `character_name`, `faction`, `rank` FROM `ecc_characters` WHERE `rank` NOT LIKE '%Conclav%' OR `rank` NOT LIKE '%Governor of%' ORDER BY `faction`, `rank`";
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

      } else {
        echo " :( ";
      }

    } else {
      ?><form method="post">
      Password: <input type="password" name="password" />
      <input type='submit' name='submit' />
      </form><?php
    }

    ?>
  </div>
  </body>
</html>
