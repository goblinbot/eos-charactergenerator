<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eos-charactergenerator/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  // include_once($_CONFIG["root"] . "/_includes/includes.php");


  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('myaccount');?>
</div>

<div class="main cell">
  <div class="content">

    <h1>Account settings</h1>

  </div>
</div>

<div class="wsright cell"></div>




<?php
  include_once($APP["root"] . "/footer.php");