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

  $sql = "SELECT primaryskill_id, name, siteindex, psychic, parents, status FROM `ecc_skills_groups` WHERE psychic='".$psychic."' AND parents='".$parents."' $SKILLSTATUS ORDER BY name ASC";
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
