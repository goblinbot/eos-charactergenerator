<?php
      $printresult = '<h1>Create a character</h1> <hr/>
                      <p>First, choose your faction.</p>
                      <form method="POST" action="' . $APP['header'] . '/index.php">';

      $printresult .= '<div class="formitem center-xs">'
                      . '<select name="newchar" id="chooseFactionSelect" onchange="switchFactionBlurb(this.value);">'
                      . '<option value="aquila">Aquila</option>'
                      . '<option value="dugo">Dugo</option>'
                      . '<option value="ekanesh">Ekanesh</option>'
                      . '<option value="pendzal">Pendzal</option>'
                      . '<option value="sona">Sona</option>'
                      . '</select>'
                      . '</div>';

      $printresult .= '<div class="formitem">
                      <input type="submit" class="button blue" value="Create character"></input>';

if ($sheetArr['characters'] && count($sheetArr['characters']) > 0) {
    $printresult .= '&nbsp;<a class="button" href='. $APP['header'] . '/index.php>Back</a>';
}

      $printresult .= '</div>
        </form>';

      $printresult .= '<div id="fct_aquila" class="formitem dialog factionblurb" style="display: block;">'
                      . '<h2 class="center-xs"><i class="far fa-lightbulb"></i>&nbsp;Aquila</h2>'
                      . '<p>One of the two biggest and oldest factions. This republic judges citizens by the '
                      . 'military service they put in and have a fondness for bureaucracy and universal modularity. '
                      . 'They believe everyone should be able to treat a basic injury and love their forcefield systems.</p>'
                      . '</div>';

      $printresult .= '<div id="fct_dugo" class="formitem dialog factionblurb">'
                      . '<h2 class="center-xs"><i class="far fa-lightbulb"></i>&nbsp;Dugo</h2>'
                      . '<p>Ancient rival of the Aquila faction and therefore the other main power. The Dugo society functions on '
                      . 'specialists doing their one thing and doing that excellently. Personal responsibility and a quantifiable '
                      . 'measure of Honour are the core tenets for this Caste-ruled Empire where 95% passes through the military to '
                      . 'gain the right of expressing their soul via a melee weapon they may carry anywhere..</p>'
                      . '</div>';

      $printresult .= '<div id="fct_ekanesh" class="formitem dialog factionblurb">'
                      . '<h2 class="center-xs"><i class="far fa-lightbulb"></i>&nbsp;Ekanesh</h2>'
                      . '<p>A Lost expedition to Eos from centuries past, these ex-Aquila came back changed forever. Following the '
                      . 'light of their goddess Maïr on a mission to save humanity from the Alien Threat, their general incompatibility'
                      . 'with advanced technology is more than made up for with Psionic powers and alien growths called Symbionts to '
                      . 'fill the skill gaps they may face.</p>'
                      . '</div>';

      $printresult .= '<div id="fct_pendzal" class="formitem dialog factionblurb">'
                      . '<h2 class="center-xs"><i class="far fa-lightbulb"></i>&nbsp;Pendzal</h2>'
                      . '<p>Uncountable clans break up the Pendzal planetary borders with their own territories but work together '
                      . 'when they have to. Personal freedom of choice is an inviolable human right to these engineers at heart, and '
                      . 'they fought their way out of the Aquila and Dugo in bitter separation wars to gain the recognition they deserved.</p>'
                      . '</div>';

      $printresult .= '<div id="fct_sona" class="formitem dialog factionblurb">'
                      . '<h2 class="center-xs"><i class="far fa-lightbulb"></i>&nbsp;Sona</h2>'
                      . '<p>Financial responsibility equates to legal maturity for these mercantile nomadic-inspired businessmen. Their '
                      . 'lush style of living and financial prowess made sure these information brokers secured worlds of their own and '
                      . 'managed to abolish all other currencies in favour of their universal standard, the Sonur.</p>'
                      . '</div>';

