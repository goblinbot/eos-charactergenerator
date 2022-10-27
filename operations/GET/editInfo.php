<?php
              $printresult .= '<a href="./handler/fileupload/index.php?viewChar='. $character['characterID'] . '">'
                . "<img class=\"passphoto popout\" alt=\"Upload File \" onerror=\"this.src='./img/default.png';\""
                . ' src="' . $APP['header'] . '/img/passphoto/' . $character['characterID'] . '.jpg?' . time() . '"/></a>'
                . '<style>.grid .main .content .row {width: auto;}</style>'
                . '<div class="row">'
                . '<a href="'. $APP['header'] .'/index.php?viewChar='. $character['characterID'] .'"><button><i class="fas fa-arrow-left"></i>&nbsp;Back to character options</button></a>'
                . '</div>'
                . '<hr/>';

              // edit char set? Validate.
              if (isset($_POST['editchar']) && $_POST['editchar'] != "") {
                updateCharacterInfo($_POST['editchar'], $character['characterID']);
                header("location: {$APP['header']}/index.php?viewChar={$character['characterID']}&editInfo=true&u=1");
                exit();
              }

              $printresult .= '<div class="row flexcolumn">';

              $printresult .=
                "<p>&nbsp;</p>"
                . "<p>This is where you edit your character's basic information.</p>"
                . "<p>&nbsp;</p>"
                . "<p>Don't worry about knowing or entering all the details right now, you can revisit this page any time.</p>"
                . "<p>&nbsp;</p>"
                . '<form action="' . $APP['header'] . '/index.php?viewChar=' . $character['characterID'] . '&editInfo=true" method="post">';

              $printresult .=
                '<div class="formitem">'
                . '<h3><i class="fas fa-user"></i>&nbsp;Character Name</h3>'
                . '<input autocomplete="off" type="text" placeholder="Character Name" maxlength="99" name="editchar[character_name]" value="' . EMS_echo($character['character_name']) . '"></input>'
                . '</div>';

                $printresult .=
                  '<div class="formitem">'
                . '<h3><i class="fas fa-users"></i>&nbsp;Faction</h3>'
                . '<p class="text-muted">' . ucfirst(EMS_echo($character['faction'])) . '</p>'
                . '</div>'
                . '<div class="formitem">'
                . '<h3><i class="fas fa-key"></i>&nbsp;ICC Number:</h3>'
                . '<p class="text-muted">' . EMS_echo($character['ICC_number']) . '</p>'
                . '</div>'
                . '<div class="formitem">'
                . '<h3><i class="far fa-calendar-alt"></i>&nbsp;Birth date</h3>'
                . '<input autocomplete="off" type="text" placeholder="..( current IC year: 240NT )" maxlength="24" name="editchar[ic_birthday]" value="' . EMS_echo($character['ic_birthday']) . '"></input>'
                . '</div>';

              $printresult .=
                '<div class="formitem">'
                . "<h3><i class=\"fas fa-globe\"></i>&nbsp;Birth planet</h3>"
                . "<input autocomplete=\"off\" type=\"text\" placeholder=\"...\" maxlength=\"99\" name=\"editchar[birthplanet]\" value=\"" . EMS_echo($character['birthplanet']) . "\"></input>"
                . "</div>"

                . "<div class=\"formitem\">"
                . "<h3><i class=\"fas fa-globe\"></i>&nbsp;Current/home planet</h3>"
                . "<input autocomplete=\"off\" type=\"text\" placeholder=\"...\" maxlength=\"99\" name=\"editchar[homeplanet]\" value=\"" . EMS_echo($character['homeplanet']) . "\"></input>"
                . "</div>";

              $printresult .=
                "<div class=\"formitem\">"
                . "<p>&nbsp;</p>"
                . "<input type=\"submit\" class=\"button green\" value=\"Save changes\"></input>"
                . "</div>"
                . "</div>"
                . "</form>";