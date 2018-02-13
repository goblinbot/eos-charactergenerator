<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eos-charactergenerator/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");

  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

  $implantsArr = getImplants(EMS_echo($_GET['viewsheet']));

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">

    <h1>Augmentations</h1>

    <div class="row">
      <a href="<?=$APP['header']?>/stats/sheets.php?viewChar=<?=$_GET['viewChar']?>&amp;viewsheet=<?=$_GET['viewsheet']?>" class="button">
        <i class="fas fa-arrow-left"></i>&nbsp;Back
      </a>
    </div>

    <hr/>

    <?php
      if(!isset($_COOKIE['implantDialog'])) {
    ?>
    <div class="dialog">

      <h2><i class="fas fa-info-circle"></i>&nbsp;Symbionts, prosthetics, cybernetics, and other implants.</h2>

      <p>Here you can manage any form of augmentation your character could have. For the full ruling on augmentations and the sorts, see <a class="cyan underline" href="http://eosfrontier.space/handboeken/boek-2-crafting-economy" target="_blank">rulebook 2 (opens in a new tab)</a>.</p>
      <br/>
      <p>A bionic/symbiont <strong>can</strong> emulate a skill, causing your character to have that single skill active on his or her sheet. However, an implant added in this menu doesn't have to have that link - it can be added purely for flavour as well.</p>

      <br/><button class="button" onclick="ecc_setCookie('implantDialog','hide','1');$(this).parent().fadeOut();">
        <i class="fas fa-check green"></i>&nbsp;Understood, hide this message please.
      </button><br/>
    </div>
    <?php
      }
    ?>

    <div id="activeImplants">
    <?php

      $printresult = "<h3>Current augmentations:</h3>";

      foreach($implantsArr AS $implant) {

        if($implant['accountID'] == $TIJDELIJKEID) {

          // non-skill related implants
          if($implant['type'] == 'flavor') {

            $printresult .= "<div class=\"implant cybernetic\">"
                ."<div class=\"block\">"
                  ."<p>Description: ".EMS_echo($implant['description'])."</p>"
                ."</div>"
                . "<div class=\"block smflex\">"
                  ."Type: ".$implant['type']
                ."</div>"
                . "<div class=\"block smflex\">"
                  ."Status: ".$implant['status']
                ."</div>"
                . "<div class=\"block smflex\">"
                  ."<button type=\"button\" class=\"button blue\" name=\"button\"><i class=\"fas fa-cog\"></i>&nbsp;Edit</button>"
                ."</div>"
            . "</div>";

          // bionics! can emulate any non-telepsychic skill.
          } else if ($implant['type'] == 'cybernetic') {

            $printresult .= "<div class=\"implant cybernetic\">"
                ."<div class=\"block\">"
                  ."<p>Description: ".EMS_echo($implant['description'])."</p>"
                ."</div>"
                . "<div class=\"block smflex\">"
                  ."Type: ".$implant['type']
                ."</div>"
                . "<div class=\"block smflex\">"
                  ."Status: ".$implant['status']
                ."</div>"
                . "<div class=\"block smflex\">"
                  ."<button type=\"button\" class=\"button blue\" name=\"button\"><i class=\"fas fa-cog\"></i>&nbsp;Edit</button>"
                ."</div>"
            . "</div>";

          // symbionts! Tiny little wigglies that emulate willpower or telepsychica.
          } else if ($implant['type'] == 'symbiont') {

          }




        }

      }

      echo $printresult;

    ?>
    </div>

    <hr/>

    <button type="button" class="button" name="button"><i class="fas fa-plus"></i><br/>New</button>
    &nbsp;
    <button type="button" class="button" name="button"><i class="fas fa-question"></i><br/>Help</button>

    <hr/>

    <div id="implantForm">

    </div>

  </div>
</div>

<div class="wsright cell"></div>




<?php
  include_once($APP["root"] . "/footer.php");
