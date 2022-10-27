<?php
// globals
include_once("../_includes/config.php");
include_once("../_includes/functions.global.php");
include_once("../_includes/functions.sheet.php");
include_once("../_includes/functions.skills.php");

include_once("../header.php");

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_GET['viewChar']) || $_GET['viewChar'] == "") {
  echo "<h1>Error 0444</h1>";
  exit();
}

?>
<div class="wsleft cell">

</div>

<div class="menu cell">
  <?= generateMenu('characters'); ?>
</div>

<div class="main cell">
  <div class="content">
    <?php

    $printresult = "";
    $printRes2 = "";

    // check if characters is valid
    if (is_array($sheetArr['characters'])) {
      if (count($sheetArr['characters']) > 0) {

        if (isset($sheetArr["characters"][$_GET['viewChar']]['accountID']) && EMS_echo($sheetArr["characters"][$_GET['viewChar']]['accountID']) == $jid) {

          $character = $sheetArr["characters"][$_GET['viewChar']];
          $character['skills'] = getCharacterSkills($_GET['viewChar']);

          echo "<div id=\"charStatus\" class=\"hidden\" style=\"display: none;\">" . $character['status'] . "</div>";

          // calc skills
          $exp = array();
          $exp['exp_total'] = calcTotalExp($character['aantal_events']);
          $exp['exp_used'] = calcUsedExp(EMS_echo($character['skills']), $character['faction']);

          if (isset($_POST['skillform']) && $_POST['skillform'] != "") {
            // first, we check if this character is actually alive. Oh bother.
            check4dead($_GET['viewChar']);

            // yes? okay. Third: Clear pre-existing entries.
            $sql = "DELETE FROM `ecc_char_skills` WHERE `charID` = '" . $_GET['viewChar'] . "' ";
            $res = $UPLINK->query($sql);

            foreach ($_POST['skillform']['skill'] as $SKid => $SKlevel) {

              $sql = "INSERT INTO `ecc_char_skills` (`skill_id`, `charID`) VALUES (
                      '" . (int)$SKid . "',
                      '" . mysqli_real_escape_string($UPLINK, $_GET['viewChar']) . "'
                    );";
              $res = $UPLINK->query($sql) or trigger_error(mysqli_error($UPLINK));
            }

            header('location: ' . $APP['header'] . '/stats/skillsV2.php?viewChar=' . $_GET['viewChar'] . '&update=true');
            exit();
          }
        }

        // faction skills [strong/weak]
        $factionMod = getFactionModifiers($character['faction']);
        $augmentations = getImplants($_GET['viewChar']);
        $augmentations = filterSkillAugs($augmentations);


        $isPsychic = $character['psychic'];
        $hasParent = "none";
        $isCurrent = $sheetArr["characters"][$_GET['viewChar']]['status'];
        $skillGroupArr = getSkillGroup($isPsychic, $hasParent, $isCurrent);

        // Character Banner
        if (EMS_echo($character['character_name']) != "") {
          $printresult .= "<h1><strong>skills:</strong>&nbsp;" . $character['character_name'] . " - " . $character['faction'] . "</h1>";
        } else {
          $printresult .= "<h1><strong>skills:</strong>&nbsp;[character name] - " . $character['faction'] . "</h1>";
        }

        // exp bar && Back button
        $printresult .=
          "<div class=\"row\">"
          . "<div class=\"expbar\">"

          . "EXP&nbsp;:&nbsp;"

          . "<span id=\"expUsed\" " . ($exp['exp_used'] > $exp['exp_total'] ? 'class="tomato"' : '') . ">" . $exp['exp_used'] . "</span>"
          . "&nbsp;/&nbsp;"
          . "<span id=\"expTotal\">" . $exp['exp_total'] . "</span>"

          . "<span style=\"float:right;\">"

          . "<a class=\"button\" href=\"" . $APP['header'] . "/index.php?viewChar=" . $_GET['viewChar'] . "\">"
          . "<i class=\"fas fa-arrow-left\"></i>&nbsp;Back"
          . "</a>&nbsp;";

        // if($characterSheet['status'] == 'ontwerp') {
        $printresult .= "<a class=\"button green no-bg\" href=\"javascript:void(0);\" onclick=\"submitSkillsheet();\">"
          . "<i class=\"fas fa-save\"></i>&nbsp;Save"
          . "</a>";
        // }

        $printresult .= "</span>"
          . "</div>"
          . "</div>"
          . "<hr style=\"opacity: 0.5;\"/>";


        // check for sheet, then check for status
        if (isset($character['skills']) && $character['skills'] != "") {

          $printresult .= "<form id=\"skillsheet\" method=\"post\" action=\"skillsV2.php?viewChar=" . $_GET['viewChar'] . "\">"
            . "<div class=\"row skillbox\">"
            . "<div class=\"half\">";

          // is the CHARACTER in design mode, AND is the character SHEET?
          // if($characterSheet['status'] == 'ontwerp') {

          foreach ($skillGroupArr as $skillGroup) {

            $printresult .= "<div id=\"sg_" . $skillGroup['primaryskill_id'] . "\" class=\"skillgroup formitem\">";

            $xCLASS = "";
            if (isset($factionMod[(int)$skillGroup['primaryskill_id']]) && $factionMod[(int)$skillGroup['primaryskill_id']] != "") {
              if ($factionMod[(int)$skillGroup['primaryskill_id']]['type'] == 'strong') {
                $xCLASS = 'class="strong" ';
              } else if ($factionMod[(int)$skillGroup['primaryskill_id']]['type'] == 'weak') {
                $xCLASS = 'class="weak" ';
              }
            }

            $printresult .= "<label " . $xCLASS . ">" . $skillGroup['name'] . "&nbsp;&nbsp;"
              . "<span class=\"search\" title=\"Preview skill\" onclick=\"previewSkill('" . $skillGroup['primaryskill_id'] . "');\">"
              . "<i class=\"fa fa-info-circle\"></i>"
              . "</span>"
              . "</label>";

            // get the skills
            $getSkills = getSkills("newest", $skillGroup['primaryskill_id']);

            $printresult .= "<div class=\"flex1\">";

            foreach ($getSkills as $skills) {

              // open the input
              $printresult .= "<input type=\"checkbox\""
                . " autocomplete=\"off\""
                . " onclick=\"toggleSkillBoxes(this);\""
                . " name=\"skillform[skill][" . $skills['skill_id'] . "]\""
                . " class=\"skillcheck\""
                . " value=\"" . (int)$skills['level'] . "\""
                . " data-index=\"" . $skillGroup['siteindex'] . "\" "
                . " data-siteindex=\"" . $skills['skill_index'] . "\""
                . " data-level=\"" . (int)$skills['level'] . "\""
                . " data-skillgroup=\"" . (int)$skillGroup['primaryskill_id'] . "\" ";

              if ($skills['level'] == 1) {
                if (isset($factionMod[(int)$skillGroup['primaryskill_id']]) && $factionMod[(int)$skillGroup['primaryskill_id']] != "") {
                  $printresult .= " data-expmodifier=\"" . $factionMod[(int)$skillGroup['primaryskill_id']]['cost_modifier'] . "\" ";
                }
              }

              $checked = "";
              $inputfield = "";

              if (isset($character['skills'][$skills['skill_index']]) && $character['skills'][$skills['skill_index']] != "") {

                $printresult .= " checked=\"checked\" ";

                if ($skills['level'] == 5 && $character['aantal_events'] > 0) {

                  $xPSY = $skillGroup['psychic'];
                  $xPARENT = $skillGroup['siteindex'];
                  $xSTATUS = $sheetArr["characters"][$_GET['viewChar']]['status'];
                  $specialtySKILLS = getSkillGroup($xPSY, $xPARENT, $xSTATUS);

                  foreach ($specialtySKILLS as $specialty) {

                    $getSpecialty = getSkills("newest", $specialty['primaryskill_id']);

                    $printRes2 .= "<div id=\"sg_" . $specialty['primaryskill_id'] . "\" class=\"skillgroup formitem\">";

                    $printRes2 .= "<label>" . $specialty['name'] . "&nbsp;&nbsp;"
                      . "<span class=\"search\" title=\"Preview skill\" onclick=\"previewSkill('" . $specialty['primaryskill_id'] . "');\">"
                      . "<i class=\"fa fa-info-circle\"></i>"
                      . "</span>"
                      . "</label>";

                    $printRes2 .= "<div class=\"flex1\">";

                    foreach ($getSpecialty as $Xspecialty) {

                      $printRes2 .= "<input type=\"checkbox\""
                        . " autocomplete=\"off\""
                        . " onclick=\"toggleSkillBoxes(this);\""
                        . " name=\"skillform[skill][" . $Xspecialty['skill_id'] . "]\""
                        . " class=\"skillcheck specialty\""
                        . " value=\"" . (int)$Xspecialty['level'] . "\""
                        . " data-parentID=\"" . $skillGroup['primaryskill_id'] . "\""
                        . " data-siteindex=\"" . $Xspecialty['skill_index'] . "\" "
                        . " data-level=\"" . (int)$Xspecialty['level'] . "\""
                        . " data-skillgroup=\"" . (int)$specialty['primaryskill_id'] . "\" ";


                      if (isset($character['skills'][$Xspecialty['skill_index']]) && $character['skills'][$Xspecialty['skill_index']] != "") {

                        $printRes2 .= " checked=\"checked\" ";
                      }

                      // close the input
                      $printRes2 .= "/>&nbsp;";
                    }

                    $printRes2 .= "</div>"; //flex 1
                    $printRes2 .= "</div>"; // end of 'specialty row'

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
            $printresult .= "</div>"; // end of skill row

            $augResult = 0;
            $printAugs = "";

            if (isset($augmentations) && $augmentations != "") {

              foreach ($augmentations as $aug) {
                if ($aug['skillgroup_siteindex'] == $skillGroup['siteindex']) {
                  $augResult = 1;
                  $printAugs .= "<p class=\"text-muted\">" . ($aug['type'] == 'cybernetic' ? '<i class="fa fa-cog"></i>' : '<i class="fa fa-bug"></i>') . "&nbsp;Augment: " . $aug['name'] . ' level ' . $aug['level'] . "</p>";
                }
              }
              // $skillGroup['skillgroup_siteindex']
              if ($augResult > 0) {
                $printresult .= "<div class=\"\">" . $printAugs . "</div>";
              }
            }
            // garbage collection:
            unset($augResult);
            unset($printAugs);
          }


          // } else {

          // STATUS  NIET IN ONTWERP MODUS


          // }


          $printresult .= "</div>"
            . "<div class=\"half\">";


          if (isset($_GET['update']) && $_GET['update'] == true) {

            $printresult .= "<div id=\"previewSkill\" class=\"dialog\">"
              . "<br/><br/>"
              . "<h1 class=\"text-center\"><strong><i class=\"fa fa-check green\"></i>&nbsp;Skills updated</strong></h1>"
              . "</div>";
          } else {

            $printresult .= "<div id=\"previewSkill\" class=\"dialog\">"
              . "<br/><br/>"
              . "<h3 class=\"text-center\">Click the '<i class=\"fa fa-info-circle\"></i>' icons to preview the skills.</h3>"
              . "</div>";
          }


          if ($character['aantal_events'] > 0) {
            $printresult .= "<hr style=\"opacity: 0.25;\"/>"
              . "<h4>SPECIALISATIONS</h4>"
              . "<div id=\"specialtycontainer\">"
              . $printRes2
              . "</div>";
          }

          $printresult .=
            "</div>"
            . "</div>"
            . "</form>";
        } else {

          // error sheet is er niet?

        }
      } else {
        // error 451 because JID is lacking
      }
    }
    // }

    echo $printresult;

    ?>
  </div>
</div>

<div class="wsright cell">

</div>

<?php
include_once($APP["root"] . "/footer.php");
?>
<script type="text/javascript" src="<?= $APP['header'] ?>/_includes/js/functions.skills.js"></script>
<?php
