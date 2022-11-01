<?php

if (isset($_POST['updateEventsPlayed']) && $_POST['updateEventsPlayed']) {
    include "./operations/POST/updateEventsPlayed.php";
}


if (isset($_GET['u']) && $_GET['u'] == 1) {
    $printresult .= "<p class=\"dialog\"><i class=\"fas fa-check green\"></i>&nbsp;Updated successfully.</p>";
}

      // check if characters is valid
if (is_array($sheetArr['characters'])) {
    if (count($sheetArr['characters']) > 0) {

        if (isset($sheetArr["characters"][$_GET['viewChar']]['accountID']) && EMS_echo($sheetArr["characters"][$_GET['viewChar']]['accountID']) == $jid) {

            // put the character into an easier to access variable for laziness.
            $character = $sheetArr["characters"][$_GET['viewChar']];

            if (EMS_echo($character['character_name']) != "") {
                $printresult .= "<h1>{$character['character_name']} - {$character['faction']}</h1>";
            } else {
                $printresult .= "<h1>[character name] - {$character['faction']}</h1>";
            }

            if (isset($_GET['editInfo']) && $_GET['editInfo'] == true) {include 'editInfo.php';
            }
            else {
                $printresult .= '<div class="row">'
                . '<a href="' . $APP['header'] . '/index.php"><button><i class="fas fa-arrow-left"></i>&nbsp;Back</button></a>'
                . '</div>'
                . '<hr/>';

                // default: character menu.
                $printresult .= '<div class="row">';

                $printresult .= '<div class="box33">'
                . '<a href="' . $APP['header'] . '/index.php?viewChar=' . $character['characterID'] . '&editInfo=true">'
                . '<button type="button" class="blue bar" name="button"><i class="far fa-id-card"></i>&nbsp;Edit basic info</button>'
                . '</a>'
                . '</div>'
                . '<div class="box33">'
                . '<a href="' . $APP['header'] .'/stats/skillsV2.php?viewChar=' . $character['characterID'] . '">'
                . '<button type="button" class="blue bar" name="button"><i class="fas fa-book"></i>&nbsp;Character Skills</button>'
                . '</a>'
                . '</div>'
                . '<div class="box33">'
                . '<a class="" href="' . $APP['header'] . '/stats/implantsV2.php?viewChar=' . $_GET['viewChar'] . '">'
                . '<button type="button" class="button bar blue" name="button"><i class="fas fa-microchip"></i>&nbsp;Implants/Symbionts</button>'
                . '</a>'
                . '</div></div>'; //end first row

                // start second row
                $printresult .= '<div class="row">'
                .'<div class="box33">'
                . '<a onclick="SH_editPlayedForm(' . $_GET['viewChar'] . ')">'
                . '<button type="button" class="button blue no-bg bar" name="button"><i class="fas fa-sort-numeric-up"></i>&nbsp;Events Played</button>'
                . '</a>'
                . '</div>'
                . '<div class="box33">'
                . '<a href="/bgcheck" target="_blank">'
                . '<button type="button" class="blue no-bg bar" name="button"><i class="fas fa-list"></i>&nbsp;Background-check details</button>'
                . '</a>'
                . '</div>'
                . '<div class="box33"></div>'
                . '</div>';// end second row
            }
        } else {
            // error : account ID  doesn't match the logged in account ID !!
            $printresult .= "ERROR: NO MATCH.";
        }
    } else {
                  header('location: ' . $APP['header'] . '/index.php');
                  exit();
    }
} else {
    header('location: ' . $APP['header'] . '/index.php');
    exit();
}
