<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");

  include_once($APP["root"] . '/exports/current-players.php');

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
      background: #FFF;
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
      background-position: 95% 85px;
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
      border-bottom: 1px solid #EEE;
      color: #222;
      margin-top: 1px;
      padding: 2px 5px;
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

      if (isset($_GET['characterID']) && (int)$_GET['characterID'] != 0) {
        include_once($APP["root"] . "/_includes/functions.sheet.php");
        include_once($APP["root"] . "/_includes/functions.skills.php");


        $sql = "SELECT characterID, faction, accountID, aantal_events, character_name
         FROM `ecc_characters` 
         WHERE characterID = '".mysqli_real_escape_string($UPLINK,(int)$_GET['characterID'])."' 
         LIMIT 1";
        $res = $UPLINK->query($sql);

        $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
        $res2 = $UPLINK->query($sql2);
        $row2 = mysqli_fetch_array($res2);

        

        if($res && mysqli_num_rows($res) == 1) {

          $row = mysqli_fetch_assoc($res);

            $jid = $row['accountID'];

            $skillArr   	  = getCharacterSkills($row['characterID']);
            $expUsed        = calcUsedExp(EMS_echo($skillArr), $row['faction']);
            $expTotal       = calcTotalExp($row['aantal_events']);
            $augmentations  = filterSkillAugs(getImplants($_GET['characterID']));
            //MySQL Query to Check for Bonus research token skill
            $sql3 = "SELECT charID FROM ecc_char_skills WHERE (skill_id = 31305 AND charID = " . $row['characterID'] . ");";
            $res3 = $UPLINK->query($sql3);
            $row3 = mysqli_fetch_array($res3);
            
            //Research token tear strips
            echo "</br><table border='1'>"
            . "<tr>";
            if($res3 && mysqli_num_rows($res3) > 0) {
              $y = 3;
            } else {
              $y = 2;
            }
            for ($x = 1; $x <= $y; $x++) {
            echo "<td height='30'><strong>" . $row['character_name'] 
            . "</strong></br>" . $row2['title'] ." - Research Token ". $x ."</td>";
            };
            echo "</table>";
            echo "<div style='padding: 15px 45px; 0 15px;'>";
            echo "<font size='6'><strong>".ucfirst($row['character_name'])."</strong></font></br>";
            echo "<font size='5'><strong>" . $row2['title'] . "</br>Experience points spent: $expUsed / $expTotal "
              ."<span style=\"color: #777; float: right;\">".ucfirst($row['faction'])."</span>"
            ."</strong></font></br>";

            echo "<hr/>";

            // SKILLS
            echo "<div style=\"width: 65%; float: left;\">";
            echo "<style> body { font-size: 16px } </style>";
            echo "<font size='4'><strong>Your skills</strong></font></br>";

            // first, create a minimized skill sheet

            $parentSkills = [];

            $kSQL = "SELECT primaryskill_id, name FROM `ecc_skills_groups`";
            $kRES = $UPLINK->query($kSQL);
            while($kROW = mysqli_fetch_assoc($kRES)){
              $parentSkills[$kROW['primaryskill_id']] = $kROW['name'];
            }
            // and Third: It's time to print those skills!

            echo "<table style=\"border: 0; width: 90%;\">";
            echo "<tr style=\"background-color: #CCC;\">"
              . "<th colspan=\"3\">Skill</th>"
              . "<th style=\"width: 65px; text-align: center;\">Level</th>"
            .  "</tr>";
            
            $printableSkills = [];
            
            foreach($skillArr AS $SKILL => $VALUES) {
              $printableSkills[$VALUES['parent']] = $VALUES;
            }

            foreach($skillArr AS $SKILL => $VALUES) {

              if (isset($VALUES['label']) && $VALUES['label'] !== '') {
                echo "<tr>"
                . "<td style=\"color: #888; font-size: 8px;\">".$parentSkills[$VALUES['parent']]."</td>"
                . "<td colspan=\"2\">".$VALUES['label'].($VALUES['level'] > 5 ? "*" : "")."</td>"
                . "<td style=\"text-align: center; padding: 2px 5px; width: 65px;\">".$VALUES['level']."</td>"
                . "</tr>";
              }

            }

            echo "</table>";
            echo "<p style=\"font-size: 13px;\"><i>* specialty skills</i></p>";

            echo "</div>";

            echo "<div style=\"width: 30%; float: left;\">";

            echo "<font size='4'><strong>Augmentations</strong></font></br>";

            if($augmentations != "") {
              foreach($augmentations AS $aug) {
               echo "<p><strong>".($aug['type'] == 'cybernetic' ? 'Bionic' : 'Symbiont') . ": " . $aug['name'] . ' level '. $aug['level'] . "</strong></p>";
              }
            }

            echo "</div>";

            // AUGMENTATIONS

        }

        echo "</div>";

      } else {

        $sql = "SELECT count(SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1)) as totalchars, c1.faction from jml_eb_registrants r
        join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
	join jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 14)
		join ecc_characters c1 on c1.characterID = SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1)
        where v2.field_value = 'Speler' AND r.event_id = $EVENTID  AND `faction` = '$_FACTION' and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method='os_paypal')) OR (r.published in (0,1) AND r.payment_method = 'os_offline'));";

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
        echo "<div style=\"padding: 15px;\">$_FACTION CHARACTERS : $resCOUNT<br/><br/>";

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


        $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as characterID, c1.character_name, c1.faction, c1.sheet_status from jml_eb_registrants r
        join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
	join jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 14)
        join ecc_characters c1 on c1.characterID = SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1)
        where v2.field_value = 'Speler' AND r.event_id = $EVENTID  and characterID <> 257 AND `faction` = '$_FACTION' and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method = 'os_paypal')) OR (r.published in (0,1) AND r.payment_method = 'os_offline'))
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
              ."<td><button onclick=\"window.open('{$APP["header"]}/exports/printsheet.php?characterID={$row['characterID']}','sheets','width=1280,height=768');\">View Sheet</button></td>"
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

