<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");
  include_once($APP["root"] . "/_includes/functions.skills.php");

  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

  if(!isset($_GET['viewChar']) || $_GET['viewChar'] == "") {
    echo "<h1>Error 0444</h1>";
    exit();
  }

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">
  <?php
    $printresult = "";
    // check if characters is valid
      if(is_array($sheetArr['characters'])) {
        if(count($sheetArr['characters']) > 0) {

          if(isset($sheetArr["characters"][$_GET['viewChar']]['accountID']) && EMS_echo($sheetArr["characters"][$_GET['viewChar']]['accountID']) == $jid) {

            $character = $sheetArr["characters"][$_GET['viewChar']];
            $characterSheet = getFullCharSheet($_GET['viewSheet']);

            $isPsychic = $character['psychic'];
            $hasParent = "none";
            $isCurrent = $sheetArr["characters"][$_GET['viewChar']]['status'];
            $skillGroupArr = getSkillGroup($isPsychic,$hasParent,$isCurrent);

            // Character Banner
            if(EMS_echo($character['character_name']) != "") {
              $printresult .= "<h1><strong>skills:</strong>&nbsp;".$character['character_name']." - ".$character['faction']."</h1>";
            } else {
              $printresult .= "<h1><strong>skills:</strong>&nbsp;[character name] - ".$character['faction']."</h1>";
            }
            // Back button
            $printresult .= "<div class=\"row\">"
                ."<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']."&viewSheet=".$_GET['viewSheet']."\">"
                  ."<button><i class=\"fas fa-arrow-left\"></i>&nbsp;Back</button>"
                ."</a>"
              ."</div>"
            ."<hr/>";

            // check for sheet, then check for status
            if(isset($characterSheet) && $characterSheet != "") {

              $printresult .= "<div class=\"row skillbox\">"
              . "<div class=\"half\">";

              // is the CHARACTER in design mode, AND is the character SHEET?
              if($character['status'] == 'in design' && $characterSheet['status'] == 'ontwerp') {

                // echo "<pre>";
                // var_dump($characterSheet);
                // echo "</pre>";

              } else {

                // STATUS  NIET IN ONTWERP MODUS

              }

              foreach($skillGroupArr AS $skillGroup) {
                $printresult .= "<pre>" .$skillGroup['primaryskill_id'] . " / ". $skillGroup['name'] ."</pre>";

                $getSkills = getSkills("newest",$skillGroup['primaryskill_id']);

                foreach($getSkills AS $skills) {
                  $printresult .= "<pre> - ";
                  $printresult .= $skills['label'] . ' | ' . $skills['skill_index'] . ' | ' .' lvl '. $skills['level'];

                  if(isset($characterSheet['skills'][$skills['skill_index']]) && $characterSheet['skills'][$skills['skill_index']] != "") {
                    $printresult .= " XXXXXXXXXXXXXXXXXXXXXX";

                    if($skills['level'] == 5) {

                      $xPSY = $skillGroup['psychic'];
                      $xPARENT = $skillGroup['siteindex'];
                      $xSTATUS = $sheetArr["characters"][$_GET['viewChar']]['status'];
                      $specialtySKILLS = getSkillGroup($xPSY,$xPARENT,$xSTATUS);

                      foreach($specialtySKILLS AS $specialty) {
                        $printresult .= "<pre> == ".$specialty['name']." UNLOCKED</pre>";
                      }

                    }
                  }

                  $printresult .= "</pre>";
                }

              }

              $printresult .= "</div>"."<div class=\"half\"></div>"."</div>";

            } else {

              // error sheet is er niet?

            }

          } else {
            // error 451 because JID is lacking
          }
        }
      }

    echo $printresult;

    // echo "<br/><pre>";
    // var_dump($sheetArr["characters"][$_GET['viewChar']]);
    // var_dump($character);
    // echo "</pre>";
    // echo "<br/><pre>";
    // var_dump($getSkills);
    // echo "</pre>";
  ?>
  </div>
</div>

<div class="wsright cell"></div>

<?php
  include_once($APP["root"] . "/footer.php");
