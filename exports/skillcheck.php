<?php
$APP = array();
$APP["includes"] = array();
$APP["header"] = "/eoschargen";
$APP["root"] = $_SERVER["DOCUMENT_ROOT"] . $APP["header"];
$APP["loginpage"] = "/component/users/?view=login";

include_once($_SERVER["DOCUMENT_ROOT"] . '/eoschargen/db.php');
include_once($APP["root"] . "/_includes/functions.global.php");
include_once($APP["root"] . '/exports/current-players.php');
?>
<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      font-family: orbitron;
      background: #262e3e;
      color: white;
    }

    table {
      font-family: orbitron;
      border-collapse: collapse;
      width: 70%;
      color: white;
      margin-left: auto;
      margin-right: auto;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 1px 2px;
      font-size: 14px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
      color: black;
    }

    .button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;

    }

    #nname {
      padding: 5px;
      color: #fff;
      background-color: #000;
      font-size: 12px;
      -webkit-appearance: none;

    }

    @media print {
      #printPageButton {
        display: none;
      }

      #nname {
        display: none;

      }

      * {
        -webkit-print-color-adjust: exact;
      }

      body {
        background-color: #fff;
        color: #000;
        font-size: 10px;
      }

      table {
        color: #000;
        border-collapse: collapse;
        padding: 1px 5px;
        font-size: 8px;
        width: 70%;
        margin-left: auto;
        margin-right: auto;
      }

      td,
      th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 0px 0px;
        font-size: 10px;
      }

      .single_record {
        page-break-after: always;
      }
    }
  </style>
</head>

<body>
  <?php

  $skill_index_sql = "SELECT substring_index(skill_index,'_',1) as category FROM joomla.ecc_skills_allskills GROUP by category;";
  $skill_index_res = $UPLINK->query($skill_index_sql);
  echo '<p><form action="" method="post">
 <select name="skill_index" id="cname" onchange="this.form.submit();">';
  echo '<option value="">Choose a Category</option>';
  while ($skill_index_row = mysqli_fetch_assoc($skill_index_res)) {
    echo '<option value="' . $skill_index_row['category'] . '"';
    if (isset($_POST['skill_index']) && $_POST['skill_index'] == $skill_index_row['category']) echo "selected";
    echo '>' . $skill_index_row['category'] . '</option>';
  };
  echo '</select>
    &nbsp;&nbsp;';

  if (isset($_POST['skill_index'])) {
    $skillindex = $_POST['skill_index'];
    $skillsql = "SELECT skill_id, concat(skill_index,'>',label) as SkillName, label, substring_index(skill_index,'_',-1) as level FROM joomla.ecc_skills_allskills WHERE skill_index LIKE '$skillindex%' ORDER by skill_index+0, label+0;";
    $skillres = $UPLINK->query($skillsql);
    echo  '<select name="skillID" id="sname" onchange="this.form.submit();">';
    echo '<option value="">Choose a Skill</option>';
    while ($skillrow = mysqli_fetch_assoc($skillres)) {

      echo '<option value="' . $skillrow['skill_id'] . '"';
      if (isset($_POST['skillID']) && $_POST['skillID'] == $skillrow['skill_id']) echo "selected";
      echo '>' . '(' . $skillrow['level'] . '): ' . $skillrow['label'] . '</option>';
    };
    echo '</select>
    </form></p>';
  }

  if (isset($_POST['skillID'])) {
    $skillID = $_POST['skillID'];
    $sql2 = "SELECT title FROM jml_eb_events where id = $EVENTID;";
    $res2 = $UPLINK->query($sql2);
    $row2 = mysqli_fetch_array($res2);
    $selskillsql = "SELECT skill_id, concat(skill_index,'>',label) as SkillName, label, description, substring_index(skill_index,'_',1) as category, substring_index(skill_index,'_',-1) as level FROM joomla.ecc_skills_allskills WHERE skill_id = $skillID  ORDER by SkillName+0;";
    $selskillres = $UPLINK->query($selskillsql);
    $row = mysqli_fetch_array($selskillres);

    echo '<h1> Characters with Skill: ' . $row['category'] . '(' . $row['level'] . '): ' . ' ' .  $row['label'] . '</h1>';
    echo '<h2>' . $row2['title'] . '</h2>';
    echo '<h3>Description: ' . $row['description'] . '</h3>';
    echo '<button class="button" id="printPageButton" style="width: 100px;" onClick="window.print();">Print</button>';
    $sql = "SELECT characterID, character_name, faction, label FROM ecc_characters c
join ecc_char_skills s1 on (c.characterid = s1.charID)
join ecc_skills_allskills s2 on (s1.skill_id = s2.skill_id)
where s1.skill_id = $skillID and c.sheet_status='active' AND characterID in
(SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as id from jml_eb_registrants r
join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
where r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method = 'os_paypal'))
OR (r.published in (0,1) AND r.payment_method = 'os_offline'))) ORDER BY character_name";
    $res = $UPLINK->query($sql);
    echo '<table><th>Name</th><th>Faction</th>';
    while ($row = mysqli_fetch_assoc($res)) {
      echo '<tr><td>' . $row['character_name'] . '</td><td>' . $row['faction'] . '</td></tr>';
    };
    echo '</table>';
  }

  ?>