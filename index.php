<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");


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

      $psyCharacter = ($_POST['newchar'] == 'ekanesh' ? 'true' : 'false');

      $ICCID = generateICCID($_POST['newchar']);

      $sql = "INSERT INTO `ecc_characters` (`accountID`, `faction`, `status`, `psychic`, `ICC_number`)
        VALUES (
          '".(int)$jid."',
          '".mysqli_real_escape_string($UPLINK,$_POST['newchar'])."',
          'in design',
          '".mysqli_real_escape_string($UPLINK,$psyCharacter)."',
          '".mysqli_real_escape_string($UPLINK,$ICCID)."'
        );";
      $res = $UPLINK->query($sql) or trigger_error(mysqli_error($UPLINK));

      header("location: ".$APP['header']."/index.php");
      exit();

    } else {
      // invalid
    }

  }

?>
<div class="wsleft cell"></div>

<div class="main cell">
  <div class="content">

    <br/>

    <?php
      if(!isset($_COOKIE['cookieWarning'])) {
      ?>
      <div class="dialog">

        <h2><i class="far fa-lightbulb"></i>&nbsp;Cookies</h2>

        <p>The character creator uses <strong>functional</strong> cookies, none of which will track you, or collect data.</p>

        <br/>

        <button class="button" onclick="ecc_setCookie('cookieWarning','hide','3');$(this).parent().fadeOut();">
          <i class="fas fa-check green"></i>&nbsp;Understood, hide this message please.
        </button>
      </div>
      <?php
      }

      $printresult = "";

      if(isset($_GET['newChar'])) {
        // create a new Char.
        $printresult = "<h1>Create a character</h1>"."<hr/>";

        $printresult .= "<p>First, choose your faction.</p>";

        $printresult .= "<form method=\"POST\" action=\"".$APP['header']."/index.php\">";

        $printresult .=
          "<div class=\"formitem center-xs\">"
            ."<select name=\"newchar\" id=\"chooseFactionSelect\" onchange=\"switchFactionBlurb(this.value);\">"
              . "<option value=\"aquila\">Aquila</option>"
              . "<option value=\"dugo\">Dugo</option>"
              . "<option value=\"ekanesh\">Ekanesh</option>"
              . "<option value=\"pendzal\">Pendzal</option>"
              . "<option value=\"sona\">Sona</option>"
            . "</select>"
          ."</div>";

        $printresult .=
          "<div class=\"formitem\">"
            ."<input type=\"submit\" class=\"button blue\" value=\"Create character\"></input>";

        if($sheetArr['characters'] && count($sheetArr['characters']) > 0) {
          $printresult .= "&nbsp;<a class=\"button\" href=".$APP['header']."/index.php\">Back</a>";
        }

        $printresult .= "</div>
        </form>";

        $printresult .= "<div id=\"fct_aquila\" class=\"formitem dialog factionblurb\" style=\"display: block;\">"
            ."<h2 class=\"center-xs\"><i class=\"far fa-lightbulb\"></i>&nbsp;Aquila</h2>"
            ."<p>One of the two biggest and oldest factions. This republic judges citizens by the military service they put in and have a fondness for bureaucracy and universal modularity. They believe everyone should be able to treat a basic injury and love their forcefield systems.</p>"
          ."</div>";

        $printresult .= "<div id=\"fct_dugo\" class=\"formitem dialog factionblurb\">"
            ."<h2 class=\"center-xs\"><i class=\"far fa-lightbulb\"></i>&nbsp;Dugo</h2>"
            ."<p>Ancient rival of the Aquila faction and therefore the other main power. The Dugo society functions on specialists doing their one thing and doing that excellently. Personal responsibility and a quantifiable measure of Honour are the core tenets for this Caste-ruled Empire where 95% passes through the military to gain the right of expressing their soul via a melee weapon they may carry anywhere..</p>"
          ."</div>";

        $printresult .= "<div id=\"fct_ekanesh\" class=\"formitem dialog factionblurb\">"
            ."<h2 class=\"center-xs\"><i class=\"far fa-lightbulb\"></i>&nbsp;Ekanesh</h2>"
            ."<p>A Lost expedition to Eos from centuries past, these ex-Aquila came back changed forever. Following the light of their goddess Maïr on a mission to save humanity from the Alien Threat, their general incompatibility with advanced technology is more than made up for with Psionic powers and alien growths called Symbionts to fill the skill gaps they may face.</p>"
          ."</div>";

        $printresult .= "<div id=\"fct_pendzal\" class=\"formitem dialog factionblurb\">"
            ."<h2 class=\"center-xs\"><i class=\"far fa-lightbulb\"></i>&nbsp;Pendzal</h2>"
            ."<p>Uncountable clans break up the Pendzal planetary borders with their own territories but work together when they have to. Personal freedom of choice is an inviolable human right to these engineers at heart, and they fought their way out of the Aquila and Dugo in bitter separation wars to gain the recognition they deserved.</p>"
          ."</div>";

        $printresult .= "<div id=\"fct_sona\" class=\"formitem dialog factionblurb\">"
            ."<h2 class=\"center-xs\"><i class=\"far fa-lightbulb\"></i>&nbsp;Sona</h2>"
            ."<p>Financial responsibility equates to legal maturity for these mercantile nomadic-inspired businessmen. Their lush style of living and financial prowess made sure these information brokers secured worlds of their own and managed to abolish all other currencies in favour of their universal standard, the Sonur.</p>"
          ."</div>";

           // "De Aquilaanse Republiek is een parlementaire democratie waar alle inwoners stemrecht moeten verdienen door dienstbaarheid, veelal in het leger. Hierdoor staan de Legioenen centraal in de maatschappij en zorgt voor een samenleving met plichtbesef, offergezindheid en grote politieke betrokkenheid. De keerzijde is het nodige misplaatste patriottisme en het neerkijken op zij die niet willen dienen, de Mulum. Als Aquilaan vind je spelmogelijkheden op alle lagen behalve misschien economie, vrijwel altijd met een militair tintje en een nadruk op teamwerk boven individueel gewin."

      } else if(isset($_GET['activate']) && $_GET['activate'] != "") {

        $sql = "UPDATE `ecc_characters`
          SET `sheet_status` = 'inactive'
          WHERE `accountID` = '".mysqli_real_escape_string($UPLINK,$jid)."'";
        $res = $UPLINK->query($sql);

        $sql = "UPDATE `ecc_characters`
          SET `sheet_status` = 'active'
          WHERE `characterID` = '".mysqli_real_escape_string($UPLINK,(int)$_GET['activate'])."'
          AND `accountID` = '".mysqli_real_escape_string($UPLINK,$jid)."'";
        $res = $UPLINK->query($sql);
 
        header("location: ".$APP['header']."/index.php?u=1");
        exit();

      } else if(isset($_GET['viewChar']) && $_GET['viewChar'] != "") {

        if(isset($_POST['updateEventsPlayed']) && $_POST['updateEventsPlayed']) {
          $xINPUT = EMS_echo($_POST['updateEventsPlayed']['value']);
          $xINPUT = (int)$xINPUT;
      
          if($xINPUT > 50 || $xINPUT < 0) {
            $xINPUT = 0;
          }
      
          $sql = "UPDATE `ecc_characters`
            SET `aantal_events` = '".mysqli_real_escape_string($UPLINK,(int)$xINPUT)."'
            WHERE `characterID` = '".mysqli_real_escape_string($UPLINK,(int)$_GET['viewChar'])."'
            AND `accountID` = '".mysqli_real_escape_string($UPLINK,$jid)."'";
          $res = $UPLINK->query($sql);
      
          header("location: ".$APP['header']."/index.php?viewChar=".$_GET['viewChar']."&u=1");
          exit();
      
          echo $sql;
        }


        if(isset($_GET['u']) && $_GET['u'] == 1) {
          $printresult .= "<p class=\"dialog\"><i class=\"fas fa-check green\"></i>&nbsp;Updated succesfully.</p>";
        }

        // check if characters is valid
        if(is_array($sheetArr['characters'])) {
          if(count($sheetArr['characters']) > 0) {

            if(isset($sheetArr["characters"][$_GET['viewChar']]['accountID']) && EMS_echo($sheetArr["characters"][$_GET['viewChar']]['accountID']) == $jid) {

              // put the character into an easier to access variable for laziness.
              $character = $sheetArr["characters"][$_GET['viewChar']];

              if(EMS_echo($character['character_name']) != "") {
                $printresult .= "<h1>{$character['character_name']} - {$character['faction']}</h1>";
              } else {
                $printresult .= "<h1>[character name] - {$character['faction']}</h1>";
              }

              if(isset($_GET['editInfo']) && $_GET['editInfo'] == true) {

                $printresult .= "<img class=\"passphoto popout\" alt=\" \" src=\"{$APP['header']}/img/passphoto/{$character['characterID']}.jpg\" />"
                . "<style>.grid .main .content .row {width: auto;}</style>"
                . "<div class=\"row\">"
                    ."<a href=\"".$APP['header']."/index.php?viewChar={$character['characterID']}\"><button><i class=\"fas fa-arrow-left\"></i>&nbsp;Back</button></a>"
                  ."</div>"
                ."<hr/>";

                // edit char set? Validate.
                if(isset($_POST['editchar']) && $_POST['editchar'] != "") {

                  updateCharacterInfo($_POST['editchar'], $character['characterID']);
                  header("location: {$APP['header']}/index.php?viewChar={$character['characterID']}&editInfo=true&u=1");
                  exit();
                }

                $printresult .= "<div class=\"row flexcolumn\">";

                $printresult .= "<p>This is where you edit your character's basic information</p>"
                  ."<p>&nbsp;</p>"
                  ."<form action=\"{$APP['header']}/index.php?viewChar=".$character['characterID']."&editInfo=true\" method=\"post\">";

                $printresult .=
                  "<div class=\"formitem\">"
                    ."<h3><i class=\"fas fa-user\"></i>&nbsp;Character Name</h3>"
                    ."<input autocomplete=\"off\" type=\"text\" placeholder=\"Character Name\" maxlength=\"99\" name=\"editchar[character_name]\" value=\"".EMS_echo($character['character_name'])."\"></input>"
                  ."</div>";

                $printresult .=
                  "<div class=\"formitem\">"
                    ."<h3><i class=\"fas fa-users\"></i>&nbsp;Faction</h3>"
                    ."<p class=\"text-muted\">".ucfirst(EMS_echo($character['faction']))."</p>"
                  ."</div>"

                  ."<div class=\"formitem\">"
                    ."<h3><i class=\"fas fa-key\"></i>&nbsp;ICC Number:</h3>"
                    ."<p class=\"text-muted\">".EMS_echo($character['ICC_number'])."</p>"
                  ."</div>"

                  ."<div class=\"formitem\">"
                    ."<h3><i class=\"far fa-calendar-alt\"></i>&nbsp;Birth date</h3>"
                    ."<input autocomplete=\"off\" type=\"text\" placeholder=\"..( current IC year: 240NT )\" maxlength=\"24\" name=\"editchar[ic_birthday]\" value=\"".EMS_echo($character['ic_birthday'])."\"></input>"
                  ."</div>";

                $printresult .=
                  "<div class=\"formitem\">"
                    ."<h3><i class=\"fas fa-globe\"></i>&nbsp;Birth planet</h3>"
                    ."<input autocomplete=\"off\" type=\"text\" placeholder=\"...\" maxlength=\"99\" name=\"editchar[birthplanet]\" value=\"".EMS_echo($character['birthplanet'])."\"></input>"
                  ."</div>"

                  ."<div class=\"formitem\">"
                    ."<h3><i class=\"fas fa-globe\"></i>&nbsp;Current/home planet</h3>"
                    ."<input autocomplete=\"off\" type=\"text\" placeholder=\"...\" maxlength=\"99\" name=\"editchar[homeplanet]\" value=\"".EMS_echo($character['homeplanet'])."\"></input>"
                  ."</div>";

                $printresult .=
                  "<div class=\"formitem\">"
                    ."<p>&nbsp;</p>"
                    ."<input type=\"submit\" class=\"button green\" value=\"Save changes\"></input>"
                  ."</div>"
                ."</div>"
                ."</form>";

              } else {

                $printresult .= "<div class=\"row\">"
                    ."<a href=\"{$APP['header']}/index.php\"><button><i class=\"fas fa-arrow-left\"></i>&nbsp;Back</button></a>"
                  ."</div>"
                ."<hr/>";

                // default: character menu.
                $printresult .= "<div class=\"row\">";

                $printresult .= "<div class=\"box33\">"
                  ."<a href=\"{$APP['header']}/index.php?viewChar=".$character['characterID']."&editInfo=true\">"
                    ."<button type=\"button\" class=\"blue bar\" name=\"button\"><i class=\"far fa-id-card\"></i>&nbsp;Edit basic info</button>"
                  ."</a>"
                ."</div>";

                $printresult .= "<div class=\"box33\">"
                  ."<a href=\"{$APP['header']}/stats/skillsV2.php?viewChar={$character['characterID']}\">"
                    ."<button type=\"button\" class=\"blue bar\" name=\"button\"><i class=\"fas fa-book\"></i>&nbsp;Character Skills</button>"
                  ."</a>"
                ."</div>";

                $printresult .= "<div class=\"box33\">"
                  ."<a class=\"\" href=\"{$APP['header']}/stats/implantsV2.php?viewChar={$_GET['viewChar']}\">"
                    ."<button type=\"button\" class=\"button bar blue\" name=\"button\"><i class=\"fas fa-microchip\"></i>&nbsp;Implants/Symbionts</button>"
                  ."</a>"
                ."</div>";

                // end first row, start second row
                $printresult .= "</div><div class=\"row\">";


                $printresult .= "<div class=\"box33\">"
                  ."<a onclick=\"SH_editPlayedForm({$_GET['viewChar']})\">"
                    ."<button type=\"button\" class=\"button blue no-bg bar\" name=\"button\"><i class=\"fas fa-sort-numeric-up\"></i>&nbsp;Events Played</button>"
                  ."</a>"
                ."</div>";

                $printresult .= "<div class=\"box33\">"
                ."<a href=\"https://www.eosfrontier.space/bgcheck\" target=\"_blank\">"
                  ."<button type=\"button\" class=\"blue no-bg bar\" name=\"button\"><i class=\"fas fa-list\"></i>&nbsp;Background-check details</button>"
                ."</a>"
                ."</div>";


                $printresult .= "<div class=\"box33\">";

                  // if($character['status'] != "deceased") {
                  //
                  //   if($character['sheet_status']['code'] == 0) {
                  //
                  //     $printresult .= "<a class=\"\" href=\"".$APP['header']."/index.php?delChar=".$character['characterID']."\">"
                  //         ."<button type=\"button\" class=\"tomato bar\" name=\"button\"><i class=\"fas fa-user-times\"></i>&nbsp;Mark for delete</button>"
                  //       ."</a>";
                  //
                  //   } else if ($character['sheet_status']['code'] == 90) {
                  //
                  //     $printresult .= "<button type=\"button\" class=\"disabled bar\" name=\"button\"><i class=\"fas fa-times\"></i>&nbsp;Marked for delete</button>";
                  //
                  //   } else {
                  //
                  //     $printresult .= "<button type=\"button\" class=\"disabled bar\" name=\"button\"><i class=\"fas fa-user-times\"></i>&nbsp(Delete disabled)</button>";
                  //
                  //   }
                  //
                  // }

                $printresult .= "</div>"; //sluit box33


                $printresult .= "</div>";
                // end second row

              }


            } else {
              // error : account ID  doesn't match the logged in account ID !!
              $printresult .= "ERROR: NO MATCH.";

            }

          } else {
            header("location: ".$APP['header']."/index.php");
            exit();
          }
        } else {
          header("location: ".$APP['header']."/index.php");
          exit();
        }


      } else {

        $printresult = "<h1>Your character(s)</h1><hr/>";

        // validate if characters has been set by the getsheets function
        if(is_array($sheetArr['characters'])) {

          $printresult .= "<div class=\"row flexcolumn\">";

          // are there any characters?
          if(count($sheetArr['characters']) > 0) {

            // set the header
            $printresult .= "<div class=\"character header\">"
            . "<div class=\"block smflex\" style=\"min-width: 12rem;\">&nbsp;</div>" // user icon
            . "<div class=\"block\">Full name</div>" // char name
            . "<div class=\"block\">Faction</div>" // faction
            . "<div class=\"block\">&nbsp;</div>"
            . "<div class=\"block\">&nbsp;</div>"
          . "</div>";

            // iterate through the characters
            foreach ($sheetArr['characters'] AS $character) {

              if ($character['sheet_status'] !== "active") {
                $ACTIVATE = "<a href=\"".$APP['header']."/index.php?activate=".$character['characterID']."\">
                  <button class=\"blue bar no-bg\" style=\"min-width: 12rem;\">activate/play</button>
                </a>";
              } else {
                $ACTIVATE = "<button disabled class=\"green no-bg disabled\" style=\"min-width: 12rem;\">active</button>";
              }

              $printresult .=
              "<div class=\"character\">"
              . "<div class=\"block smflex\" style=\"width: 10rem;\">".$ACTIVATE."</div>"
                . "<div class=\"block\">" . ucfirst($character['character_name']) . "</div>" // char name
                . "<div class=\"block\">" . ucfirst($character['faction']) . "</div>" // faction
                . "<div class=\"block\">"
                    ."<a href=\"".$APP['header']."/index.php?viewChar=".$character['characterID']."\">"
                      ."<button class=\"blue bar\"><i class=\"fas fa-folder-open\"></i>&nbsp;View</button>"
                    ."</a>"
                  ."</div>";


              $printresult .= "</div>";

            }

            unset($xCLASS);
            unset($xICON);

          }
          $printresult .= "</div><div class=\"row xs-horizontal\">"
            ."<a href=\"".$APP['header']."/index.php?newChar\">"
              ."<button type=\"button\" class=\"green no-bg\" name=\"button\"><i class=\"fas fa-user-plus\"></i>&nbsp;New character</button>"
            ."</a>"
          ."</div>";

        }

      }

      echo $printresult; unset($printresult);

    ?>
    <div class="row">
      <div id="customForm"></div>
    </div>

  </div>

</div>

<div class="wsright cell"></div>

<?php
include_once($APP["root"] . "/footer.php");
