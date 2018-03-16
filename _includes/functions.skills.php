<?php

// START SILVESTER FUNCTIONS
function getSkillGroup($psychic = NULL, $parents = NULL, $status = NULL) {

  global $UPLINK;
  $returnArr = array();


  $SKILLSTATUS = "AND status='active' ";

  if($status == 'beta') {
    $SKILLSTATUS = "AND status='active' OR status='beta'";
  } else if($status == 'active') {
    $SKILLSTATUS = "AND status='active' OR status='alpha' OR status='beta'";
  }

  if(isset($psychic) && $psychic != 'true') {
    $PSYSTATUS = "psychic = 'false' AND";
  } else {
    $PSYSTATUS = "";
  }

  $sql = "SELECT primaryskill_id, name, siteindex, psychic, parents, status FROM `ecc_skills_groups` WHERE ".$PSYSTATUS." parents='".$parents."' $SKILLSTATUS ORDER BY name ASC";
  $res = $UPLINK->query($sql);
  if($res && mysqli_num_rows($res) > 0) {

    while($row = mysqli_fetch_assoc($res)){

      $returnArr[] = $row;
    }
    return $returnArr;
  }
}
function getSkills($select = "newest", $parents = "all") {

  global $UPLINK;
  $returnArr = array();

  $sql = "SELECT skill_id, label, skill_index, parent, level, version, description FROM `ecc_skills_allskills`";

  if(isset($parents) && $parents != "all" && $parents != "") {
    $sql .= " WHERE parent = '".$parents."'";
  }

  $res = $UPLINK->query($sql);
  if($res && mysqli_num_rows($res) > 0) {

    while($row = mysqli_fetch_assoc($res)){

      if($select == "newest") {
        $returnArr[$row['skill_index']] = $row;
      } else {
        $returnArr[] = $row;
      }
    }
    return $returnArr;
  }
}
// END SILVESTER FUNCTIONS - THANKS!

function getSkillAugs($sheetID = null) {

  global $UPLINK,$jid;

}

function getFactionModifiers($faction) {

  global $UPLINK;

  if(isset($faction)) {
    $faction = strtolower($faction);

    // validate faction
    if($faction == "aquila" || $faction == "dugo" || $faction == "ekanesh" || $faction == "pendzal" || $faction == "sona") {

      $sql = "SELECT type, skill_id, cost_modifier FROM `ecc_factionmodifiers` WHERE faction_siteindex = '".mysqli_real_escape_string($UPLINK,$faction)."'";
      $res = $UPLINK->query($sql);
      if($res && mysqli_num_rows($res) > 0) {

        $returnArr = array();

        while($row = mysqli_fetch_assoc($res)){
          $returnArr[$row['skill_id']] = array();
          $returnArr[$row['skill_id']]['type'] = $row['type'];
          $returnArr[$row['skill_id']]['cost_modifier'] = $row['cost_modifier'];
        }
        return $returnArr;
      }

    } else {
      echo "<h1>[ERROR 622] NO VALID FACTION</h1>";
      exit();
    }
  } else {
    echo "<h1>[ERROR 623] NO FACTION SELECTED</h1>";
    exit();
  }

}
