<?php
function getCharacterSkills($charID = null)
{

  global $jid, $UPLINK;

  $returnArr = array();

  if (isset($charID) && (int)$charID != 0) {

    // select all skills belonging to current character.
    $sql = "SELECT skill_id FROM `ecc_char_skills` WHERE `charID` = '$charID' ";
    $res = $UPLINK->query($sql);

    if ($res && mysqli_num_rows($res) > 0) {

      while ($row = mysqli_fetch_assoc($res)) {

        $xSQL = "SELECT label, skill_index, parent, level
          FROM ecc_skills_allskills
          WHERE skill_id = '" . (int)$row['skill_id'] . "'";

        $xRES = $UPLINK->query($xSQL);
        $xROW = mysqli_fetch_array($xRES);

        $returnArr[$xROW['skill_index']]['id'] = (int)$row['skill_id'];
        $returnArr[$xROW['skill_index']]['label'] = $xROW['label'];
        $returnArr[$xROW['skill_index']]['skill_index'] = $xROW['skill_index'];
        $returnArr[$xROW['skill_index']]['parent'] = $xROW['parent'];
        $returnArr[$xROW['skill_index']]['level'] = (int)$xROW['level'];
      }
    } else {
      // character has zero skills yet. Neat!
    }
  } else {
    // character and active account don't match.
  }

  return $returnArr;
}

function calcTotalExp($eventCount = 0)
{

  $basic = 25;
  $perEvent = 8;

  if ((int)$eventCount > 0) {
    $basic = $basic + ((int)$eventCount * $perEvent);
  }

  return $basic;
}


function calcUsedExp($charSkillArr = array(), $faction = null)
{

  global $UPLINK;

  $result = 0;

  $faction = strtolower(EMS_echo($faction));

  if (is_array($charSkillArr) && count($charSkillArr) > 0) {

    foreach ($charSkillArr as $key => $details) {

      if ((int)$details["level"] > 0) {

        if ($details["level"] == 1) {

          $sql = "SELECT cost_modifier, type FROM ecc_factionmodifiers WHERE `faction_siteindex` = '" . mysqli_real_escape_string($UPLINK, $faction) . "' AND `skill_id` = " . mysqli_real_escape_string($UPLINK, $details['parent']) . "";
          $res = $UPLINK->query($sql);

          if (mysqli_num_rows($res) > 0) {

            $row = mysqli_fetch_assoc($res);

            if ($row['type'] != 'enable') {

              $result = ($result + $row['cost_modifier']);
              $result++;
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

function getImplants($charID)
{

  global $jid, $UPLINK;

  $return = false;

  $sql = "SELECT i.modifierID,i.charID,i.accountID,i.type,i.skillgroup_level,i.skillgroup_siteindex,i.status,i.description,s.name
    FROM ecc_char_implants i
    LEFT JOIN ecc_skills_groups s ON i.skillgroup_siteindex = s.siteindex
    WHERE `accountID` = '" . (int)$jid . "'
    AND `charID` = '" . (int)$charID . "' ";

  $res = $UPLINK->query($sql);


  while ($row = mysqli_fetch_assoc($res)) {

    // fill rows
    foreach ($row as $key => $value) {
      $return[$row['modifierID']][$key] = $value;
    }
  }

  return $return;
}
