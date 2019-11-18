<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Room Signs</title>
    <link rel="stylesheet" href="css/room-sign.css">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:400,500,700,900" rel="stylesheet">

</head>
<body>
<div>
<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/eoschargen/db.php');

$bldg_sql = "select field_value from `jml_eb_field_values` where field_id = 36 AND field_value !='medische uitzondering \"Geregeld met Orga\"' GROUP by field_value";
$bldg_res = $UPLINK->query($bldg_sql);
//$row = mysqli_fetch_assoc($res);

while($bldg_row = mysqli_fetch_assoc($bldg_res))
{
    $building = $bldg_row['field_value'];
    $room_sql = "select CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
    left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    where v2.field_value ='$building' AND v5.field_value = 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%'
    UNION
    select CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
    left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    where v2.field_value ='$building' AND v5.field_value != 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%' GROUP by room ORDER by room;";
    $room_res = $UPLINK->query($room_sql);

while($room_row = mysqli_fetch_assoc($room_res)){
    echo '<body background="/eoschargen/img/RoomSign.png">';
    $room = $room_row['room'];
    $sql = "select r.id, SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',1),' - ',-1) as name, v2.field_value as building, CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
    left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    where CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) = '$room' AND v2.field_value = '$building' AND v5.field_value = 'Speler' AND r.event_id = 8 and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%'
    UNION
    select r.id, CONCAT(v5.field_value,' ',r.first_name, ' ', SUBSTRING(r.last_name,1,1),'.') as name, v2.field_value as building, CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
    left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    where CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) = '$room' AND v2.field_value = '$building' AND v5.field_value != 'Speler' AND r.event_id = 8 and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%' ORDER by building, room;";
    $res = $UPLINK->query($sql);
    echo "<div id='heading'>";
    echo "<h1>" . str_replace('tweede gebouw','FOB',$building) . " - $room</h1>";
    echo "</div>";
    echo "<table>";
    while($row = mysqli_fetch_array($res))
    {
        echo "<tr><td>" . $row['name'] . "</td></tr>";
    }
    echo "</table>";
    echo '</body>';
    echo '<p class="single_record"></p>
    <body background="/eoschargen/img/RoomSign.png">';
}
}
?>

</div>
</body>
</html>