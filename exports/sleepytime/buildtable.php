<?php
require './functions.php';
$UPLINK->set_charset("utf8mb4");

$sleepers = array(); //Setup empty sleepers array

// First TSQL Statement is for Spelers information
// $spelers = <<<SQL
//     SELECT r.id, (SELECT character_name from ecc_characters WHERE ecc_characters.characterID = substring_index(v1.field_value, ' - ', -1)) as name, 
//     v2.field_value as building, v3.field_value as bastion_room, v4.field_value as tweede_room,
//     food_loc.field_value as food_loc from joomla.jml_eb_registrants r
//     join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)  /*Character Name */
//     join joomla.jml_eb_field_values v2 ON (v2.registrant_id = r.id AND v2.field_id = 36) /* Building */
//     join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14) /* Soort inschrijving */
//     left join joomla.jml_eb_field_values med ON (med.registrant_id = r.id AND med.field_id = 93) /* MedSleepSpele */
//     left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37) /* BastionSlaapkamer */
//     left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38) /*TweedeGebouwSlaapKamers*/
//     left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
//     where v5.field_value = 'Speler' AND r.event_id = $EVENTID
//     AND $notCancelled AND (med.field_value LIKE 'No%' OR med.field_value IS NULL);
//     SQL;
// $res_spelers = $UPLINK->query($spelers);
// $sleepers = array_merge($sleepers, buildSleeperRow($res_spelers));

/* This TSQL Statement Grabs Figuranten and SLs */
// $figus_sls = <<<SQL
//     select r.id, CONCAT(v5.field_value,' ',r.first_name, ' ', COALESCE(v6.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.') as name, 
//     'tweede gebouw' as building, NULL as bastion_room, 
//     coalesce(substring_index(substring_index(medicsleep.field_value,',',-1), ' - ', 1),CONCAT(COALESCE(v4.field_value,''),COALESCE(v3.field_value,''),COALESCE(v8.field_value,''))) as tweede_room, 
//     food_loc.field_value as food_loc
//     from joomla.jml_eb_registrants r
//     left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 73)
//     left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 72)
//     left join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
//     left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 16)
//     left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 59)
//     left join joomla.jml_eb_field_values v8 on (v8.registrant_id = r.id and v8.field_id = 38)
//     left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
//     left join joomla.jml_eb_field_values med_room on (med_room.registrant_id = r.id and med_room.field_id = 71)
//     left join joomla.jml_eb_field_values medicsleep on (medicsleep.registrant_id = r.id and medicsleep.field_id = 71)
//     where r.event_id = $EVENTID and (v5.field_value = 'Figurant' or v5.field_value = 'Spelleider') and  (med_room.field_value IS NULL) 
//     and $notCancelled;
//     SQL;
// $res_figus_sls = $UPLINK->query($figus_sls);
// $sleepers = array_merge($sleepers, buildSleeperRow($res_figus_sls));

