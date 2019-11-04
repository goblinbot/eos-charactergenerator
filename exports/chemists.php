<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");

  include_once('current-players.php');
  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

  ?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <h3 class="text-center">EXPORTS</h3>
</div>

<div class="main cell">
  <div class="content">

    <h1>IC Chemist overview</h1>
    <hr>

    <?php

    echo "<h3>Characters with biochemica 1 or higher</h3>";
    echo "<div style=\"width: 100%; flex: 1;\">";

      $printCharacters = array();

      // first grab the skills
      $sql = "SELECT char_sheet_id, skill_id FROM `ecc_char_skills` WHERE skill_id = '31082'";
      $res = $UPLINK->query($sql);

      if($res) {
        if(mysqli_num_rows($res) > 0) {

          while($row = mysqli_fetch_assoc($res)){

            $xSQL = "SELECT characterID FROM `ecc_char_sheet` WHERE charSheetID = '".$row['char_sheet_id']."' LIMIT 1";
            $xRES = $UPLINK->query($xSQL);

            if(mysqli_num_rows($xRES) == 1) {
              $xROW = mysqli_fetch_assoc($xRES);
              $yySQL = ar_getEventIDs();
              $yySQL = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as characterID, c1.character_name, c1.faction from jml_eb_registrants r
				join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
				join ecc_characters c1 on c1.characterID = SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1)
				where r.event_id = $EVENTID  and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method = 'os_paypal')) OR (r.published in (0,1) AND r.payment_method = 'os_offline'))
				AND characterID = '".$xROW['characterID']."' AND status != 'deceased' LIMIT 1";
              $yyRES = $UPLINK->query($yySQL);

              if(mysqli_num_rows($yyRES) == 1) {
                $yyROW = mysqli_fetch_assoc($yyRES);

                $printCharacters[$yyROW['characterID']]['id'] = $yyROW['characterID'];
                $printCharacters[$yyROW['characterID']]['name'] = $yyROW['character_name'];
                $printCharacters[$yyROW['characterID']]['faction'] = $yyROW['faction'];
              }

            }

          }

        }

        if(count($printCharacters)  > 0) {
          foreach($printCharacters AS $key => $value) {

            echo "<h4 style=\"width:auto; float: left; padding: 15px; margin: 5px; border: 1px solid #eee;\">".$value['name']." | ".$value['faction']."</h4>";
          }
        } else {
          echo "<h4>None.</h4>";
        }


      } else {
        echo "<h4>None.</h4>";
      }

    // echo "</div><br/><hr/><h3>Characters with biochemica augmentations</h3>";
    // echo "<div style=\"width: 100%; flex: 1;\">";
    //
    // $printCharacters = array();
    //
    // // first grab the skills
    // $sql = "SELECT sheetID FROM `ecc_char_implants` WHERE skillgroup_siteindex = 'chem' ";
    // $res = $UPLINK->query($sql);
    //
    // if($res) {
    //   if(mysqli_num_rows($res) > 0) {
    //
    //     while($row = mysqli_fetch_assoc($res)){
    //
    //       $xSQL = "SELECT characterID FROM `ecc_char_sheet` WHERE charSheetID = '".$row['sheetID']."' LIMIT 1";
    //       $xRES = $UPLINK->query($xSQL);
    //
    //       if(mysqli_num_rows($xRES) == 1) {
    //         $xROW = mysqli_fetch_assoc($xRES);
    //
    //         $yySQL = "SELECT characterID, character_name, faction FROM `ecc_characters` WHERE characterID = '".$xROW['characterID']."' LIMIT 1";
    //         $yyRES = $UPLINK->query($yySQL);
    //
    //         if(mysqli_num_rows($yyRES) == 1) {
    //           $yyROW = mysqli_fetch_assoc($yyRES);
    //
    //           $printCharacters[$yyROW['characterID']]['id'] = $yyROW['characterID'];
    //           $printCharacters[$yyROW['characterID']]['name'] = $yyROW['character_name'];
    //           $printCharacters[$yyROW['characterID']]['faction'] = $yyROW['faction'];
    //         }
    //
    //       }
    //
    //     }
    //
    //   }
    //
    //
    //   if(count($printCharacters)  > 0) {
    //
    //     foreach($printCharacters AS $key => $value) {
    //
    //       echo "<h4>*&nbsp;".$value['name']." | ".$value['faction']."</h4>";
    //     }
    //
    //   } else {
    //     echo "<h4>None.</h4>";
    //   }
    //
    // } else {
    //   echo "<h4>None.</h4>";
    // }

    echo "</div>";

    ?>
  </div>
</div>

<div class="wsright cell"></div>
  <?php
  include_once($APP["root"] . "/footer.php");
