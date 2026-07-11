<?php
$tableSort = $_GET['sort'] ?? 'register_date desc';
$selected_event = $_GET['selected_event'] ?? $SPECIALEVENTID;
$email = $_GET['email'] ?? '%%';
// 1. Initialize the list with your starting parent ID
$categories_to_check = [2];
$all_found_ids = [2];

// 2. Loop as long as there are IDs in our "to check" list
while (!empty($categories_to_check)) {
    // Get the next ID to investigate and remove it from the queue
    $current_parent = array_shift($categories_to_check);
    // Prepare the SQL
    $sql_all_events = "SELECT id FROM jml_eb_categories WHERE parent = " . (int)$current_parent;
    // Execute the query
    $result = $UPLINK->query($sql_all_events);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $found_id = $row['id'];
            // Add to our final list of results
            $all_found_ids[] = $found_id;
            // Add to our queue so the loop checks THIS id's children next
            $categories_to_check[] = $found_id;
        }
    }
}
// Final result: $all_found_ids contains every ID in the hierarchy
$id_list = implode(',', array_map('intval', $all_found_ids));
$sql_all_events = "SELECT DISTINCT e.id, e.title FROM jml_eb_events e
LEFT JOIN joomla.jml_eb_event_categories cats ON (cats.event_id = e.id)
WHERE cats.category_id IN ($id_list) AND e.id <= $SPECIALEVENTID
ORDER By event_date;";
$res_all_events = $UPLINK->query($sql_all_events);

#Get title of selected event
$sql2 = "SELECT title FROM jml_eb_events where id = $selected_event;";
$res2 = $UPLINK->query($sql2);
$row2 = mysqli_fetch_array($res2);

#Get all participants
$sql = "SELECT r.id as id, r.first_name as oc_fn, r.register_date, r.email as email, tussenvoegsel.field_value as oc_tv,
  r.last_name as oc_ln, chardb.character_name as ic_name, soort_inschrijving.field_value as type, chardb.faction as faction, 
  foto.field_value as foto
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values charname on (charname.registrant_id = r.id and charname.field_id = 101)
  left join joomla.ecc_characters chardb ON (chardb.characterID = SUBSTRING_INDEX(charname.field_value,' - ',-1))
  left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
  left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 118)
  left join joomla.jml_eb_field_values foto on (foto.registrant_id = r.id and foto.field_id = 105)
  where soort_inschrijving.field_value = 'Speler' AND r.event_id = $selected_event and $notCancelled 
  UNION
  select r.id as id, r.first_name as oc_fn, r.register_date, r.email as email, tussenvoegsel.field_value as oc_tv,
  r.last_name as oc_ln, NULL as ic_name, soort_inschrijving.field_value as type, NULL as faction, foto.field_value as foto
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
  left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 118)
  left join joomla.jml_eb_field_values foto on (foto.registrant_id = r.id and foto.field_id = 105)
  WHERE soort_inschrijving.field_value != 'Speler' AND r.event_id = $selected_event and $notCancelled
  ORDER BY $tableSort";
$res = $UPLINK->query($sql);
$row_count = mysqli_num_rows($res);

#Get count of registrant types
$sql3 = "SELECT COUNT(r.id) as count, soort_inschrijving.field_value as type
from joomla.jml_eb_registrants r       
left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 118)
where  soort_inschrijving.field_value IS NOT NULL AND r.event_id = $selected_event  and $notCancelled
GROUP BY soort_inschrijving.field_value";
$res3 = $UPLINK->query($sql3);

#Get email addresses
$sql4 = "SELECT r.email as email from joomla.jml_eb_registrants r
     left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 118)
     where soort_inschrijving.field_value LIKE '$email' AND r.event_id = $selected_event and $notCancelled";
$res4 = $UPLINK->query($sql4);

#Get count of factions
$sql5 = "SELECT faction.faction as faction, COUNT(*) as count
from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values charname on (charname.registrant_id = r.id and charname.field_id = 101 )
join joomla.ecc_characters faction ON (faction.characterID = substring_index(charname.field_value,' - ',-1))
left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 118)
where soort_inschrijving.field_value = 'Speler' AND r.event_id = $selected_event and $notCancelled GROUP by faction";
$res5 = $UPLINK->query($sql5);

#Get amount of € pending payments for current event
$sql_pending = 'SELECT (SUM(payment_amount) - SUM(discount_amount)) as amount FROM jml_eb_registrants WHERE payment_method="os_offline" AND published=0 AND event_id = ' . $selected_event . ';';
$res_pending = $UPLINK->query($sql_pending);
$pending = mysqli_fetch_array($res_pending);

#Get amount of € pending payments for previous events
$sql_pending_old = 'SELECT (SUM(payment_amount) - SUM(discount_amount)) as amount FROM jml_eb_registrants WHERE payment_method="os_offline" AND published=0 AND event_id <> ' . $selected_event;
$res_pending_old = $UPLINK->query($sql_pending_old);
$pending_old = mysqli_fetch_array($res_pending_old);

$sql_donations = "SELECT sum(v3.field_value) AS total_donations from jml_eb_registrants r
              join jml_eb_field_values v3 ON (v3.registrant_id = r.id AND v3.field_id = 102)
				      WHERE  r.event_id = $selected_event AND $notCancelled;";
$donations = mysqli_fetch_array($UPLINK->query($sql_donations));