// $med_sleepers = <<<SQL
//     -- This TSQL Statement grabs data for medical sleepers in the Bastion
//     SELECT r.id, COALESCE(
//     (SELECT character_name from ecc_characters WHERE ecc_characters.characterID = substring_index(v1.field_value, ' - ', -1)),
//     CONCAT(reg_type.field_value,' ',r.first_name, ' ', COALESCE(tuv.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.')) as name, 
//     LEFT(med_room.field_value,LOCATE(',',med_room.field_value) - 1) as building, 
//     trim(substring_index(LEFT(med_room.field_value,LOCATE(' - ',med_room.field_value) - 1),',',-1)) as bastion_room, 
//     NULL as tweede_room,
//     food_loc.field_value as food_loc
//     from joomla.jml_eb_registrants r
//     left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
//     left join joomla.jml_eb_field_values reg_type on (reg_type.registrant_id = r.id and reg_type.field_id = 14)
//     left join joomla.jml_eb_field_values tuv on (tuv.registrant_id = r.id and tuv.field_id = 16)
//     left join joomla.jml_eb_field_values med_room on (med_room.registrant_id = r.id and med_room.field_id = 71)
//     left join joomla.jml_eb_field_values med_speler on (med_speler.registrant_id = r.id AND med_speler.field_id = 60)
//     left join joomla.jml_eb_field_values med_figu on (med_figu.registrant_id = r.id AND med_figu.field_id = 93)
//     left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
//     where med_room.field_value LIKE 'Bastion%' AND r.event_id = $EVENTID
//     and $notCancelled
//     UNION
//     -- This TSQL Statement grabs data for medical sleepers in the tweede gebouw
//     SELECT r.id, COALESCE(
//     (SELECT character_name from ecc_characters WHERE ecc_characters.characterID = substring_index(v1.field_value, ' - ', -1)),
//     CONCAT(reg_type.field_value,' ',r.first_name, ' ', COALESCE(tuv.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.')) as name, 
//     LEFT(med_room.field_value,LOCATE(',',med_room.field_value) - 1) as building, NULL as bastion_room,
//     trim(substring_index(LEFT(med_room.field_value,LOCATE(' - ',med_room.field_value) - 1),',',-1)) as tweede_room,
//     food_loc.field_value as food_loc
//     from joomla.jml_eb_registrants r
//     left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
//     left join joomla.jml_eb_field_values reg_type on (reg_type.registrant_id = r.id and reg_type.field_id = 14)
//     left join joomla.jml_eb_field_values tuv on (tuv.registrant_id = r.id and tuv.field_id = 16)
//     left join joomla.jml_eb_field_values med_room on (med_room.registrant_id = r.id and med_room.field_id = 71)
//     left join joomla.jml_eb_field_values med_speler on (med_speler.registrant_id = r.id AND med_speler.field_id = 60)
//     left join joomla.jml_eb_field_values med_figu on (med_figu.registrant_id = r.id AND med_figu.field_id = 93)
//     left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
//     where med_room.field_value LIKE 'tweede gebouw%' AND r.event_id = $EVENTID
//     and $notCancelled;
//     SQL;
// $res_med_sleepers = $UPLINK->query($med_sleepers);
// $sleepers = array_merge($sleepers, buildSleeperRow($res_med_sleepers));

