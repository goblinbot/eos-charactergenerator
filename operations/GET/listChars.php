<?php
if (in_array("30", $jgroups) || in_array("8", $jgroups)) {
    echo '<a href="https://persona.eosfrontier.space">'
    .  '<button class="blue bar no-bg" style="min-width: 12rem;">Go To SL NPC Menu</button>'
    . ' </a>';
}
      $printresult = '<h1>Your character(s)</h1><hr/>';

      // validate if characters has been set by the getsheets function
if (is_array($sheetArr['characters'])) {

    $printresult .= "<div class=\"row flexcolumn\">";

    // are there any characters?
    if (count($sheetArr['characters']) > 0) {

          // set the header
          $printresult .= '<div class="character header">'
            . '<div class="block smflex" style="min-width: 12rem;">&nbsp;</div>' // user icon
            . '<div class="block">Full name</div>' // char name
            . '<div class="block">Faction</div>' // faction
            . '<div class="block">&nbsp;</div>'
            . '<div class="block">&nbsp;</div>'
            . '</div>';

          // iterate through the characters
        foreach ($sheetArr['characters'] as $character) {

            if ($character['sheet_status'] !== "active") {
                $ACTIVATE = "<a href=\"{$APP['header']}/index.php?activate={$character['characterID']}\">
                  <button class=\"blue bar no-bg\" style=\"min-width: 12rem;\">activate/play</button>
                </a>";
            } else {
                $ACTIVATE = "<button disabled class=\"green no-bg disabled\" style=\"min-width: 12rem;\">active</button>";
            }

            $printresult .= '<div class="character">'
            . '<div class="block smflex" style="width: 10rem;">' . $ACTIVATE . '</div>'
            . '<div class="block">' . ucfirst($character['character_name']) . '</div>' // char name
            . '<div class="block">' . ucfirst($character['faction']) . '</div>' // faction
            . '<div class="block">'
            . '<a href="' . $APP['header'] . '/index.php?viewChar=' . $character['characterID'] . '">'
            . '<button class="blue bar"><i class="fas fa-folder-open"></i>&nbsp;View</button>'
            . '</a>'
            . '</div>';


            $printresult .= "</div>";
        }

          unset($xCLASS);
          unset($xICON);
    }
          $printresult .= '</div><div class="row xs-horizontal">'
          . '<a href="' . $APP['header'] . '/index.php?newChar">'
          . '<button type="button" class="green no-bg" name="button"><i class="fas fa-user-plus"></i>&nbsp;New character</button>'
          . '</a>'
          . '</div>';
}
