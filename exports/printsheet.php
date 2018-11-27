<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");

  include_once('current-players.php');

  (string)$_FACTION = (isset($_GET['faction']) && $_GET['faction'] != "" ? $_GET['faction'] : 'aquila' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sheets</title>


  <style>
    html{
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      font-size: 10px;
      background: #EEE;
    }
    body {
      font-family: arial;
      font-size: 14px;
      height:297mm;
      width:210mm;
      margin-left:auto;
      margin-right:auto;
      margin-top: 0;
      margin-bottom: 0;
      background: #FFF;
      background-image: url('../img/32033.png');
      background-position: top right;
      background-position: 95% 15px;
      background-repeat: no-repeat;
    }
    button {
      cursor: pointer;
      padding: 8px;
    }
    table {
      width: 100%;
    }
    th, td {
      padding: 5px;
      text-align: left;
    }
  </style>

  <style type="text/css" media="print">
  @page {
      size: auto;   /* auto is the initial value */
      margin: 0;  /* this affects the margin in the printer settings */
  }
  </style>
</head>
<body>

  <?php
      $offset = 0;
      $perPage = 20;

      if (isset($_GET['sheetID']) && (int)$_GET['sheetID'] != 0) {

        echo "<div style=\"padding: 15px 45px; 0 15px;\">";

        include_once($APP["root"] . "/_includes/functions.sheet.php");
        include_once($APP["root"] . "/_includes/functions.skills.php");


        $sql = "SELECT characterID, charSheetID, aantal_events FROM `ecc_char_sheet` WHERE charSheetID = '".mysqli_real_escape_string($UPLINK,(int)$_GET['sheetID'])."' LIMIT 1";
        $res = $UPLINK->query($sql);

        if($res && mysqli_num_rows($res) == 1) {

          $row = mysqli_fetch_assoc($res);

          $xSQL = "SELECT character_name, faction, accountID FROM `ecc_characters` WHERE characterID = '".(int)$row['characterID']."' LIMIT 1";
          $xRES = $UPLINK->query($xSQL);

          if($xRES) {


            $xCHAR = mysqli_fetch_assoc($xRES);
            $jid = $xCHAR['accountID'];

            // echo "<p><span style=\"float: left;\">"
            //   ."<a class=\"noprint\" href=\"".$APP['header']."/exports/printsheet.php?characterID=".$row['characterID']."\">[ Character sheet ]</a></span>"
            // ."</p>"
            // ."<br/>";

            echo "<p>&nbsp;</p>";

            $characterSheet = getFullCharSheet($_GET['sheetID']);
            $characterSheet['exp_used'] = calcUsedExp(EMS_echo($characterSheet['skills']), $xCHAR['faction']);
            $characterSheet['exp_total'] = calcTotalExp($characterSheet['aantal_events']);

            $augmentations = getImplants($_GET['sheetID']);
            $characterSheet['augs'] = filterSkillAugs($augmentations);
            unset($augmentations);

            echo "<h1>".ucfirst($xCHAR['character_name'])."</h1>";
            echo "<h3>Experience points spent: ".$characterSheet['exp_used']." / ".$characterSheet['exp_total']." "
              ."<span style=\"float: right;\">".ucfirst($xCHAR['faction'])."</span>"
            ."</h3>";

            echo "<hr/>";

            // SKILLS
            echo "<div style=\"width: 55%; float: left;\">";

            $skillArr = array();

            echo "<style> body { font-size: 16px } </style>";

            echo "<h3>Your skills</h3>";

            // first, create a minimized skill sheet
            foreach($characterSheet['skills'] AS $SKILL => $VALUES) {

              $skillArr[$VALUES['parent']]['parent'] = $VALUES['parent'];
              $skillArr[$VALUES['parent']]['level'] = $VALUES['level'];

            }

            // second, add the proper skill names
            foreach($skillArr AS $PARENTCODE => $VALUES) {

              $ySQL = "SELECT name, siteindex, parents FROM `ecc_skills_groups` WHERE primaryskill_id = '".$VALUES['parent']."' LIMIT 1";
              $yRES = $UPLINK->query($ySQL);
              $yROW = mysqli_fetch_assoc($yRES);

              $skillArr[$VALUES['parent']]['name'] = $yROW['name'];

              if($yROW['parents'] == 'none') {
                $skillArr[$VALUES['parent']]['specialty'] = 0;
              } else {
                $skillArr[$VALUES['parent']]['specialty'] = 1;
              }

              unset($ySQL);
              unset($yRES);
              unset($yROW);
            }

            // and Third: It's time to print those skills!

            echo "<table style=\"border: 0; width: 90%;\">";
            echo "<tr style=\"background-color: #CCC;\">"
              . "<th colspan=\"2\">Skill</th>"
              . "<th style=\"width: 65px; text-align: center;\">Level</th>"
            .  "</tr>";

            foreach($skillArr AS $SKILL => $VALUES) {

              echo "<tr>"
              . "<td colspan=\"2\">".$VALUES['name'].($VALUES['specialty'] == 1 ? "*" : "")."</td>"
              . "<td style=\"text-align: center; padding: 10px 5px; width: 65px;\">".$VALUES['level']."</td>"
              // . "<td>".($VALUES['specialty'] == 1 ? "*" : "")."</td>"
              . "</tr>";

            }

            echo "</table>";
            echo "<p style=\"font-size: 13px;\"><i>* specialty skills</i></p>";

            echo "</div>";

            echo "<div style=\"width: 40%; float: left;\">";

            echo "<h3>Augmentations</h3>";

            if($characterSheet['augs'] != "") {
              foreach($characterSheet['augs'] AS $aug) {
               echo "<p><strong>".($aug['type'] == 'cybernetic' ? 'Bionic' : 'Symbiont') . ": " . $aug['name'] . ' level '. $aug['level'] . "</strong>";
               echo "<br/>\"" .$aug['description']. "\"</p>";
              }
            }

            echo "</div>";

            // AUGMENTATIONS


          }


        }

        echo "</div>";

      } else if (isset($_GET['characterID']) && (int)$_GET['characterID'] != 0) {

        if(isset($_GET['print']) && $_GET['print'] == 'confirm') {
          $sql = "UPDATE `ecc_characters` SET `sheet_status` = '90' WHERE `characterID` = '".(int)$_GET['characterID']."' LIMIT 1;";
          $res = $UPLINK->query($sql);
        }

        echo "<div style=\"padding:15px;\">";

          $sql = "SELECT characterID, character_name, faction, sheet_status FROM `ecc_characters` WHERE characterID = '".(int)$_GET['characterID']."' LIMIT 1";
          $res = $UPLINK->query($sql);

          if($res) {
            if(mysqli_num_rows($res) == 1) {

              // echo "<a href=\"".$APP['header']."/exports/printsheet.php\"><button>Close</button></a> <br/><br/>";
              echo "<button onclick=\"window.close();\">Close Window</button>";

              $row = mysqli_fetch_assoc($res);

              if(!isset($row['character_name']) || $row['character_name'] == "") {
                $row['character_name'] = "[no name]";
              }

              // $xCHAR = $row['characterID'];
              $xTOPRINT = false;

              if($row['sheet_status'] == 90) {
                $xSTATUS = "<span style=\"color: green;\">Done</span>";
              } else if ($row['sheet_status'] == 100) {
                $xSTATUS = "<span style=\"color: gray;\">Nope</span>";
              } else {
                $xSTATUS = "<span style=\"color: tomato;\">unprinted</span>";

                $xTOPRINT = true;
              }

              echo "<h1>".$row['character_name']. ", ".$row['faction']."</h1>"
              ."<p>Sheet status: $xSTATUS </p><hr/><br/>";

              if($xTOPRINT == true) {

                echo "<p><a href=\"".$APP['header']."/exports/printsheet.php?characterID=".$row['characterID']."&print=confirm\">"
                 . "<button style=\"width: 100%;\">&#x2713; Confirm printstatus</button>"
                 ."</a></p><br/>";

              }

              unset($xTOPRINT);

              $sql = "SELECT charSheetID, nickname, aantal_events, status, versionNumber FROM `ecc_char_sheet` WHERE characterID = '".(int)$_GET['characterID']."' ORDER BY charSheetID, aantal_events DESC";
              $res = $UPLINK->query($sql);

              if($res) {
                if(mysqli_num_rows($res) > 0) {

                  echo "<table style=\"border: 0;\">"
                  . "<tr>"
                    ."<th>Nickname</th>"
                    ."<th>Events played</th>"
                    ."<th>Status</th>"
                    ."<th>Version #</th>"
                    ."<th>&nbsp;</th>"
                  ."</tr>";

                  while($row = mysqli_fetch_assoc($res)) {

                    echo "<tr>"
                    . "<td>".$row['nickname']."</td>"
                    . "<td>".$row['aantal_events']."</td>"
                    . "<td>".$row['status']."</td>"
                    . "<td>".$row['versionNumber']."</td>"
                    . "<td><a href=\"".$APP['header']."/exports/printsheet.php?sheetID=".$row['charSheetID']."\"><button>OPEN</button></a></td>"
                    . "</tr>";
                  }

                  echo "</table>";

                  // unset($xCHAR);

                } else {
                  echo "<p>No character sheets found.</p>";
                }
              } else {
                  echo "<p>No character sheets found.</p>";
              }



            }
          }

          echo "</div>";

      } else {

        $sql = "SELECT count( `characterID` )
                AS totalchars
                FROM `ecc_characters`
                WHERE `status` NOT LIKE 'deceased'
                AND `faction` = '$_FACTION'
                AND `characterID` IN $EVENTIDS";

        $res = $UPLINK->query($sql);
        $resCOUNT = mysqli_fetch_assoc($res)['totalchars'];

        echo "<select id=\"factionswitch\"
                  style=\"padding: 5px; border-radius: 2px; margin-bottom: 1rem;\"
                  onchange=\"location.href = '{$APP['header']}/exports/printsheet.php?offset=0&faction=' + this.value; \">
                <option value=\"\">Select faction</option>
                <option value=\"aquila\">Aquila</option>
                <option value=\"dugo\">Dugo</option>
                <option value=\"ekanesh\">Ekanesh</option>
                <option value=\"pendzal\">Pendzal</option>
                <option value=\"sona\">Sona</option>
              </select>";
        echo "<div style=\"padding: 15px;\">CHARACTERS : $resCOUNT<br/><br/>";

        $printresult = "";

        if(isset($_GET['offset']) && (int)$_GET['offset'] > 0) {
          $offset = (int)$_GET['offset'];
        }

        $limitFirst = $offset*$perPage;


        $pageNumber = 1;
        for($x = 0; $x < $resCOUNT; $x = ($x+$perPage)) {

          if(($pageNumber-1) == $offset) {
            echo "<span style=\"padding:8px 4px; color: red;\"><strong>[$pageNumber]&nbsp;</strong></span>";
          } else {
            echo "<a style=\"padding:8px 4px;\" href=\"".$APP['header']."/exports/printsheet.php?offset=".($pageNumber-1)."&faction=$_FACTION\">[$pageNumber]&nbsp;</a>";
          }

          $pageNumber++;
        }

        echo "<br/><br/>";

        $sql = "SELECT characterID, character_name, faction, sheet_status
          FROM `ecc_characters`
          WHERE `status` NOT LIKE 'deceased'
          AND `faction` = '$_FACTION'
          AND `characterID` IN $EVENTIDS
          ORDER BY faction,character_name
          LIMIT ".(int)$limitFirst." , ".(int)$perPage." ";
        $res = $UPLINK->query($sql);

        if($res) {

          echo "<table style=\"border: 0; width: 100%;\">";

          while($row = mysqli_fetch_assoc($res)) {

            if($row['sheet_status'] == 90) {

              $xSTATUS = "<span style=\"color: green;\">Done</span>";

            } else if ($row['sheet_status'] == 100) {

              $xSTATUS = "<span style=\"color: gray;\">Nope</span>";

            } else {
              $xSTATUS = "<span style=\"color: tomato;\">unprinted</span>";
            }

            if($row['character_name'] == "" || $row['character_name'] == null) {
              $row['character_name'] = '<span style="color: tomato;">no name</span>';
            }

            echo "<tr>"
              ."<td>#".$row['characterID']."</td>"
              ."<td>".$row['character_name']."</td><td>". $row['faction'] ."</td><td>". $xSTATUS ."</td>"
              // ."<td><a href=\"".$APP['header']."/exports/printsheet.php?characterID=".$row['characterID']."\" target=\"_new\"><button>Sheets</button></a></td>"
              ."<td><button onclick=\"window.open('{$APP["header"]}/exports/printsheet.php?characterID={$row['characterID']}','sheets','width=1280,height=768');\">View Sheet(s)</button></td>"
            ."</tr>";
            unset($xSTATUS);
          }

          echo "</table>";

        }


      }

      echo "</div>";

  ?>

</body>
</html>
