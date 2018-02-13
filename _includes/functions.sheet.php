<?php
function getFullCharSheet($sheetID = null) {

  global $TIJDELIJKEID, $UPLINK;

  $returnArr = array();

  if(isset($sheetID) && (int)$sheetID != 0) {

    // check if sheetID belongs to the active account.
    $sql = "SELECT characterID, charSheetID, accountID, aantal_events FROM `ecc_char_sheet` WHERE charSheetID = '".mysqli_real_escape_string($UPLINK,(int)$sheetID)."' AND accountID = '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."' LIMIT 1";
    $res = $UPLINK->query($sql);

    if($res && mysqli_num_rows($res) == 1) {

      $returnArr['aantal_events'] = mysqli_fetch_assoc($res)['aantal_events'];

      // select all skills belonging to current character.
      $sql = "SELECT skill_id FROM `ecc_char_skills` WHERE `char_sheet_id` = '$sheetID' ";
      $res = $UPLINK->query($sql);

      if($res && mysqli_num_rows($res) > 0) {

        while($row = mysqli_fetch_assoc($res)){

          $returnArr['skills'][(int)$row['skill_id']]['id'] = (int)$row['skill_id'];

          $xSQL = "SELECT label, skill_index, parent, level
            FROM ecc_skills_allskills
            WHERE skill_id = '".(int)$row['skill_id']."'";

          $xRES = $UPLINK->query($xSQL);
          $xROW = mysqli_fetch_array($xRES);

          $returnArr['skills'][(int)$row['skill_id']]['label'] = $xROW['label'];
          $returnArr['skills'][(int)$row['skill_id']]['skill_index'] = $xROW['skill_index'];
          $returnArr['skills'][(int)$row['skill_id']]['parent'] = $xROW['parent'];
          $returnArr['skills'][(int)$row['skill_id']]['level'] = $xROW['level'];
        }

      } else {
        // character has zero skills yet. Neat!

      }

    } else {
      // character and active account don't match.
    }

  } else {
    // no character requested.
  }


  return $returnArr;

}

function calcTotalExp($eventCount = 0){

  $basic = 25;
  $perEvent = 8;

  if((int)$eventCount > 0) {
    $basic = $basic + ((int)$eventCount * $perEvent);
  }

  return $basic;

}


function calcUsedExp($charSkillArr = array(), $faction = null) {

  global $UPLINK;

  $result = 0;

  $faction = strtolower(EMS_echo($faction));

  if(is_array($charSkillArr) && count($charSkillArr) > 0) {

    foreach($charSkillArr AS $key => $details) {

      // $result[$key]['lvl'] = $details["level"];
      // $result[$key]['index'] = $details["parent"];

      if((int)$details["level"] > 0) {

        if($details["level"] == 1) {

          $sql = "SELECT cost_modifier, type FROM ecc_factionmodifiers WHERE `faction_siteindex` = '".$faction."' AND `skill_id` = ".$details['parent']."";
          $res = $UPLINK->query($sql);

          if(mysqli_num_rows($res) > 0) {

            $row = mysqli_fetch_assoc($res);

            if($row['type'] != 'enable') {

              $result = ($result + $row['cost_modifier']);
              // echo $result['cost']."&nbsp;:&nbsp;".$details['label']."<br/>";
            } else {

              $result = ($result + 1);
              // echo $result['cost']."&nbsp;:&nbsp;".$details['label']."<br/>";
            }

          } else {

            $result = ($result + 1);
            // echo $result['cost']."&nbsp;:&nbsp;".$details['label']."<br/>";
          }

        } else {

          $result = ($result + $details['level']);
          // echo $result['cost']."&nbsp;:&nbsp;".$details['label']."<br/>";

        }

      }

    }

  }

  return $result;
}

function getImplants($sheetID) {

  global $TIJDELIJKEID, $UPLINK;

  $sql = "SELECT `modifierID`,`sheetID`,`accountID`,`type`,`skillgroup_level`,`skillgroup_siteindex`,`status`,`description` FROM `ecc_char_implants` WHERE `accountID` = '".(int)$TIJDELIJKEID."' AND `sheetID` = '".(int)$sheetID."' ";
  $res = $UPLINK->query($sql);

  // $return = mysqli_fetch_array($res);
  while($row = mysqli_fetch_assoc($res)) {

    // fill rows
    foreach($row AS $key => $value) {
      $return[$row['modifierID']][$key] = $value;
    }

  }

  return $return;
}
