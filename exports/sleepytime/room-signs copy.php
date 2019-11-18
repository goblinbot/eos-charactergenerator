<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/eoschargen/db.php');
$id = array($EVENTID);

error_reporting(E_ALL);
ini_set('display_errors', 1);


//class db {
//    public static $conn;
//}

$sql = "select r.id, v1.field_value as name, v2.field_value as building, v3.field_value as bastion_room, v4.field_value as tweede_room from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
where v2.field_value = 'Bastion' AND v5.field_value = 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
(r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%'
UNION
select r.id, CONCAT(v5.field_value,' ',r.first_name, ' ', SUBSTRING(r.last_name,1,1),'.') as name, v2.field_value as building, v3.field_value as bastion_room, v4.field_value as tweede_room from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
where v2.field_value = 'Bastion' AND v5.field_value != 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
(r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%' ORDER by bastion_room, tweede_room";
$res = $UPLINK->query($sql);
$row = mysqli_fetch_array($res);
$building = "Bastion";
while($row = mysqli_fetch_array($res)) {
    echo $row[0] . "</br>";
    echo $row[1] . "</br>";
}


echo print_r(${$building});
// $building_contents = array();

// while($row = mysqli_fetch_array($res))
// {
//     $room = $row['bastion_room'] . $row['tweede_room'];
//     $name = explode('- ',$row['name']);
//     echo $name[0] . $room . "</br>";
// }
?>
</body>
</html>

