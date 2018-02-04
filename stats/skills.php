<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eos-charactergenerator/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");

  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

  if(!isset($_GET['viewChar']) || $_GET['viewChar'] == "") {
    echo "<h1>Error 0444</h1>";
    exit();
  }


?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">

    <h1>[CHARACTER NAME] - Skills</h1>

    <hr>

    <?php
      $characterSheet = getFullCharSheet($_GET['viewChar']);

      var_dump($characterSheet);




    ?>

  </div>
</div>

<div class="wsright cell"></div>

<?php
  include_once($APP["root"] . "/footer.php");
