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

    <div class="row">

      <div class="box33">
        <a href="#">
          <button type="button" class="green bar" name="button"><i class="fa fa-user-plus"></i>&nbsp;New character</button>
        </a>
      </div>

      <div class="box33">
        <a href="#">
          <button type="button" class="blue bar" name="button"><i class="fa fa-user-plus"></i>&nbsp;Add an existing character</button>
        </a>
      </div>

      <div class="box33">
        <a href="#">
          <button type="button" class="blue bar" name="button"><i class="fa fa-user"></i>&nbsp;Edit a character</button>
        </a>
      </div>

    </div>






  </div>
</div>

<div class="wsright cell"></div>




<?php
  include_once($APP["root"] . "/footer.php");
