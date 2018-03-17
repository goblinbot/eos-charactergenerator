<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");
include_once($APP["root"] . "/_includes/functions.skills.php");

/* no login means NO PLAY. GET OUT. */
if(!isset($jid)) {
  echo "[ERR 440]";
  exit();
}
if(!isset($UPLINK)) {
  echo "[ERR 442]";
  exit();
}



if(isset($_POST['getSpecialtySkills']) && $_POST['getSpecialtySkills'] != "") {

  $printresult = "";

  $sql = "SELECT primaryskill_id, name FROM `ecc_skills_groups` WHERE parents = '".$_POST['getSpecialtySkills']."' ORDER BY name ASC";
  $res = $UPLINK->query($sql);
  if($res && mysqli_num_rows($res) > 0) {

    $printresult = array();

    while($row = mysqli_fetch_assoc($res)){

      $getSpecialty = getSkills("newest",$row['primaryskill_id']);
      $printresult[$row['primaryskill_id']] = array();

      $printresult[$row['primaryskill_id']][] = $row['primaryskill_id'];

      $printresult[$row['primaryskill_id']][] .= "<div id=\"sg_".$row['primaryskill_id']."\" class=\"skillgroup formitem\">"
      . "<label>". $row['name'] . "&nbsp;&nbsp;"
        . "<span class=\"search\" title=\"Preview skill\" onclick=\"previewSkill('".$row['primaryskill_id']."');\">"
        . "<i class=\"fa fa-info-circle\"></i>"
        . "</span>"
      ."</label>";
      $printresult[$row['primaryskill_id']][] .= "<div class=\"flex1\">";

      foreach($getSpecialty AS $Xspecialty) {

        $printresult[$row['primaryskill_id']][] .= "<input type=\"checkbox\""
          ." onclick=\"toggleSkillBoxes(this);\""
          ." name=\"skillform[skill]['".$Xspecialty['skill_id']."']\""
          ." class=\"skillcheck specialty\""
          ." data-siteindex=\"".$Xspecialty['skill_index']."\" "
          ." data-level=\"".(int)$Xspecialty['level']."\""
          ." data-skillgroup=\"".(int)$row['primaryskill_id']."\"/>&nbsp;";

      }
      $printresult[$row['primaryskill_id']][] .= "</div></div>"; //flex 1

    }

  }

  $printresult = json_encode($printresult);
  echo $printresult; unset($printresult);
  exit();
}



if(isset($_POST['previewSkill']) && $_POST['previewSkill'] != ""){

  $getSkills = getSkills("newest",$_POST['previewSkill']);

  $printresult = "";

  if($getSkills && $getSkills != "") {
    $i = 0;
    foreach($getSkills AS $skill) {

      $i++;
      $class = ($i == 1 ? "active\" " : "\" style=\"display:none;\" ");

      $printresult .= "<div class=\"tab $class>"
        . "<h2>".$skill['label']."</h2>"
        . "<br/>"."<p>"
        . "<a href=\"javascript:void(0)\" class=\"button ".($i == 1 ? "disabled\" disabled " : "\"")." onclick=\"navPreview('prev');\"><i class=\"fa fa-arrow-left\"></i></a>"
        . "<a class=\"button disabled\">Level ".$skill['level']."</a>"
        . "<a href=\"javascript:void(0)\" class=\"button ".($i == 5 ? "disabled\" disabled " : "\"")." onclick=\"navPreview('next');\"><i class=\"fa fa-arrow-right\"></i></a>"
        . "</p>"."<br/>"
        . "<p>".$skill['description']."</p>"
      ."</div>";

    }
  }

  echo $printresult;
  unset($printresult); unset($getSkills);
  exit();
}
