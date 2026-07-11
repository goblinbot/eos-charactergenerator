<?php
        header("Content-Type: text/html; charset=UTF-8");
        require_once __DIR__ . "/../../_includes/includes.php";
        require './buildtable.php';
        ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Room Signs</title>
    <link rel="stylesheet" href="css/room-sign.css">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:400,500,700,900" rel="stylesheet">

</head>

<body>
    <div>

        <?php
        $buildings = GetBuildings($sleepers);
        foreach ($buildings as $building){
            $rooms = GetRooms($sleepers,$building);
            foreach ($rooms as $room){
                echo "<div class='roomsign' style=''>";
                echo '<p><button class="button" id="printPageButton" style="width: 100%;" onClick="window.print();">Print</button></p>';
                echo "<center class='center'><font face='Orbitron' size=15><br>" . str_replace('tweede gebouw', 'Zonnedauw', $building) . "<br>$room<br></font></center>";
                $room_sleepers = BreakdownByRoom($sleepers,$building,$room);
                ?>
                <table>
                    <tr>
                    <th><center>Name</center></th>
                    <th><center>Room Clean Sign-Off</center></th>
                    <?php if (isset($use_food_loc) && $use_food_loc == 'true'){ ?>
                    <th><center>Eating Location</center></th>
                    <?php }
                    echo '</tr>';
                    foreach ($room_sleepers as $sleeper){
                        if (isset($use_food_loc) && $use_food_loc == 'true'){
                            if (isset($sleeper['food_loc'])){
                                $foodlocation = $sleeper['food_loc'];
                            }
                            else {
                                $foodlocation = $building;
                            }
                    }
                    echo "<tr>
                    <td>" . $sleeper['Name'] . "</td>";
                    echo "<td><center>&nbsp;</center></td>";
                    if (isset($use_food_loc) && $use_food_loc == 'true'){
                        echo "<td><center>" . str_replace('tweede gebouw', 'Zonnedauw', $foodlocation) . "</center></td>";
                        }
                    echo "</tr>";
                }
                echo "</table>";
                ?>
                <table>
                    <th>Important Notes:</th>
                    <tr>
                        <td>
                            <ul>
                                <li>Choose 1 person from your room to do the final clean-and-swept check. They should
                                    sign next to their name when the room is clean and ready to be checked.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <h5>Meal Times/Locations</h5>
                                <table>
                                    <tr>
                                        <th>Meal</th>
                                        <th>Location</th>
                                        <th>Time</th>
                                    </tr>
                                    <tr>
                                        <td>Breakfast</td>
                                        <td>Zonnedauw</td>
                                        <td>8:30 - 10:00</td>
                                    </tr>
                                    <tr>
                                        <td>Lunch</td>
                                        <td>Bastion</td>
                                        <td>12:00 - 14:00</td>
                                    </tr>
                                    <tr>
                                        <td>Dinner</td>
                                        <td>Bastion</td>
                                        <td>18:30 - 20:00</td>
                                    </tr>
                                </table>
                        </td>
                    </tr>
                </table>
                <?php
                echo "</div>";
            }
        }
            ?>
                