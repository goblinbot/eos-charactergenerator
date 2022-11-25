<!doctype html>
<html lang="en">

<head>
    <title>Room Signs</title>
    <link rel="stylesheet" href="css/room-sign.css">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:400,500,700,900" rel="stylesheet">

</head>

<body>
    <div>
        <?php
        header("Content-Type: text/html; charset=ISO-8859-1");
        include_once($_SERVER["DOCUMENT_ROOT"] . '/eoschargen/db.php');

        $bldg_sql = "select field_value from `jml_eb_field_values` where field_id = 36 AND field_value !='medische uitzondering \"Geregeld met Orga\"' GROUP by field_value";
        $bldg_res = $UPLINK->query($bldg_sql);
        //$row = mysqli_fetch_assoc($res);

        while ($bldg_row = mysqli_fetch_assoc($bldg_res)) {
            $building = $bldg_row['field_value'];
            //This makes the list of rooms
            $room_sql = "select CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 93)
    left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 94)
    left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    where v2.field_value ='$building' AND v5.field_value = 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline')) AND (v6.field_value = 'No' OR v6.field_value IS NULL) AND (v7.field_value = 'No' OR v7.field_value IS NULL)
    UNION DISTINCT
    select CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,''),coalesce(v6.field_value,''),coalesce(v7.field_value,'')) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 93)
    left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 72)
    left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 73)
    where 'Bastion' = '$building' AND 
    ASCII(UPPER(LEFT(CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,''),coalesce(v6.field_value,''),coalesce(v7.field_value,'')),1))) 
    BETWEEN 64 AND 90 AND v5.field_value != 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline'))
    UNION DISTINCT
    select CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,''),coalesce(v6.field_value,''),coalesce(v7.field_value,'')) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
    left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 72)
    left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 73)
    where 'tweede gebouw' = '$building' AND 
    ASCII(UPPER(LEFT(CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,''),coalesce(v6.field_value,''),coalesce(v7.field_value,'')),1))) 
    NOT BETWEEN 64 AND 90 AND v5.field_value != 'Speler' AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline'))
    UNION DISTINCT
    select trim(substring_index(LEFT(v6.field_value,LOCATE(' - ',v6.field_value) - 1),',',-1)) as room from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 71)
    where LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) = '$building' AND r.event_id = $EVENTID
    and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
    (r.published in (0,1) AND r.payment_method = 'os_offline'))
    GROUP by room ORDER by room;";
            $room_res = $UPLINK->query($room_sql);

            while ($room_row = mysqli_fetch_assoc($room_res)) {
                $room = $room_row['room'];
                $sql = "select r.id, v6.field_value as foodlocation, SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',1),' - ',-1) as name, 
                v2.field_value as building, CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) as room from joomla.jml_eb_registrants r
                        left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
                        left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
                        left join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
                        left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
                        left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
                        left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 58)
                        left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 71)
                    where CONCAT(coalesce(v3.field_value,''),coalesce(v4.field_value,'')) = '$room' AND v2.field_value = '$building' 
                    AND v5.field_value = 'Speler' AND v7.field_value is NULL AND r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
                    (r.published in (0,1) AND r.payment_method = 'os_offline'))AND v2.field_value NOT LIKE 'medische%'

                UNION
                
                SELECT r.id, v6.field_value as foodlocation, CONCAT(v5.field_value,' ',r.first_name, ' ', 
                COALESCE(v2.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.') as name, 'tweede gebouw' as building, CONCAT(COALESCE(v4.field_value,''),
                COALESCE(v3.field_value,'')) as room from joomla.jml_eb_registrants r
                    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 16)
                    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 73)
                    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 72)
                    left join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
                    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 58)
                where v5.field_value != 'Speler' AND ASCII(UPPER(LEFT(CONCAT(COALESCE(v4.field_value,''), COALESCE(v3.field_value,'')),1))) 
                NOT BETWEEN 64 AND 90 AND 'tweede gebouw' =  '$building' AND r.event_id = $EVENTID and (v3.field_value = '$room' or v4.field_value = '$room') AND
                ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR  (r.published in (0,1) AND r.payment_method = 'os_offline'))
    
                UNION
    
                SELECT r.id, v6.field_value as foodlocation, CONCAT(v5.field_value,' ',r.first_name, ' ', COALESCE(v2.field_value,''),' ', 
                SUBSTRING(r.last_name,1,1),'.') as name, 'Bastion' as building, CONCAT(COALESCE(v4.field_value,''),COALESCE(v3.field_value,'')) as room 
                from joomla.jml_eb_registrants r
                    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 16)
                    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 73)
                    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 72)
                    left join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
                    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 58)
                where v5.field_value != 'Speler' AND ASCII(UPPER(LEFT(CONCAT(COALESCE(v4.field_value,''),COALESCE(v3.field_value,'')),1))) 
                BETWEEN 64 AND 90 AND 'Bastion' = '$building' AND r.event_id = $EVENTID and (v3.field_value = '$room' or v4.field_value = '$room') AND
                ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR  (r.published in (0,1) AND r.payment_method = 'os_offline'))
    
                UNION 

                select r.id, v7.field_value as foodlocation, if(v5.field_value = 'Speler', trim(SUBSTRING_INDEX(v1.field_value,' - ',1)),CONCAT(v5.field_value,' ',r.first_name, ' ', COALESCE(v2.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.')) as name,
                LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) as building, substring_index(LEFT(v6.field_value,LOCATE(' - ',v6.field_value) - 1),',',-1) as room 
                from joomla.jml_eb_registrants r
                    left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
                    left join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 16)
                    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37)
                    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38)
                    left join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
                    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 71)
                    left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 58)
                where LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) = '$building' AND trim(substring_index(LEFT(v6.field_value,LOCATE(' - ',v6.field_value) - 1),',',-1)) = '$room' AND r.event_id = $EVENTID
                and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
                (r.published in (0,1) AND r.payment_method = 'os_offline'))
                ORDER by building, room, name;";
                
                $res = $UPLINK->query($sql);
                echo "<div class='roomsign' style=''>";
                echo '<p><button class="button" id="printPageButton" style="width: 100%;" onClick="window.print();">Print</button></p>';
                echo "<center class='center'><font face='Orbitron' size=15><br>" . str_replace('tweede gebouw', 'Zonnedauw', $building) . "<br>$room<br><br></font></center>";
                echo "<table>";
                echo "<th><center>Name</center></th>
                <th><center>Eating Location</center></th>
                ";
                while ($row = mysqli_fetch_array($res)) {
                    $foodlocation = $row['foodlocation'];
                    if ($foodlocation == '') {
                        $foodlocation = $building;
                    } else {
                        if ($foodlocation = 'tweede gebouw') {
                            $foodlocation = 'Zonnedauw';
                        } else {
                        $foodlocation = $row['foodlocation'];
                        }
                    }
                    echo "<tr><td>" . $row['name'] . "</td>";
                    echo "<td><center>" . $foodlocation . "</center></td></tr>";
                }
                echo "</table>";
                echo "</div>";
            }
        }
        ?>

    </div>
</body>

</html>