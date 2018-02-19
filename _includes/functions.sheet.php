<?php
function getFullCharSheet($sheetID = null) {

  global $TIJDELIJKEID, $UPLINK;

  $returnArr = array();

  if(isset($sheetID) && (int)$sheetID != 0) {

    // check if sheetID belongs to the active account.
    $sql = "SELECT characterID, charSheetID, nickname, accountID, aantal_events FROM `ecc_char_sheet` WHERE charSheetID = '".mysqli_real_escape_string($UPLINK,(int)$sheetID)."' AND accountID = '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."' LIMIT 1";
    $res = $UPLINK->query($sql);

    if($res && mysqli_num_rows($res) == 1) {

      $returnArr['aantal_events'] = mysqli_fetch_assoc($res)['aantal_events'];
      $returnArr['nickname'] = EMS_echo(mysqli_fetch_assoc($res)['nickname']);

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

      if((int)$details["level"] > 0) {

        if($details["level"] == 1) {

          $sql = "SELECT cost_modifier, type FROM ecc_factionmodifiers WHERE `faction_siteindex` = '".$faction."' AND `skill_id` = ".$details['parent']."";
          $res = $UPLINK->query($sql);

          if(mysqli_num_rows($res) > 0) {

            $row = mysqli_fetch_assoc($res);

            if($row['type'] != 'enable') {

              $result = ($result + $row['cost_modifier']);
            } else {

              $result = ($result + 1);
            }

          } else {

            $result = ($result + 1);
          }

        } else {

          $result = ($result + $details['level']);

        }

      }

    }

  }

  return $result;
}

function getImplants($sheetID) {

  global $TIJDELIJKEID, $UPLINK;

  $return = false;

  $sql = "SELECT i.modifierID,i.sheetID,i.accountID,i.type,i.skillgroup_level,i.status,i.description,s.name
    FROM ecc_char_implants i
    LEFT JOIN ecc_skills_groups s ON i.skillgroup_siteindex = s.siteindex
    WHERE `accountID` = '".(int)$TIJDELIJKEID."'
    AND `sheetID` = '".(int)$sheetID."' ";

  $res = $UPLINK->query($sql);


  while($row = mysqli_fetch_assoc($res)) {

    // fill rows
    foreach($row AS $key => $value) {
      $return[$row['modifierID']][$key] = $value;
    }

  }

  return $return;
}
