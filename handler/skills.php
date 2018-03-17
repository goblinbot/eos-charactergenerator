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

  echo $printresult; unset($printresult); unset($getSkills);
  exit();

  // skill_id, label, skill_index, parent, level, version, description
}
