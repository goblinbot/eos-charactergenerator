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
<div class="wsleft cell">
  <?php /*
  <!-- <h1>#1: CSS SUB GRID GEBRUIKEN IN MAIN</h1>
    <hr/>
  <h1>#2: IDENTIEKE DIV/INPUTS MAKEN OM INTERACTIVE/VASTE TE SPLITTEN</h1>
    <hr/>
  <h1>#3: + EN -</h1>
    <hr/>
  <h1>#4: GETIMPLANTS()</h1> -->

  */?>
</div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">
  <?php
    $printresult = "";
    $printRes2 = "";

    // check if characters is valid
      if(is_array($sheetArr['characters'])) {
        if(count($sheetArr['characters']) > 0) {

          if(isset($sheetArr["characters"][$_GET['viewChar']]['accountID']) && EMS_echo($sheetArr["characters"][$_GET['viewChar']]['accountID']) == $jid) {

            $character = $sheetArr["characters"][$_GET['viewChar']];
            $characterSheet = getFullCharSheet($_GET['viewSheet']);

            // calc skills
            $exp = array();
            $exp['exp_total'] = calcTotalExp($characterSheet['aantal_events']);
            $exp['exp_used'] = calcUsedExp(EMS_echo($characterSheet['skills']), $character['faction']);

            // faction skills [strong/weak]
            $factionMod = getFactionModifiers($character['faction']);
            $augmentations = getSkillAugs($_GET['viewSheet']);

            // echo "<pre>";
            // var_dump($factionMod);
            // echo "</pre>";
            // exit();

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

            // exp bar && Back button
            $printresult .=
              "<div class=\"row\">"
                . "<div class=\"expbar\">"
                    // ."<i class=\"fa fa-cog\"></i>&nbsp;EXP :&nbsp;"
                    ."EXP :&nbsp;"
                    ."<span id=\"expUsed\">".$exp['exp_used']."</span>"
                      ."&nbsp;/&nbsp;"
                    . "<span id=\"expTotal\">".$exp['exp_total']."</span>"

                  ."<a style=\"float:right;\" href=\"".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']."&viewSheet=".$_GET['viewSheet']."\">"
                    ."<button><i class=\"fas fa-arrow-left\"></i>&nbsp;Back</button>"
                  ."</a>"

                . "</div>"
              . "</div>"
              . "<hr style=\"opacity: 0.5;\"/>";


            // check for sheet, then check for status
            if(isset($characterSheet) && $characterSheet != "") {

              $printresult .= "<form id=\"skillsheet\" method=\"post\" action=\"skills.php\">"
                . "<div class=\"row skillbox\">"
                  . "<div class=\"half\">";

              // is the CHARACTER in design mode, AND is the character SHEET?
              if($character['status'] == 'in design' && $characterSheet['status'] == 'ontwerp') {

                foreach($skillGroupArr AS $skillGroup) {

                  $printresult .= "<div id=\"sg_".$skillGroup['primaryskill_id']."\" class=\"skillgroup formitem\">";

                  $xCLASS = "";
                  if(isset($factionMod[(int)$skillGroup['primaryskill_id']]) && $factionMod[(int)$skillGroup['primaryskill_id']] != "") {
                    if($factionMod[(int)$skillGroup['primaryskill_id']]['type'] == 'strong') {
                      $xCLASS = 'class="strong" ';
                    } else if ($factionMod[(int)$skillGroup['primaryskill_id']]['type'] == 'weak') {
                      $xCLASS = 'class="weak" ';
                    }
                  }

                  $printresult .= "<label ".$xCLASS.">". $skillGroup['name'] . "&nbsp;&nbsp;"
                  . "<span class=\"search\" title=\"Preview skill\" onclick=\"previewSkill('".$skillGroup['primaryskill_id']."');\">"
                  . "<i class=\"fa fa-info-circle\"></i>"
                  . "</span>"
                  ."</label>";

                  // get the skills
                  $getSkills = getSkills("newest",$skillGroup['primaryskill_id']);

                  $printresult .= "<div class=\"flex1\">";

                  foreach($getSkills AS $skills) {

                    // open the input
                    $printresult .= "<input type=\"checkbox\""
                    ." onclick=\"toggleSkillBoxes(this);\""
                    ." name=\"skillform[skill]['".$skills['skill_id']."']\""
                    ." class=\"skillcheck\""
                    ." data-index=\"".$skillGroup['siteindex']."\" "
                    ." data-siteindex=\"".$skills['skill_index']."\""
                    ." data-level=\"".(int)$skills['level']."\""
                    ." data-skillgroup=\"".(int)$skillGroup['primaryskill_id']."\" ";

                    if($skills['level'] == 1) {
                      if(isset($factionMod[(int)$skillGroup['primaryskill_id']]) && $factionMod[(int)$skillGroup['primaryskill_id']] != "") {

                        $printresult .= " data-expmodifier=\"".$factionMod[(int)$skillGroup['primaryskill_id']]['cost_modifier']."\" ";

                      }
                    }

                    $checked = "";
                    $inputfield = "";


                    if(isset($characterSheet['skills'][$skills['skill_index']]) && $characterSheet['skills'][$skills['skill_index']] != "") {

                      $printresult .= " checked=\"checked\" ";

                      if($skills['level'] == 5 && $characterSheet['aantal_events'] > 0) {

                        $xPSY = $skillGroup['psychic'];
                        $xPARENT = $skillGroup['siteindex'];
                        $xSTATUS = $sheetArr["characters"][$_GET['viewChar']]['status'];
                        $specialtySKILLS = getSkillGroup($xPSY,$xPARENT,$xSTATUS);

                        foreach($specialtySKILLS AS $specialty) {

                          $getSpecialty = getSkills("newest",$specialty['primaryskill_id']);

                          $printRes2 .= "<div id=\"sg_".$specialty['primaryskill_id']."\" class=\"skillgroup formitem\">";

                          $printRes2 .= "<label>". $specialty['name'] . "&nbsp;&nbsp;"
                            . "<span class=\"search\" title=\"Preview skill\" onclick=\"previewSkill('".$specialty['primaryskill_id']."');\">"
                            . "<i class=\"fa fa-info-circle\"></i>"
                            . "</span>"
                          ."</label>";

                          $printRes2 .= "<div class=\"flex1\">";

                          foreach($getSpecialty AS $Xspecialty) {

                            $printRes2 .= "<input type=\"checkbox\""
                              ." onclick=\"toggleSkillBoxes(this);\""
                              ." name=\"skillform[skill]['".$Xspecialty['skill_id']."']\""
                              ." class=\"skillcheck specialty\""
                              ." data-siteindex=\"".$Xspecialty['skill_index']."\" "
                              ." data-level=\"".(int)$Xspecialty['level']."\""
                              ." data-skillgroup=\"".(int)$specialty['primaryskill_id']."\" ";


                            if(isset($characterSheet['skills'][$Xspecialty['skill_index']]) && $characterSheet['skills'][$Xspecialty['skill_index']] != "") {

                              $printRes2 .= " checked=\"checked\" ";

                            }

                            // close the input
                            $printRes2 .= "/>&nbsp;";

                          }

                          $printRes2 .= "</div>"; //flex 1
                          $printRes2 .= "</div>";

                          unset($getSpecialty);
                        }

                      }

                    } else {
                      // $printresult .= "_";
                    }

                    // close the input
                    $printresult .= "/>&nbsp;";

                  }

                  $printresult .= "</div>"; //flex1
                  $printresult .= "</div>";
                  // $printresult .= $printRes2;
                  // unset($printRes2);
                }


              } else {

                // STATUS  NIET IN ONTWERP MODUS

              }


              $printresult .= "</div>"
              . "<div class=\"half\">";

              $printresult .= "<div id=\"previewSkill\" class=\"dialog\">"
                ."<br/><br/>"
                ."<h3 class=\"text-center\">Click the '<i class=\"fa fa-info-circle\"></i>' icons to preview the skills.</h3>"
              ."</div>";

              if($characterSheet['aantal_events'] > 0) {
                $printresult .= "<hr style=\"opacity: 0.25;\"/>"
                  . "<h4>SPECIALISATIONS</h4>"
                  . "<div id=\"specialtycontainer\">"
                  . $printRes2
                  . "</div>";
              }

              $printresult .=
                  "</div>"
                ."</div>"
              ."</form>";

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

<div class="wsright cell">
  <?php
    // echo "<pre>";
    // var_dump($_SESSION['skill']);
    // echo "</pre>";
  ?>
</div>

<?php
  include_once($APP["root"] . "/footer.php");
  ?>
  <script type="text/javascript" src="<?=$APP['header']?>/_includes/js/functions.skills.js"></script>
  <?php
