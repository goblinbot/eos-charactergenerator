<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");


  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('home');?>
</div>

<div id="maincell" class="main cell">
  <div class="content">

    <h1>Eos Character Creator</h1>

    <br/>

    <?php
      if(!isset($_COOKIE['cookieWarning'])) {
    ?>
    <div class="dialog">

      <h2><i class="far fa-lightbulb"></i>&nbsp;Cookies</h2>

      <p>The character creator uses <strong>functional</strong> cookies, none of which will track you, or collect data.</p>

      <br/>

      <button class="button" onclick="ecc_setCookie('cookieWarning','hide','3');$(this).parent().fadeOut();">
        <i class="fas fa-check green"></i>&nbsp;Understood, hide this message please.
      </button>
    </div>
    <?php
      }
    ?>

  </div>
</div>

<div class="wsright cell"></div>




<?php
  include_once($APP["root"] . "/footer.php");
