<?php
// globals
include_once('./_includes/config.php');
include_once('./_includes/functions.global.php');
include_once('./header.php');

//if there is no active session, start one
if (!isset($_SESSION)) {
  session_start();
}

if (isset($_POST['newchar']) && $_POST['newchar'] != "") {require './operations/POST/newChar.php';}
?>

<div class="wsleft cell"></div>

<div class="main cell">
  <div class="content">
    <br />
    <?php
      $printresult = "";
      //Trigger the new character screen
      if (isset($_GET['newChar'])) {require './operations/GET/newChar.php';}
      //Activate a character
      else if (isset($_GET['activate']) && $_GET['activate'] != "") {require './operations/GET/activate.php';}
      //View a character
      else if (isset($_GET['viewChar']) && $_GET['viewChar'] != "") {require './operations/GET/viewChar.php';}
      //List your characters
      else {require './operations/GET/listChars.php';}

      echo $printresult;
      unset($printresult);
    ?>

    <div class="row">
      <div id="customForm"></div>
    </div>
  </div>
</div>

<div class="wsright cell"></div>

<?php
include_once('./footer.php');
