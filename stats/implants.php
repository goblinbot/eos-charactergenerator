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
      <a href="<?=$APP['header']?>/sheets.php?viewChar=<?=$_GET['viewChar']?>&amp;viewsheet=<?=$_GET['viewsheet']?>" class="button">
        <i class="fas fa-arrow-left"></i>&nbsp;Back
      </a>
    </div>

    <hr/>

    <h2>Symbionts, prosthetics, cybernetics, and other implants.</h2>

    <p>Here you can manage any form of augmentation your character could have. For the full ruling on augmentations and the sorts, see <a class="cyan underline" href="http://eosfrontier.space/handboeken/boek-2-crafting-economy" target="_blank">rulebook 2 (opens in a new tab)</a>.</p>
    <br/>
    <p>A bionic/symbiont <strong>can</strong> emulate a skill, causing your character to have that single skill active on his or her sheet. However, an implant added in this menu doesn't have to have that link - it can be added purely for flavour as well.</p>

    <pre>
      <?php var_dump($implantsArr); ?>
    </pre>

  </div>
</div>

<div class="wsright cell"></div>




<?php
  include_once($APP["root"] . "/footer.php");
