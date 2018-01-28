<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eos-charactergenerator/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  // include_once($_CONFIG["root"] . "/_includes/includes.php");


  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }


  if(isset($_POST['newchar']) && $_POST['newchar'] != "") {

    $_POST['newchar'] = strTolower($_POST['newchar']);

    if($_POST['newchar'] == "aquila"
    || $_POST['newchar'] == "dugo"
    || $_POST['newchar'] == "ekanesh"
    || $_POST['newchar'] == "pendzal"
    || $_POST['newchar'] == "sona") {

      $sql = "INSERT INTO `characters` (`accountID`, `faction`, `aantal_events`, `status`
        ) VALUES (
          '".(int)$TIJDELIJKEID."',
          '".mysqli_real_escape_string($UPLINK,$_POST['newchar'])."',
          '0',
          'in design'
        );";
      $res = $UPLINK->query($sql) or trigger_error(mysqli_error($UPLINK));

      header("location: ".$APP['header']."/characters.php");
      exit();

    } else {
      // invalid
    }

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
        $printresult = "<h1>Create a character</h1>"."<hr/>";

        $printresult .= "<p>First, choose your faction.</p>";

        $printresult .= "<form method=\"POST\" action=\"".$APP['header']."/characters.php\">";

        $printresult .=
          "<div class=\"formitem\">"
            ."<label>Faction</label>"
          ."</div>";

        $printresult .=
          "<div class=\"formitem\">"
            ."<select name=\"newchar\">"
              . "<option value=\"aquila\">Aquila</option>"
              . "<option value=\"dugo\">Dugo</option>"
              . "<option value=\"ekanesh\">Ekanesh</option>"
              . "<option value=\"pendzal\">Pendzal</option>"
              . "<option value=\"sona\">Sona</option>"
            . "</select>"
          ."</div>";

        $printresult .=
          "<div class=\"formitem\">"
            ."<input type=\"submit\" class=\"button blue\" value=\"Create character\"></input>"
          ."</div>";

        $printresult .= "</form>";

        $printresult .=
          "<div class=\"formitem\">"
            ."<p>(( korte omschrijving van de factie in 2 tot 5 zinnen. ))</p>"
          ."</div>";

           // "De Aquilaanse Republiek is een parlementaire democratie waar alle inwoners stemrecht moeten verdienen door dienstbaarheid, veelal in het leger. Hierdoor staan de Legioenen centraal in de maatschappij en zorgt voor een samenleving met plichtbesef, offergezindheid en grote politieke betrokkenheid. De keerzijde is het nodige misplaatste patriottisme en het neerkijken op zij die niet willen dienen, de Mulum. Als Aquilaan vind je spelmogelijkheden op alle lagen behalve misschien economie, vrijwel altijd met een militair tintje en een nadruk op teamwerk boven individueel gewin."

      } else if(isset($_GET['viewChar']) && $_GET['viewChar'] != "") {

        // show the character sheet and link to the skill calculator.
        $printresult = "<h1>(((character name)))</h1><hr/>";

      } else {

        // else: show the character list, or redirect to NEW CHAR if there are none.
        // if(isset($sheetArr['status']) && $sheetArr['status'] == 'noChar') {
        //   header("location: ".$APP['header']."/characters.php?newChar");
        //   exit();
        // }

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

          $printresult .=
            "<div class=\"row\">"
              ."<a href=\"".$APP['header']."/characters.php?newChar\">"
                ."<button type=\"button\" class=\"green\" name=\"button\"><i class=\"fa fa-user-plus\"></i>&nbsp;New character</button>"
              ."</a>"
            ."</div>";

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