$all_sleepers = <<<SQL
SELECT r.id, (SELECT character_name from ecc_characters WHERE ecc_characters.characterID = substring_index(v1.field_value, ' - ', -1)) as name, 
    v2.field_value as building, v3.field_value as bastion_room, v4.field_value as tweede_room,
    food_loc.field_value as food_loc from joomla.jml_eb_registrants r
    join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)  /*Character Name */
    join joomla.jml_eb_field_values v2 ON (v2.registrant_id = r.id AND v2.field_id = 36) /* Building */
    join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14) /* Soort inschrijving */
    left join joomla.jml_eb_field_values med ON (med.registrant_id = r.id AND med.field_id = 93) /* MedSleepSpele */
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 37) /* BastionSlaapkamer */
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 38) /*TweedeGebouwSlaapKamers*/
    left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
    where v5.field_value = 'Speler' AND r.event_id = $EVENTID
	 AND $notCancelled
	AND (med.field_value LIKE 'No%' OR med.field_value IS NULL)
	UNION
	 select r.id, CONCAT(v5.field_value,' ',r.first_name, ' ', COALESCE(v6.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.') as name, 
    'tweede gebouw' as building, NULL as bastion_room, 
    coalesce(substring_index(substring_index(medicsleep.field_value,',',-1), ' - ', 1),CONCAT(COALESCE(v4.field_value,''),COALESCE(v3.field_value,''),COALESCE(v8.field_value,''))) as tweede_room, 
    food_loc.field_value as food_loc
    from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v3 on (v3.registrant_id = r.id and v3.field_id = 73)
    left join joomla.jml_eb_field_values v4 on (v4.registrant_id = r.id and v4.field_id = 72)
    left join joomla.jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
    left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 16)
    left join joomla.jml_eb_field_values v7 on (v7.registrant_id = r.id and v7.field_id = 59)
    left join joomla.jml_eb_field_values v8 on (v8.registrant_id = r.id and v8.field_id = 38)
    left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
    left join joomla.jml_eb_field_values med_room on (med_room.registrant_id = r.id and med_room.field_id = 71)
    left join joomla.jml_eb_field_values medicsleep on (medicsleep.registrant_id = r.id and medicsleep.field_id = 71)
    where r.event_id = $EVENTID and (v5.field_value = 'Figurant' or v5.field_value = 'Spelleider') and  (med_room.field_value IS NULL) 
    AND $notCancelled
	 UNION
	  SELECT r.id, COALESCE(
    (SELECT character_name from ecc_characters WHERE ecc_characters.characterID = substring_index(v1.field_value, ' - ', -1)),
    CONCAT(reg_type.field_value,' ',r.first_name, ' ', COALESCE(tuv.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.')) as name, 
    LEFT(med_room.field_value,LOCATE(',',med_room.field_value) - 1) as building, 
    trim(substring_index(LEFT(med_room.field_value,LOCATE(' - ',med_room.field_value) - 1),',',-1)) as bastion_room, 
    NULL as tweede_room,
    food_loc.field_value as food_loc
    from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
    left join joomla.jml_eb_field_values reg_type on (reg_type.registrant_id = r.id and reg_type.field_id = 14)
    left join joomla.jml_eb_field_values tuv on (tuv.registrant_id = r.id and tuv.field_id = 16)
    left join joomla.jml_eb_field_values med_room on (med_room.registrant_id = r.id and med_room.field_id = 71)
    left join joomla.jml_eb_field_values med_speler on (med_speler.registrant_id = r.id AND med_speler.field_id = 60)
    left join joomla.jml_eb_field_values med_figu on (med_figu.registrant_id = r.id AND med_figu.field_id = 93)
    left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
    where med_room.field_value LIKE 'Bastion%' AND r.event_id = $EVENTID
	 AND $notCancelled
	 UNION
    -- This TSQL Statement grabs data for medical sleepers in the tweede gebouw
    SELECT r.id, COALESCE(
    (SELECT character_name from ecc_characters WHERE ecc_characters.characterID = substring_index(v1.field_value, ' - ', -1)),
    CONCAT(reg_type.field_value,' ',r.first_name, ' ', COALESCE(tuv.field_value,''),' ', SUBSTRING(r.last_name,1,1),'.')) as name, 
    LEFT(med_room.field_value,LOCATE(',',med_room.field_value) - 1) as building, NULL as bastion_room,
    trim(substring_index(LEFT(med_room.field_value,LOCATE(' - ',med_room.field_value) - 1),',',-1)) as tweede_room,
    food_loc.field_value as food_loc
    from joomla.jml_eb_registrants r
    left join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
    left join joomla.jml_eb_field_values reg_type on (reg_type.registrant_id = r.id and reg_type.field_id = 14)
    left join joomla.jml_eb_field_values tuv on (tuv.registrant_id = r.id and tuv.field_id = 16)
    left join joomla.jml_eb_field_values med_room on (med_room.registrant_id = r.id and med_room.field_id = 71)
    left join joomla.jml_eb_field_values med_speler on (med_speler.registrant_id = r.id AND med_speler.field_id = 60)
    left join joomla.jml_eb_field_values med_figu on (med_figu.registrant_id = r.id AND med_figu.field_id = 93)
    left join joomla.jml_eb_field_values food_loc on (food_loc.registrant_id = r.id and food_loc.field_id = 58)
    where med_room.field_value LIKE 'tweede gebouw%' AND r.event_id = $EVENTID
    AND $notCancelled
	ORDER BY building, bastion_room, tweede_room + 0, name
SQL;
$res_all_sleepers = $UPLINK->query($all_sleepers);
$sleepers = array_merge($sleepers, buildSleeperRow($res_all_sleepers));


// Final sort and display
array_multisort(array_column($sleepers, 'Building'), SORT_ASC, array_column($sleepers, 'Room'),  SORT_ASC, array_column($sleepers, 'Name'), SORT_ASC, $sleepers);
