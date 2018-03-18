<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");

  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

  if(!isset($_GET['viewChar']) || $_GET['viewChar'] == "") {
    echo "<h1>Error 0444</h1>";
    exit();
  }

  if(isset($sheetArr['characters'][$_GET['viewChar']]) && $sheetArr['characters'][$_GET['viewChar']] != "") {
    $activeCharacter = $sheetArr['characters'][$_GET['viewChar']];

    if(count($activeCharacter['sheets']) > 0) {

      // check if a charSheet is selected.
      if(isset($_GET['viewSheet']) && (int)$_GET['viewSheet'] != 0) {

        $activeCharacter['sheets'][$_GET['viewSheet']] = getFullCharSheet($_GET['viewSheet']);

        if(count($activeCharacter['sheets'][$_GET['viewSheet']]) > 0) {

          if(!isset($activeCharacter['sheets'][$_GET['viewSheet']]['status']) || $activeCharacter['sheets'][$_GET['viewSheet']]['status'] != 'noskill') {
            $activeCharacter['sheets'][$_GET['viewSheet']]['exp_total'] = calcTotalExp($activeCharacter['sheets'][$_GET['viewSheet']]['aantal_events']);
            $activeCharacter['sheets'][$_GET['viewSheet']]['exp_used'] = calcUsedExp(EMS_echo($activeCharacter['sheets'][$_GET['viewSheet']]['skills']), $activeCharacter['faction']);
          }

        } else {
          $activeCharacter['sheets'][$_GET['viewSheet']]['status'] = 'noskill';
        }

      } else {

      }

    }


  } else {
    echo "<h1>Error 0451</h1>";
    exit();
  }


  if(isset($_POST['updateNickname']) && $_POST['updateNickname']) {
    $newNickname = EMS_echo($_POST['updateNickname']['value']);
    // $newNickname = silvesterFilter($newNickname);
    $newNickname = trim($newNickname);

    $sql = "UPDATE `ecc_char_sheet`
      SET `nickname` = '".mysqli_real_escape_string($UPLINK,$newNickname)."'
      WHERE `charSheetID` = '".mysqli_real_escape_string($UPLINK,$_GET['viewSheet'])."'
      AND `accountID` = '".mysqli_real_escape_string($UPLINK,$jid)."'";
    $res = $UPLINK->query($sql);

    header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']."&viewSheet=".$_GET['viewSheet']." ");
    exit();

    echo $sql;
  }

  if(isset($_POST['updateEventsPlayed']) && $_POST['updateEventsPlayed']) {
    $xINPUT = EMS_echo($_POST['updateEventsPlayed']['value']);
    $xINPUT = (int)$xINPUT;

    if($xINPUT > 20 || $xINPUT < 0) {
      $xINPUT = 0;
    }


    $sql = "UPDATE `ecc_char_sheet`
      SET `aantal_events` = '".mysqli_real_escape_string($UPLINK,(int)$xINPUT)."'
      WHERE `charSheetID` = '".mysqli_real_escape_string($UPLINK,$_GET['viewSheet'])."'
      AND `accountID` = '".mysqli_real_escape_string($UPLINK,$jid)."'";
    $res = $UPLINK->query($sql);

    header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']."&viewSheet=".$_GET['viewSheet']." ");
    exit();

    echo $sql;
  }

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">

    <?php
      if(!isset($activeCharacter["character_name"]) || $activeCharacter["character_name"] == "") {
        $activeCharacter["character_name"] = "[CHARACTER NAME]";
      }
    ?>

    <h1><?=$activeCharacter["character_name"]?>&nbsp;-&nbsp;<?=EMS_echo($activeCharacter["faction"])?></h1>

    <?php
      if(isset($activeCharacter['sheets'])) {
        if(count($activeCharacter['sheets']) > 0) {
          if(isset($_GET['viewSheet']) && (int)$_GET['viewSheet'] != 0) {
            echo "<p class=\"text-bold\">Nickname: ". EMS_echo($activeCharacter['sheets'][$_GET['viewSheet']]['nickname']) ."</p>"
            . "<p class=\"text-bold\">Events played: ". EMS_echo($activeCharacter['sheets'][$_GET['viewSheet']]['aantal_events']) ."</p>"
            . "<br/>";
          }
        }
      }
    ?>

    <div class="row">
      <?php
      if(isset($_GET['viewSheet']) && $_GET['viewSheet'] != "") {
        ?><a href="<?=$APP['header']?>/index.php?viewChar=<?=$activeCharacter['characterID']?>" class="button"><?php
      } else {
        ?><a href="<?=$APP['header']?>/index.php" class="button"><?php
      }
      ?>
        <i class="fas fa-arrow-left"></i>&nbsp;Back
      </a>
    </div>

    <hr>

    <?php

      if(isset($activeCharacter['sheets'])) {

        if(count($activeCharacter['sheets']) > 0) {

          if(isset($_GET['viewSheet']) && (int)$_GET['viewSheet'] != 0) {

            // buttons?
            echo "<div class=\"row\">";

            echo "<div class=\"box33\">"
              ."<a class=\"\" href=\"".$APP['header']."/stats/skills.php?viewChar=".$_GET['viewChar']."&viewSheet=".$_GET['viewSheet']."\">"
                ."<button type=\"button\" class=\"button bar blue\" name=\"button\"><i class=\"fas fa-book\"></i>&nbsp;Skills</button>"
              ."</a>"
            ."</div>";

            echo "<div class=\"box33\">"
              ."<a class=\"\" href=\"".$APP['header']."/stats/implants.php?viewChar=".$_GET['viewChar']."&viewSheet=".$_GET['viewSheet']."\">"
                ."<button type=\"button\" class=\"button bar blue\" name=\"button\"><i class=\"fas fa-microchip\"></i>&nbsp;Implants/Symbionts</button>"
              ."</a>"
            ."</div>";

            echo "<div class=\"box33\">"
              ."<a class=\"disabled\" href=\"".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']."&viewSheet=".$_GET['viewSheet']."\">"
                ."<button type=\"button\" class=\"button bar blue disabled\" name=\"button\"><i class=\"fas fa-file-code\"></i>&nbsp;Export to JSON</button>"
              ."</a>"
            ."</div>";

            echo "</div>";

            echo "<div class=\"row\">";

            echo "<div class=\"box33\">"
              ."<a onclick=\"SH_nicknameForm('".$_GET['viewChar']."','".$_GET['viewSheet']."')\">"
                ."<button type=\"button\" class=\"button blue no-bg bar\" name=\"button\"><i class=\"fas fa-sticky-note\"></i>&nbsp;Nickname this sheet</button>"
              ."</a>"
            ."</div>";

            echo "<div class=\"box33\">"
              ."<a onclick=\"SH_editPlayedForm('".$_GET['viewChar']."','".$_GET['viewSheet']."')\">"
                ."<button type=\"button\" class=\"button blue no-bg bar\" name=\"button\"><i class=\"fas fa-sort-numeric-up\"></i>&nbsp;Events Played</button>"
              ."</a>"
            ."</div>";

            echo "<div class=\"box33\">"
              ."<a class=\"disabled\" href=\"".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']."&viewSheet=".$_GET['viewSheet']."\">"
                ."<button type=\"button\" class=\"button bar green disabled\" name=\"button\"><i class=\"fas fa-question\"></i>&nbsp;Review</button>"
              ."</a>"
            ."</div>";

            echo "</div>";

            // if(isset($activeCharacter['sheets'][$_GET['viewSheet']]['status']) && $activeCharacter['sheets'][$_GET['viewSheet']]['status'] == "ontwerp") {
            //
            //   echo "<div class=\"row\">"
            //     ."<div class=\"box33\">"
            //       ."<a class=\"disabled\" href=\"".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']."&deleteSheet=".$_GET['viewSheet']."\">"
            //         ."<button type=\"button\" class=\"button disabled bar\" name=\"button\"><i class=\"fas fa-trash-alt\"></i>&nbsp;Delete sheet</button>"
            //       ."</a>"
            //     ."</div>"
            //     ."<div class=\"box33\">NEEDS A CONFIRMATION DIALOGUE</div>"
            //     ."<div class=\"box33\"></div>"
            //   ."</div>";
            // }

            // make place for the handler to play with, when for example changing the character sheet "events played".
            echo "<div class=\"row\">"
              ."<hr style=\"opacity: 0.1; flex: 1; width: 100%;\" />"
            ."</div>"
            ."<div class=\"row flex-column\">"
                ."<div id=\"sheetTopLevelForm\"></div>"
              ."</div>";

            if(!isset($activeCharacter['sheets'][$_GET['viewSheet']]['status']) || $activeCharacter['sheets'][$_GET['viewSheet']]['status'] != "noskill") {

              // sheet

            } else {
              // no skills bound to sheet yet.
            }

          } else {

            if(isset($_GET['createSheet']) && $_GET['createSheet'] != "") {

              if(isset($_POST['newSheet']) && $_POST['newSheet'] != "") {

                // check if the character is.. well, alive.
                check4dead($_GET['viewChar']);

                $_POST['newSheet'] = (int)$_POST['newSheet'];

                if($_POST['newSheet'] < 0) {
                  $_POST['newSheet'] = 0;
                } else if ($_POST['newSheet'] > 21 ) {
                  $_POST['newSheet'] = 21;
                }

                $sql = "INSERT INTO `ecc_char_sheet`
                  (
                    `characterID`,
                    `accountID`,
                    `aantal_events`,
                    `versionNumber`
                  ) VALUES (
                    '".mysqli_real_escape_string($UPLINK,(int)$_GET['viewChar'])."',
                    '".mysqli_real_escape_string($UPLINK,(int)$jid)."',
                    '".mysqli_real_escape_string($UPLINK,(int)$_POST['newSheet'])."',
                    '1'
                  );";
                $res = $UPLINK->query($sql) or trigger_error(mysqli_error($res));

                header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']." ");
                exit();

              }

              echo "<form method=\"POST\" action=\"".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']."&createSheet=true\">"

                ."<div class=\"formitem\">"
                  ."<h3>Amount of events played as this character:</h3>"
                  ."<input name=\"newSheet\" placeholder=\"0\" type=\"number\" value=\"0\" min=\"0\" max=\"21\" required=\"required\"></input>"
                ."</div>"

                ."<div class=\"formitem\">"
                  ."<input type=\"submit\" class=\"button blue\" value=\"Create sheet\"></input>"
                ."</div>"
              ."</form>";

            } else if(isset($_GET['copySheet']) && (int)$_GET['copySheet'] != 0) {

              check4dead($_GET['viewChar']);
              //copy sheet

            // } else if(isset($_GET['deleteSheet']) && (int)$_GET['deleteSheet'] != 0) {

              //delete sheet: validate eerst.
              // $sql = "SELECT charSheetID, status
              //   FROM `ecc_char_sheet`
              //   WHERE accountID = '".mysqli_real_escape_string($UPLINK,$jid)."'
              //   AND charSheetID = '".mysqli_real_escape_string($UPLINK,$_GET['deleteSheet'])."'
              //   AND characterID = '".mysqli_real_escape_string($UPLINK,$_GET['viewChar'])."'
              // LIMIT 1";
              // $res = $UPLINK->query($sql) or trigger_error(mysqli_error($res));
              //
              // check4dead($_GET['viewChar']);
              //
              // if(mysqli_num_rows($res) > 0) {
              //
              //   $row = mysqli_fetch_assoc($res);
              //   if($row['status'] == 'ontwerp') {
              //     $sql = "DELETE FROM `ecc_char_sheet` WHERE `charSheetID` = '".mysqli_real_escape_string($UPLINK,$_GET['deleteSheet'])."' AND accountID = '".mysqli_real_escape_string($UPLINK,$jid)."'";
              //     $res = $UPLINK->query($sql);
              //   }
              //
              //   header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']." ");
              //   exit();
              // }

            } else {

              // set the header
              echo "<div class=\"character header\">"
              . "<div class=\"block\">Nickname</div>"
              . "<div class=\"block\">Events played</div>" // amount of events played
                . "<div class=\"block\">Status</div>" // faction
                . "<div class=\"block\">&nbsp;</div>" // edit
              . "</div>";

              // print sheets
              foreach ($activeCharacter['sheets'] AS $key => $value) {

                echo "<div class=\"character\">"
                . "<div class=\"block\">".EMS_echo($value['nickname'])."</div>"
                . "<div class=\"block\">".(int)$value['aantal_events']."</div>"
                . "<div class=\"block\">".($value['status'] == 'ontwerp' ? 'in design' : $value['status'])."</div>";

                echo "<div class=\"block btnmenu\">"

                  . "<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&viewSheet=".$value['charSheetID']."\" class=\"button blue\">"
                    ."<i class=\"fas fa-eye\"></i>&nbsp;View"
                  ."</a>";

                  // . "<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&copySheet=".$value['charSheetID']."\" class=\"button green\" onclick=\"return confirm('Are you sure you want to copy this character sheet?')\">"
                  //   . "<i class=\"far fa-copy\"></i>&nbsp;New&nbsp;Version"
                  // . "</a>";

                // if($value['status'] == 'ontwerp') {
                //   echo "&nbsp;" . "<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&deleteSheet=".$value['charSheetID']."\" class=\"button\" onclick=\"return confirm('Are you sure?')\">"
                //     ."<i class=\"fas fa-trash\"></i>&nbsp;Delete"
                //   ."</a>";
                // }

                echo "</div>"
                . "</div>";

              }

              echo "<br/><a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&createSheet=true\" class=\"button no-bg green\"><i class=\"fas fa-user-plus\"></i>&nbsp;New sheet</a>";

            }


          }

        } else {

          // no sheet yet? No problem. Make the first one.
          $sql = "INSERT INTO `ecc_char_sheet` (
              `characterID`,
              `accountID`,
              `aantal_events`
            ) VALUES (
              '".mysqli_real_escape_string($UPLINK,(int)$_GET['viewChar'])."',
              '".mysqli_real_escape_string($UPLINK,(int)$jid)."',
              '0'
            );";

          // $res = $UPLINK->query($sql) or die(mysqli_error($UPLINK));
          $res = $UPLINK->query($sql);

          header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']);
          exit();
        }
      } else {

      }


    ?>

    <div id="customForm" class="row"></div>
  </div>


</div>

<div class="wsright cell"></div>

<?php
  include_once($APP["root"] . "/footer.php");
