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
  <h1>#1: CSS SUB GRID GEBRUIKEN IN MAIN</h1>
    <hr/>
  <h1>#2: IDENTIEKE DIV/INPUTS MAKEN OM INTERACTIVE/VASTE TE SPLITTEN</h1>
    <hr/>
  <h1>#3: + EN -</h1>
    <hr/>
  <h1>#4: GETIMPLANTS()</h1>
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
            // if(isset($characterSheet['skills']) && $characterSheet['skills'] != "") {
              $exp['exp_used'] = calcUsedExp(EMS_echo($characterSheet['skills']), $character['faction']);
            // } else {
            //   $exp['exp_used'] = 0;
            // }

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
            $printresult .= "<div class=\"row\">"
                            . "<div class=\"expbar\">"
                              . "<div class=\"counter\">Exp&nbsp;total:&nbsp;".$exp['exp_total']."</div>"
                              . "<div class=\"counter\" id=\"EXPUSED\">Exp&nbsp;used:&nbsp;".$exp['exp_used']."</div>"
                            . "</div>"
                          . "</div>";

            // Back button
            $printresult .= "<div class=\"row\">"
                            ."<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']."&viewSheet=".$_GET['viewSheet']."\">"
                              ."<button><i class=\"fas fa-arrow-left\"></i>&nbsp;Back</button>"
                            ."</a>"
                          ."</div>"
                        ."<hr/>";

            // check for sheet, then check for status
            if(isset($characterSheet) && $characterSheet != "") {

              $printresult .= "<form id=\"skillsheet\" method=\"post\" action=\"skills.php\">"
                . "<div class=\"row skillbox\">"
                  . "<div class=\"half\">";

              // is the CHARACTER in design mode, AND is the character SHEET?
              if($character['status'] == 'in design' && $characterSheet['status'] == 'ontwerp') {

                // echo "<pre>";
                // var_dump($characterSheet);
                // echo "</pre>";

                foreach($skillGroupArr AS $skillGroup) {

                  $printresult .= "<div id=\"sg_".$skillGroup['primaryskill_id']."\" class=\"skillgroup formitem\">";
                  $printresult .= "<label>". $skillGroup['name'] ."</label>"."<br/>";

                  $getSkills = getSkills("newest",$skillGroup['primaryskill_id']);

                  foreach($getSkills AS $skills) {

                    // $printresult .= $skills['label'] . ' | ' . $skills['skill_index'] . ' | ' .' lvl '. $skills['level'];
                    $printresult .= "[";

                    $checked = "";
                    $inputfield = "";


                    if(isset($characterSheet['skills'][$skills['skill_index']]) && $characterSheet['skills'][$skills['skill_index']] != "") {

                      $printresult .= "X";

                      if($skills['level'] == 5) {

                        $xPSY = $skillGroup['psychic'];
                        $xPARENT = $skillGroup['siteindex'];
                        $xSTATUS = $sheetArr["characters"][$_GET['viewChar']]['status'];
                        $specialtySKILLS = getSkillGroup($xPSY,$xPARENT,$xSTATUS);

                        foreach($specialtySKILLS AS $specialty) {
                          // $printresult .= "<pre> == ".$specialty['name']." UNLOCKED</pre>";
                          $printRes2 .= "<div id=\"sg_".$specialty['primaryskill_id']."\" class=\"skillgroup formitem\">";
                          $printRes2 .= "<label>=&nbsp;". $specialty['name'] ."</label>"."<br/>";

                          $printRes2 .= "[?]&nbsp;[?]&nbsp;[?]&nbsp;[?]&nbsp;[?]";

                          $printRes2 .= "</div>";
                        }

                      }

                    } else {
                      $printresult .= "_";
                    }

                    $printresult .= "]&nbsp;";

                  }

                  $printresult .= "</div>";
                  // $printresult .= $printRes2;
                  // unset($printRes2);
                }


              } else {

                // STATUS  NIET IN ONTWERP MODUS

              }


              $printresult .= "</div>"
                ."<div class=\"half\">"
                  ."<div class=\"dialog\"><h2>Skill</h2><h3>[ Name LVL 0 ]</h3><hr/><p>Hier een blok reserveren voor skillinfo etc, en hier dan ONDER de specialisaties stoppen?</p></div>"
                  ."<hr style=\"opacity: 0.25;\"/>"
                  . $printRes2
                ."</div>"
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

<div class="wsright cell"></div>

<?php
  include_once($APP["root"] . "/footer.php");
