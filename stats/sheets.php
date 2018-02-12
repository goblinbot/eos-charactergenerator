<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eos-charactergenerator/_includes/config.php");
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
            $activeCharacter['sheets'][$_GET['viewSheet']]['exp_used'] = calcUsedExp($activeCharacter['sheets'][$_GET['viewSheet']]['skills'], $activeCharacter['faction']);
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

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">

    <h1><?=EMS_echo($activeCharacter["character_name"])?>&nbsp;-&nbsp;<?=EMS_echo($activeCharacter["faction"])?></h1>

    <div class="row">
      <a href="<?=$APP['header']?>/characters.php?viewChar=<?=$activeCharacter['characterID']?>" class="button">
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
              ."<a class=\"\" href=\"".$APP['header']."/stats/skills.php?viewChar=".$_GET['viewChar']."&viewsheet=".$_GET['viewSheet']."\">"
                ."<button type=\"button\" class=\"button bar blue\" name=\"button\"><i class=\"fas fa-book\"></i>&nbsp;Skills</button>"
              ."</a>"
            ."</div>";

            echo "<div class=\"box33\">"
              ."<a class=\"\" href=\"".$APP['header']."/stats/implants.php?viewChar=".$_GET['viewChar']."&viewsheet=".$_GET['viewSheet']."\">"
                ."<button type=\"button\" class=\"button bar blue\" name=\"button\"><i class=\"fas fa-microchip\"></i>&nbsp;Implants/Symbionts</button>"
              ."</a>"
            ."</div>";

            echo "<div class=\"box33\">"
              ."<a class=\"disabled\" href=\"".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']."&viewsheet=".$_GET['viewSheet']."\">"
                ."<button type=\"button\" class=\"button bar disabled\" name=\"button\"><i class=\"fas fa-question\"></i>&nbsp;Review</button>"
              ."</a>"
            ."</div>";

            echo "</div>";

            if(!isset($activeCharacter['sheets'][$_GET['viewSheet']]['status']) || $activeCharacter['sheets'][$_GET['viewSheet']]['status'] != "noskill") {

              // sheet

            } else {
              // no skills bound to sheet yet.
            }

          } else {

            if(isset($_GET['createSheet']) && $_GET['createSheet'] != "") {

              if(isset($_POST['newSheet']) && $_POST['newSheet'] != "") {

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
                    `version_number`
                  ) VALUES (
                    '".mysqli_real_escape_string($UPLINK,(int)$_GET['viewChar'])."',
                    '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."',
                    '".mysqli_real_escape_string($UPLINK,(int)$_POST['newSheet'])."',
                    '1'
                  );";
                $res = $UPLINK->query($sql);

                header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']." ");
                exit();

              }

              echo "<form method=\"POST\" action=\"".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']."&createSheet=true\">"

                ."<div class=\"formitem\">"
                  ."<h3>Amount of events played as this character:</h3>"
                  ."<input name=\"newSheet\" placeholder=\"0\" type=\"number\" min=\"0\" max=\"21\" required=\"required\"></input>"
                ."</div>"

                ."<div class=\"formitem\">"
                  ."<input type=\"submit\" class=\"button blue\" value=\"Create sheet\"></input>"
                ."</div>"
              ."</form>";

            } else if(isset($_GET['copySheet']) && (int)$_GET['copySheet'] != 0) {

              //copy sheet

            } else if(isset($_GET['deleteSheet']) && (int)$_GET['deleteSheet'] != 0) {

              //delete sheet: validate eerst.
              $sql = "SELECT charSheetID
                FROM `ecc_char_sheet`
                WHERE accountID = '".mysqli_real_escape_string($UPLINK,$TIJDELIJKEID)."'
                AND charSheetID = '".mysqli_real_escape_string($UPLINK,$_GET['deleteSheet'])."'
                AND characterID = '".mysqli_real_escape_string($UPLINK,$_GET['viewChar'])."'
              LIMIT 1";
              $res = $UPLINK->query($sql);

              if(mysqli_num_rows($res) > 0) {
                $sql = "DELETE FROM `ecc_char_sheet` WHERE `charSheetID` = '".mysqli_real_escape_string($UPLINK,$_GET['deleteSheet'])."' AND accountID = '".mysqli_real_escape_string($UPLINK,$TIJDELIJKEID)."'";
                $res = $UPLINK->query($sql);

                header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$activeCharacter['characterID']." ");
                exit();
              }

            } else {

              // set the header
              echo "<div class=\"character header\">"
                . "<div class=\"block smflex\">Name</div>" // char name
                . "<div class=\"block smflex\">Status</div>" // faction
                . "<div class=\"block smflex\">Events played</div>" // amount of events played
                . "<div class=\"block\">&nbsp;</div>" // edit
              . "</div>";

              // print sheets
              foreach ($activeCharacter['sheets'] AS $key => $value) {

                echo "<div class=\"character\">"
                . "<div class=\"block smflex\">".EMS_echo($activeCharacter["character_name"])."</div>"
                . "<div class=\"block smflex\">".$value['status']."</div>"
                . "<div class=\"block smflex\">".(int)$value['aantal_events']."</div>";

                echo "<div class=\"block\" style=\"text-align: left;\">"

                  . "<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&viewSheet=".$value['charSheetID']."\" class=\"button blue\">"
                    ."<i class=\"far fa-folder-open\"></i>&nbsp;Open"
                  ."</a>"

                  . "&nbsp;"

                  . "<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&copySheet=".$value['charSheetID']."\" class=\"button green\" onclick=\"return confirm('Are you sure?')\">"
                    . "<i class=\"far fa-copy\"></i>&nbsp;New Version"
                  . "</a>";

                if($value['status'] == 'ontwerp') {
                  echo "&nbsp;" . "<a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&deleteSheet=".$value['charSheetID']."\" class=\"button\" onclick=\"return confirm('Are you sure?')\">"
                    ."<i class=\"fas fa-trash\"></i>&nbsp;Delete"
                  ."</a>";
                }

                echo "</div>"
                . "</div>";

              }

              echo "<br/><a href=\"".$APP['header']."/stats/sheets.php?viewChar=".$value['characterID']."&createSheet=true\" class=\"button green\"><i class=\"fas fa-user-plus\"></i>&nbsp;New sheet</a>";

            }


          }

        } else {

          // no sheet yet? No problem. Make the first one.
          $sql = "INSERT INTO `ecc_char_sheet`
            (
              `characterID`,
              `accountID`,
              `aantal_events`
            ) VALUES (
              '".mysqli_real_escape_string($UPLINK,(int)$_GET['viewChar'])."',
              '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."',
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

  </div>
</div>

<div class="wsright cell"></div>

<?php
  include_once($APP["root"] . "/footer.php");
