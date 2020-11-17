<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/eoschargen/db.php');
$id = array($EVENTID);
error_reporting(E_ALL);
ini_set('display_errors', 1);


//class db {
//    public static $conn;
//}

// First TSQL Statement is for Spelers information
$stmt = db::$conn->prepare("select r.id, v1.field_value as name, v2.field_value as building, v3.field_value as bastion_room, v4.field_value as tweede_room from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
where v5.field_value = 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
(r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%'
UNION
/* 
This TSQL Statement Grabs Figuranten (with real bed), SLs and Keuken Crew
*/
select r.id, CONCAT(v5.field_value,' ',r.first_name, ' ', COALESCE(v6.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.') as name, 'tweede gebouw' as building, 
NULL as bastion_room, CONCAT(COALESCE(v4.field_value,''),COALESCE(v3.field_value,''),COALESCE(v8.field_value,'')) as tweede_room from joomla.jml_eb_registrants r
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 73)
left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 72)
left join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 16)
left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 59)
left join joomla.jml_eb_field_values v8 on (v8.registrant_id = r.id and v8.field_id = 38)
where r.event_id = $EVENTID and ((v5.field_value != 'Speler' AND v7.field_value != 'No') or (v5.field_value = 'Keuken Crew' or v5.field_value = 'Spelleider')) and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
(r.published in (0,1) AND r.payment_method = 'os_offline'))
UNION
/*
This TSQL Statement grabs data for medical sleepers in the Bastion
*/
select r.id, v1.field_value as name, LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) as building, 
substring_index(LEFT(v6.field_value,LOCATE(' - ',v6.field_value) - 1),',',-1) as bastion_room, 
v4.field_value as tweede_room from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 71)
where LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) = 'Bastion' AND r.event_id = $EVENTID 
and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
(r.published in (0,1) AND r.payment_method = 'os_offline'))
UNION
/*
This TSQL Statement grabs data for medical sleepers in the tweede gebouw
*/
select r.id, v1.field_value as name, LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) as building, v3.field_value as bastion_room,
substring_index(LEFT(v6.field_value,LOCATE(' - ',v6.field_value) - 1),',',-1) as tweede_room from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 71)
where LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) = 'tweede gebouw' AND r.event_id = $EVENTID
and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
(r.published in (0,1) AND r.payment_method = 'os_offline'))");
$res = $stmt->execute($id);
$aSleepers = $stmt->fetchAll();

$name = array();
$building = array();
$bastion_room = array();
$tweede_room = array();
foreach ($aSleepers as $key => $aSleeper) {
    $building[$key]  = $aSleeper['building'];
    $bastion_room[$key]  = $aSleeper['bastion_room'];
    $tweede_room[$key]  = $aSleeper['tweede_room'];
    $name[$key]  = $aSleeper['name'];
}

array_multisort(
    $building,
    SORT_ASC,
    $bastion_room,
    SORT_ASC,
    $tweede_room,
    SORT_ASC,
    $name,
    SORT_ASC,
    $aSleepers
);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Sleepytime</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:400,500,700,900" rel="stylesheet">
</head>

<body>
    <div>
        <table>
            <thead>
                <td>
                    Name
                </td>
                <td>
                    Building
                </td>
                <td>
                    Room
                </td>
            </thead>
            <?php
            $building = "bastion";
            $room = $aSleepers[0]["bastion_room"];
            foreach ($aSleepers as $aSleeper) {
                $roomsleep = "";
                if (!empty($aSleeper["bastion_room"])) {
                    $roomsleep = $aSleeper["bastion_room"];
                }
                if (!empty($aSleeper["tweede_room"])) {
                    $roomsleep = $aSleeper["tweede_room"];
                }
                $blaat = 0;
                if ($building != $aSleeper["building"]) {
                    echo "<tr><td colspan='3' height='8px; display:block;'> </td></tr>";
                    $blaat = 1;
                }
                if ($blaat != 1) {
                    if ($room != $roomsleep) {
                        echo "<tr><td colspan='3' height='8px; display:block;'> </td></tr>";
                    }
                }
                $blaat = 0;
            ?>
                <tr>
                    <td>
                        <?php
                        $name =  explode(" - ", $aSleeper["name"]);
                        echo $name[0];
                        ?>
                    </td>
                    <td>
                        <?php echo $aSleeper["building"]; ?>
                    </td>
                    <td>
                        <?php echo $roomsleep; ?>
                    </td>
                </tr>

            <?php

                $building = $aSleeper["building"];

                $room = $roomsleep;
            }
            ?>
            </thead>
        </table>
    </div>
</body>

</html>