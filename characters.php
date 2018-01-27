<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eos-charactergenerator/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  // include_once($_CONFIG["root"] . "/_includes/includes.php");


  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">

    <?php
      // echo "<pre>";
      // var_dump($sheetArr);
      // echo "</pre>";

      $printresult = "";

      if(isset($_GET['newChar'])) {
        // create a new Char.
        $printresult = "<h1>Create a character</h1><hr/>";

      } else if(isset($_GET['viewChar']) && $_GET['viewChar'] != "") {

        // show the character sheet and link to the skill calculator.
        $printresult = "<h1>(((character name)))</h1><hr/>";

      } else {

        // else: show the character list, or redirect to NEW CHAR if there are none.
        if(isset($sheetArr['status']) && $sheetArr['status'] == 'noChar') {
          header("location: ".$APP['header']."/characters.php?newChar");
          exit();
        }

        $printresult = "<h1>Your character(s)</h1><hr/>";

        // validate if characters has been set by the getsheets function
        if(is_array($sheetArr['characters'])) {

          $printresult .= "<div class=\"row flexcolumn\">";

          // are there any characters?
          if(count($sheetArr['characters']) > 0) {

            // set the header
            $printresult .= "<div class=\"character header\">"
            . "<div class=\"block smflex hidden-xs\">&nbsp;</div>" // user icon
            . "<div class=\"block\">Full name</div>" // char name
            . "<div class=\"block\">Faction</div>" // faction
            . "<div class=\"block smflex\">Played</div>" // amount of events played
            . "<div class=\"block\">Status</div>" // status of character (active, design, deceased, etc)
            . "<div class=\"block\">&nbsp;</div>" // edit

          . "</div>";

            // iterate through the characters
            foreach ($sheetArr['characters'] AS $character) {

              $xCLASS = "";

              // choose icon and style depending on the character's STATUS.
              switch(strTolower(EMS_echo($character['status']))) {
                case 'in design': default:
                  $xICON = "<i class=\"fa fa-user-o\"></i>";
                  break;
                case 'deceased':
                  $xICON = "<i class=\"fa fa-user-times mute\"></i>";
                  $xCLASS = " text-muted";
                  break;
                case 'inactive':
                  $xICON = "<i class=\"fa fa-user mute\"></i>";
                  $xCLASS = " text-muted";
                  break;
                case 'ready':
                  $xICON = "<i class=\"fa fa-check green\"></i>";
                  $xCLASS = " active";
                  break;
              }

              $printresult .=
              "<div class=\"character".$xCLASS."\">"
                . "<div class=\"block smflex hidden-xs\">".$xICON."</div>" // user icon
                . "<div class=\"block\">" . $character['character_name'] . "</div>" // char name
                . "<div class=\"block\">" . $character['faction'] . "</div>" // faction
                . "<div class=\"block smflex\">" . (int)$character['aantal_events'] . "&nbsp;times</div>" // amount of events played
                . "<div class=\"block\">" . $character['status'] . "</div>" // status of character (active, design, deceased, etc)
                . "<div class=\"block\"><button class=\"blue bar\"><i class=\"fa fa-folder\"></i>&nbsp;View</button></div>" // edit

              . "</div>";

            }

            unset($xCLASS);
            unset($xICON);

          }
          $printresult .= "</div>";
        }

      }

      echo $printresult;
      unset($printresult);

    ?>

  </div>
</div>

<div class="wsright cell"></div>




<?php
  include_once($APP["root"] . "/footer.php");
