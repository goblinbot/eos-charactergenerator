<?php


$_POST['newchar'] = strTolower($_POST['newchar']);


$factions = [
    'aquila',
    'dugo',
    'ekanesh',
    'pendzal',
    'sona',
];

if (in_array($_POST['newchar'], $factions) ) {


    $psyCharacter = ($_POST['newchar'] == 'ekanesh' ? 'true' : 'false');

    $ICCID = generateICCID($_POST['newchar']);

    $sql = "INSERT INTO `ecc_characters` (`accountID`, `faction`, `status`, `psychic`, `ICC_number`)
      VALUES (
        '" . (int)$jid . "',
        '" . mysqli_real_escape_string($UPLINK, $_POST['newchar']) . "',
        'in design',
        '" . mysqli_real_escape_string($UPLINK, $psyCharacter) . "',
        '" . mysqli_real_escape_string($UPLINK, $ICCID) . "'
      );";
    $res = $UPLINK->query($sql) or trigger_error(mysqli_error($UPLINK));

    // after creating a character, check if this is the only character bound to this account.
    $sql2 = "SELECT `characterID` FROM `ecc_characters` WHERE `accountID` = $jid";
    $res2 = $UPLINK->query($sql2) or trigger_error(mysqli_error($UPLINK));
    // redirect to SET_ACTIVE if 1 character exists.
    if (mysqli_num_rows($res2) == 1) {
        $character = mysqli_fetch_assoc($res2);
        header("location: {$APP['header']}/index.php?activate={$character['characterID']}&firstCharacter=true");
        exit();
    }

    header("location: {$APP['header']}/index.php");
    exit();
}
