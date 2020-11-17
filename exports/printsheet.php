<?php
// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");

include_once($APP["root"] . '/exports/current-players.php');

(string)$_FACTION = (isset($_GET['faction']) && $_GET['faction'] != "" ? $_GET['faction'] : 'aquila');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sheets</title>


  <style>
    html {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      font-size: 10px;
      background: #FFF;
    }

    body {
      font-family: arial;
      font-size: 12px;
      height: 297mm;
      width: 210mm;
      margin-left: auto;
      margin-right: auto;
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
      font-family: arial, sans-serif;
      border-collapse: collapse;
      font-size: 12px;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 2px 5px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    @media print {
      #printPageButton {
        display: none;
      }
    }
  </style>

  <style type="text/css" media="print">
    @page {
      size: auto;
      /* auto is the initial value */
      margin: 0;
      /* this affects the margin in the printer settings */
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

    if (isset($_GET['print']) && $_GET['print'] == 'confirm') {
      $sql = "UPDATE `ecc_characters` SET `print_status` = $EVENTID WHERE `characterID` = '" . (int)$_GET['characterID'] . "' LIMIT 1;";
      $res = $UPLINK->query($sql);
    }


    $sql = "SELECT characterID, faction, accountID, aantal_events, character_name
         FROM `ecc_characters` 
         WHERE characterID = '" . mysqli_real_escape_string($UPLINK, (int)$_GET['characterID']) . "' 
         LIMIT 1";
    $res = $UPLINK->query($sql);

    $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
    $res2 = $UPLINK->query($sql2);
    $row2 = mysqli_fetch_array($res2);

    if ($res && mysqli_num_rows($res) == 1) {

      $row = mysqli_fetch_assoc($res);

      $jid = $row['accountID'];

      $skillArr       = getCharacterSkills($row['characterID']);
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
      if ($res3 && mysqli_num_rows($res3) > 0) {
        $y = 3;
      } else {
        $y = 2;
      }
      for ($x = 1; $x <= $y; $x++) {
        echo "<td height='30'><strong>" . $row['character_name']
          . "</strong></br>" . $row2['title'] . " - Research Token " . $x . "</td>";
      };
      echo "</table>";
      echo "<div style='padding: 15px 45px; 0 15px;'>";
      echo "<font size='6'><strong>" . ucfirst($row['character_name']) . "</strong></font></br>";
      echo "<font size='5'><strong>" . $row2['title'] . "</br>Experience points spent: $expUsed / $expTotal "
        . "<span style=\"color: #777; float: right;\">" . ucfirst($row['faction']) . "</span>"
        . "</strong></font></br>";

      echo "<hr/>";

      // SKILLS
      echo "<div style=\"width: 65%; float: left;\">";
      echo "<style> body { font-size: 16px } </style>";
      echo "<font size='4'><strong>Your skills</strong></font></br>";

      // first, create a minimized skill sheet

      $parentSkills = [];

      $kSQL = "SELECT primaryskill_id, name FROM `ecc_skills_groups`";
      $kRES = $UPLINK->query($kSQL);
      while ($kROW = mysqli_fetch_assoc($kRES)) {
        $parentSkills[$kROW['primaryskill_id']] = $kROW['name'];
      }
      // and Third: It's time to print those skills!

      echo "<table style=\"border: 0; width: 90%;\">";
      echo "<tr style=\"background-color: #CCC;\">"
        . "<th colspan=\"3\">Skill</th>"
        . "<th style=\"width: 65px; text-align: center;\">Level</th>"
        .  "</tr>";

      $printableSkills = [];

      foreach ($skillArr as $SKILL => $VALUES) {
        $printableSkills[$VALUES['parent']] = $VALUES;
      }

      foreach ($skillArr as $SKILL => $VALUES) {

        if (isset($VALUES['label']) && $VALUES['label'] !== '') {
          echo "<tr>"
            . "<td style=\"color: #888; font-size: 8px;\">" . $parentSkills[$VALUES['parent']] . "</td>"
            . "<td colspan=\"2\">" . $VALUES['label'] . ($VALUES['level'] > 5 ? "*" : "") . "</td>"
            . "<td style=\"text-align: center; padding: 2px 5px; width: 65px;\">" . $VALUES['level'] . "</td>"
            . "</tr>";
        }
      }

      echo "</table>";
      echo "<p style=\"font-size: 13px;\"><i>* specialty skills</i></p>";



      echo "</div>";

      echo "<div style=\"width: 30%; float: left;\">";

      echo "<font size='4'><strong>Augmentations</strong></font></br>";

      if ($augmentations != "") {
        foreach ($augmentations as $aug) {
          echo "<p><strong>" . ($aug['type'] == 'cybernetic' ? 'Bionic' : 'Symbiont') . ": " . $aug['name'] . ' level ' . $aug['level'] . "</strong></p>";
        }
      }

      echo "</div>";

      // AUGMENTATIONS
      //Print and Close Button
      if (isset($_GET['print']) && $_GET['print'] == 'confirm') {
        echo "<p><a href=\"" . $APP['header'] . "/exports/printsheet.php?characterID=" . $row['characterID'] . "&print=confirm\">"
          . "<button id=\"printPageButton\" style=\"width: 100%;\" onClick=\"window.print();\">&#x2713;Print</button></td></tr>";
        echo "<tr><td>";
        echo "<p><button id=\"printPageButton\" style=\"width: 100%;\" onclick=\"window.open('', '_self', ''); window.close();\">Close Window</button></td></tr>";
      } else {
        //Print Button by itself
        echo "<p><a href=\"" . $APP['header'] . "/exports/printsheet.php?characterID=" . $row['characterID'] . "&print=confirm\">"
          . "<button id=\"printPageButton\" style=\"width: 100%;\" onClick=\"window.print();\">Print</button></td>";
      }
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
                <option value=\"Aquila\">Aquila</option>
                <option value=\"Dugo\">Dugo</option>
                <option value=\"Ekanesh\">Ekanesh</option>
                <option value=\"Pendzal\">Pendzal</option>
                <option value=\"Sona\">Sona</option>
              </select>";
    $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
    $res2 = $UPLINK->query($sql2);
    $row2 = mysqli_fetch_array($res2);

    echo "<div style=\"padding: 15px;\"><h1>" . $row2['title'] . "<br>Number of $_FACTION Characters: $resCOUNT</h1><br/><br/>";

    $printresult = "";

    if (isset($_GET['offset']) && (int)$_GET['offset'] > 0) {
      $offset = (int)$_GET['offset'];
    }

    $limitFirst = $offset * $perPage;


    $pageNumber = 1;
    echo "Page ";
    for ($x = 0; $x < $resCOUNT; $x = ($x + $perPage)) {

      if (($pageNumber - 1) == $offset) {
        echo "<span style=\"padding:8px 4px; color: red;\"><button type='disabled'><strong><font size=4>$pageNumber</font></strong></button></span>";
      } else {
        echo "<a style=\"padding:8px 4px;\" href=\"" . $APP['header'] . "/exports/printsheet.php?offset=" . ($pageNumber - 1) . "&faction=$_FACTION\"><button>$pageNumber</button></a>";
      }

      $pageNumber++;
    }

    echo "<br/><br/>";


    $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as characterID, c1.character_name, c1.faction, c1.sheet_status, c1.print_status from jml_eb_registrants r
        join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
	join jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 14)
        join ecc_characters c1 on c1.characterID = SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1)
        where v2.field_value = 'Speler' AND r.event_id = $EVENTID  and characterID <> 257 AND `faction` = '$_FACTION' and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method = 'os_paypal')) OR (r.published in (0,1) AND r.payment_method = 'os_offline'))
          ORDER BY faction,character_name
          LIMIT " . (int)$limitFirst . " , " . (int)$perPage . " ";
    $res = $UPLINK->query($sql);

    if ($res) {

      echo "<table style=\"border: 0; width: 100%;\">"
        . "<th>ID</th><th>Name</th><th>Faction</th><th>Print Status</th><th>Open Sheet</th>";
      while ($row = mysqli_fetch_assoc($res)) {
        // $xCHAR = $row['characterID'];
        $xTOPRINT = false;

        if ($row['print_status'] == $EVENTID) {

          $xSTATUS = "<span style=\"color: green;\">Done</span>";
          $xTOPRINT = false;
        } else {
          $xSTATUS = "<span style=\"color: tomato;\">Unprinted</span>";
          $xTOPRINT = true;
        }

        if ($row['character_name'] == "" || $row['character_name'] == null) {
          $row['character_name'] = '<span style="color: tomato;">no name</span>';
        }



        echo "<tr>"
          . "<td>#" . $row['characterID'] . "</td>"
          . "<td>" . $row['character_name'] . "</td><td>" . $row['faction'] . "</td><td>" . $xSTATUS . "</td>"
          // ."<td><a href=\"".$APP['header']."/exports/printsheet.php?characterID=".$row['characterID']."\" target=\"_new\"><button>Sheets</button></a></td>"
          . "<td><button onclick=\"window.open('{$APP["header"]}/exports/printsheet.php?characterID={$row['characterID']}','sheets','width=1280,height=1000');\">View Sheet</button></td></tr>";
        unset($xSTATUS);
      }

      echo "</table>";
      if (isset($_GET['offset']) && (int)$_GET['offset'] > 0) {
        $offset = (int)$_GET['offset'];
      }

      $limitFirst = $offset * $perPage;


      $pageNumber = 1;
      echo "Page ";
      for ($x = 0; $x < $resCOUNT; $x = ($x + $perPage)) {

        if (($pageNumber - 1) == $offset) {
          echo "<span style=\"padding:8px 4px; color: red;\"><button type='disabled'><strong><font size=4>$pageNumber</font></strong></button></span>";
        } else {
          echo "<a style=\"padding:8px 4px;\" href=\"" . $APP['header'] . "/exports/printsheet.php?offset=" . ($pageNumber - 1) . "&faction=$_FACTION\"><button>$pageNumber</button></a>";
        }

        $pageNumber++;
      }

      echo "<br/><br/>";
    }
  }

  echo "</div>";
  ?>

</body>

</html>