<?php
require_once __DIR__ . "/../../_includes/includes.php";
        
error_reporting(E_ALL);
ini_set('display_errors', 1);
require './buildtable.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Sleepytime</title>
    <link rel="stylesheet" href="../../_includes/css/participants.css">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:400,500,700,900" rel="stylesheet">
</head>

<body>
    <div>
        <?php
        $buildings = GetBuildings($sleepers);
        ?>
        <table>
            <?php
            foreach ($buildings as $building) {
                $building_sleepers = BreakdownByBuilding($sleepers, $building);
                $b_count = count($building_sleepers);
                echo '<td style="vertical-align:top;">';
                echo "<H2>" . str_replace('tweede gebouw', 'Zonnedauw', $building) . " - ($b_count)</H2>";
                $rooms = GetRooms($sleepers, $building);
                foreach ($rooms as $room) {
                    $room_sleepers = BreakdownByRoom($sleepers, $building, $room);
                    $room_array = array();
                    foreach ($room_sleepers as $key => $val) {
                        array_push($room_array, array('Name' => $val['Name']));
                    }
                    $count = count($room_array);
                    echo "<H3>Room $room - ($count) </H3>";
                    arrayToTable($room_array);
                }
                echo "<br>";
                echo "</td>";
            }
            ?>
        </table>
    </div>
</body>

</html>