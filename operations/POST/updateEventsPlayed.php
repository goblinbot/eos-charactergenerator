<?php
        $xINPUT = EMS_echo($_POST['updateEventsPlayed']['value']);
        $xINPUT = (int)$xINPUT;

if ($xINPUT > 50 || $xINPUT < 0) {
    $xINPUT = 0;
}

        $sql = "UPDATE `ecc_characters`
            SET `aantal_events` = '" . mysqli_real_escape_string($UPLINK, (int)$xINPUT) . "'
            WHERE `characterID` = '" . mysqli_real_escape_string($UPLINK, (int)$_GET['viewChar']) . "'
            AND `accountID` = '" . mysqli_real_escape_string($UPLINK, $jid) . "'";
        $res = $UPLINK->query($sql);

        header("location: " . $APP['header'] . "/index.php?viewChar=" . $_GET['viewChar'] . "&u=1");
        exit();

        echo $sql;
