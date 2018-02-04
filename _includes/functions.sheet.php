<?php

function getFullCharSheet($sheetID = null) {

  global $TIJDELIJKEID, $UPLINK;

  $returnArr = array();

  if(isset($sheetID) && (int)$sheetID != 0) {

    // check if sheetID belongs to the active account.
    $sql = "SELECT characterID, accountID FROM `ecc_characters` WHERE characterID = '".mysqli_real_escape_string($UPLINK,(int)$sheetID)."' AND accountID = '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."' LIMIT 1";
    $res = $UPLINK->query($sql);

    if($res && mysqli_num_rows($res) == 1) {

      // select all skills belonging to current character.
      $res->free();
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
