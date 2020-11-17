<?php
// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");
include_once($APP["root"] . "/_includes/functions.sheet.php");
include_once($APP["root"] . "/_includes/functions.skills.php");

include_once($APP["root"] . "/header.php");

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_GET['viewChar']) || $_GET['viewChar'] == "") {
  echo "<h1>Error 0444</h1>";
  exit();
}

if (isset($_GET['viewSheet']) && $_GET['viewSheet'] != "") {
  $sql = "SELECT charSheetID FROM `ecc_char_sheet` WHERE accountID = '" . (int)$jid . "' AND characterID = '" . (int)$_GET['viewChar'] . "' AND charSheetID = '" . (int)$_GET['viewSheet'] . "' LIMIT 1";
  $res = $UPLINK->query($sql);

  if ($res && mysqli_num_rows($res) != 1) {
    echo "<h1>Error 0447 : invalid character/sheet combination.</h1>";
    exit();
  }
} else {
  echo "<h1>Error 0445</h1>";
  exit();
}

?>
<div class="wsleft cell">

</div>

<div class="menu cell">
  <?= generateMenu('characters'); ?>
</div>

<div class="main cell">
  <div class="content">
    <?php






    ?>
  </div>
</div>

<div class="wsright cell">

</div>

<?php
include_once($APP["root"] . "/footer.php");
