<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");


echo "<p>Renamed</p>";

// Rename the char_sheet_id to charID
$sql = "ALTER TABLE `ecc_char_skills` CHANGE `char_sheet_id` `charID` INT(11) NOT NULL";
$UPLINK->query($sql);