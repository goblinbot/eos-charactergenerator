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
  <?=generateMenu('home');?>
</div>

<div class="main cell">
  <div class="content">

    <h1>Eos Character Creator</h1>

    <button type="button" class="green" name="button">New character</button>
    <br>
    <button type="button" class="cyan" name="button">Add existing character</button>
    <br>
    <button type="button" class="blue" name="button">Edit a character</button>
    <br>
    <button type="button" class="" name="button">Placeholder</button>
    <br>
    <button type="button" class="disabled" name="button">Placeholder</button>
    <br><br><br>

    <button type="button" class="no-bg" name="button">Placeholder</button>
    <br>
    <button type="button" class="no-bg green" name="button">Placeholder</button>
    <br>
    <button type="button" class="no-bg cyan" name="button">Placeholder</button>
    <br>
    <button type="button" class="no-bg blue" name="button">Placeholder</button>
    <br>

  </div>
</div>

<div class="wsright cell"></div>




<?php
  include_once($APP["root"] . "/footer.php");
