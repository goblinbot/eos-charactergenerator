<?php
// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");

if (!isset($_SESSION)) {
    session_start();
}

// 31037 engi 1
// 31082 chem 1
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Temp export</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.min.css">
</head>

<body>

    <?php

    $sql = "SELECT c.character_name, c.faction 
    FROM `ecc_characters` c
    JOIN  `ecc_char_skills` s on (s.charID = c.characterID)
    WHERE s.skill_id = '31037'";
    $res = $UPLINK->query($sql);

    if ($res) {

        echo "<h2>Engineers, at least level 1 (" . mysqli_num_rows($res) . ")</h2>
    <table>";

        if (mysqli_num_rows($res) > 0) {

            echo "<tr>  <th>Name</th><th>Faction</th> </tr>";

            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                <td>" . $row['character_name'] . "</td>
                <td>" . $row['faction'] . "</td>
            </tr>";
            }
        }

        echo "</table>";
    }


    $sql = "SELECT c.character_name, c.faction 
    FROM `ecc_characters` c
    JOIN  `ecc_char_skills` s on (s.charID = c.characterID)
    WHERE s.skill_id = '31082'";
    $res = $UPLINK->query($sql);

    if ($res) {

        echo "<h2>Chemists, at least level 1 (" . mysqli_num_rows($res) . ")</h2>
    <table>";

        if (mysqli_num_rows($res) > 0) {

            echo "<tr>  <th>Name</th><th>Faction</th> </tr>";

            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                <td>" . $row['character_name'] . "</td>
                <td>" . $row['faction'] . "</td>
            </tr>";
            }
        }

        echo "</table>";
    }
    ?>


</body>

</html>

<?php