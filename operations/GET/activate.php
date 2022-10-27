<?php
      $sql = "UPDATE `ecc_characters`
          SET `sheet_status` = 'inactive'
          WHERE `accountID` = '" . mysqli_real_escape_string($UPLINK, $jid) . "'";
      $res = $UPLINK->query($sql);

      $sql = "UPDATE `ecc_characters`SET `sheet_status` = 'active'
          WHERE `characterID` = '" . mysqli_real_escape_string($UPLINK, (int)$_GET['activate']) . "'
          AND `accountID` = '" . mysqli_real_escape_string($UPLINK, $jid) . "'";
      $res = $UPLINK->query($sql);

if (isset($_GET['firstCharacter']) && $_GET['firstCharacter'] != "") {
    header("location: " . $APP['header'] . "/index.php?viewChar={$_GET['activate']}&editInfo=true");
    exit();
}

      header("location: " . $APP['header'] . "/index.php?u=1");
      exit();
