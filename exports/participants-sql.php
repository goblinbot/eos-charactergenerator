<?php
$tableSort = $_GET['sort'] ?? 'register_date desc';
$selected_event = $_GET['selected_event'] ?? $EVENTID;
$email = $_GET['email'] ?? '%%';

#Get List of all events
$sql_all_events = "SELECT e.id, e.title FROM jml_eb_events e
LEFT JOIN joomla.jml_eb_event_categories cats ON (cats.event_id = e.id)
WHERE cats.category_id = 1 AND e.id <= $EVENTID
ORDER By event_date;";
$res_all_events = $UPLINK->query($sql_all_events);

#Get title of selected event
$sql2 = "SELECT title FROM jml_eb_events where id = $selected_event;";
$res2 = $UPLINK->query($sql2);
$row2 = mysqli_fetch_array($res2);

#Get all participants
$sql = "SELECT r.id as id, r.first_name as oc_fn, r.register_date, r.email as email, tussenvoegsel.field_value as oc_tv,
  r.last_name as oc_ln, faction.character_name as ic_name, soort_inschrijving.field_value as type, faction.faction as faction, 
  foto.field_value as foto, 
  coalesce(SUBSTRING_INDEX(bastion.field_value, ' ', 1 ), SUBSTRING_INDEX(fob.field_value, ' ', 1 ), SUBSTRING_INDEX(substring_index(substring_index(medSlaap.field_value,',',-1), ' - ', 1), ' ', 1 )) as room
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values charname on (charname.registrant_id = r.id and charname.field_id = 21 )
  left join joomla.ecc_characters faction ON (faction.characterID = substring_index(charname.field_value,' - ',-1))
  left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
  left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
  left join joomla.jml_eb_field_values foto on (foto.registrant_id = r.id and foto.field_id = 105)
  left join joomla.jml_eb_field_values bastion on (bastion.registrant_id = r.id and bastion.field_id = 37) /* BastionSlaapkamer */
  left join joomla.jml_eb_field_values fob on (fob.registrant_id = r.id and fob.field_id = 38) /*TweedeGebouwSlaapKamers*/
  left join joomla.jml_eb_field_values medSlaap on (medSlaap.registrant_id = r.id and medSlaap.field_id = 71) /* Medical Sleepers */
  where soort_inschrijving.field_value = 'Speler' AND r.event_id = $selected_event and $notCancelled
  UNION
  select r.id as id, r.first_name as oc_fn, r.register_date, r.email as email, tussenvoegsel.field_value as oc_tv,
  r.last_name as oc_ln, NULL as ic_name, soort_inschrijving.field_value as type, NULL as faction, foto.field_value as foto,
  coalesce(slSlaap.field_value, figuSlaap.field_value, fob.field_value, SUBSTRING_INDEX(trim(substring_index(substring_index(medSlaap.field_value,',',-1), ' - ', 1)),' ', 1 )) AS room
  from joomla.jml_eb_registrants r
  left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
  left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
  left join joomla.jml_eb_field_values foto on (foto.registrant_id = r.id and foto.field_id = 105)
  left join joomla.jml_eb_field_values slSlaap on (slSlaap.registrant_id = r.id and slSlaap.field_id = 73)
  left join joomla.jml_eb_field_values figuSlaap on (figuSlaap.registrant_id = r.id and figuSlaap.field_id = 72)
  left join joomla.jml_eb_field_values fob on (fob.registrant_id = r.id and fob.field_id = 38)
  left join joomla.jml_eb_field_values medSlaap on (medSlaap.registrant_id = r.id and medSlaap.field_id = 71) /* Medical Sleepers */
  WHERE soort_inschrijving.field_value != 'Speler' AND r.event_id = $selected_event and $notCancelled 
  ORDER BY $tableSort";
$res = $UPLINK->query($sql);
$row_count = mysqli_num_rows($res);

#Get count of registrant types
$sql3 = "SELECT COUNT(r.id) as count, soort_inschrijving.field_value as type
from joomla.jml_eb_registrants r       
left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
where  soort_inschrijving.field_value IS NOT NULL AND r.event_id = $selected_event  and $notCancelled
GROUP BY soort_inschrijving.field_value";
$res3 = $UPLINK->query($sql3);

#Get the e-mail addressess
$sql4 = "SELECT r.email as email from joomla.jml_eb_registrants r
        left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
        where soort_inschrijving.field_value LIKE '$email' AND r.event_id = $selected_event and $notCancelled";
$res4 = $UPLINK->query($sql4);

#Get count of factions
$sql5 = "SELECT faction.faction as faction, COUNT(*) as count
from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values charname on (charname.registrant_id = r.id and charname.field_id = 21 )
join joomla.ecc_characters faction ON (faction.characterID = substring_index(charname.field_value,' - ',-1))
left join joomla.jml_eb_field_values tussenvoegsel on (tussenvoegsel.registrant_id = r.id and tussenvoegsel.field_id = 16)
left join joomla.jml_eb_field_values soort_inschrijving on (soort_inschrijving.registrant_id = r.id and soort_inschrijving.field_id = 14)
where soort_inschrijving.field_value = 'Speler' AND r.event_id = $selected_event and $notCancelled GROUP by faction ORDER by faction.faction ASC";
$res5 = $UPLINK->query($sql5);

#Get amount of € pending payments for current event
$sql_pending = 'SELECT (SUM(payment_amount) - SUM(discount_amount)) as amount FROM jml_eb_registrants WHERE payment_method="os_offline" AND published=0 AND event_id = ' . $selected_event . ';';
$res_pending = $UPLINK->query($sql_pending);
$pending = mysqli_fetch_array($res_pending);

#Get amount of € pending payments for previous events
$sql_pending_old = 'SELECT (SUM(payment_amount) - SUM(discount_amount)) as amount FROM jml_eb_registrants WHERE payment_method="os_offline" AND published=0 AND event_id <> ' . $selected_event;
$res_pending_old = $UPLINK->query($sql_pending_old);
$pending_old = mysqli_fetch_array($res_pending_old);

#Calculate sponsor tickets used on selected event
## First count the number of registrants who have used sponsor tickets this event
$sql_sponsor = "SELECT COUNT(r.id) as count from jml_eb_registrants r
    join jml_eb_field_values v3 ON (v3.registrant_id = r.id AND v3.field_id = 103)
    WHERE v3.field_value = 'Yes' AND r.event_id = $selected_event AND $notCancelled";
$res_sponsor = $UPLINK->query($sql_sponsor);
$sponsor = mysqli_fetch_array($res_sponsor);

##Tally up the sponsor tickets purchased
$total_sponsor_tickets_purchased = "SELECT SUM(total_amount) from jml_eb_registrants r
          WHERE r.event_id = 24 AND $notCancelled";
###Sponsor tickets on F17 only cost €15, and were only good for €15 discounts, so we deduct 15 times the number of tickets used
$fifteen_sponsor_tickets_used = "SELECT COUNT(r.id) * 15.00 as count from jml_eb_registrants r
          join jml_eb_field_values v3 ON (v3.registrant_id = r.id AND v3.field_id = 103)
          WHERE v3.field_value = 'Yes' AND r.event_id = 23 AND $notCancelled";
###Sponsor tickets on F18, F19, F20 and F21 were worth €20, so we deduct €20 times the number of tickets used
$twenty_sponsor_tickets_used = "SELECT COUNT(r.id) * 20.00 as count from jml_eb_registrants r
          join jml_eb_field_values v3 ON (v3.registrant_id = r.id AND v3.field_id = 103)
          WHERE v3.field_value = 'Yes' AND (r.event_id > 23 AND r.event_id < 29) AND $notCancelled";
$thirty_euro_sponsor_tickets_used = "SELECT COUNT(r.id) * 30.00 as count from jml_eb_registrants r
          join jml_eb_field_values v3 ON (v3.registrant_id = r.id AND v3.field_id = 103)
          WHERE v3.field_value = 'Yes' AND r.event_id > 28 AND $notCancelled";
###Now we deduct the number of used tickets determined using the last two queries from the total amount spent
$sql_sponsor_tickets_remain = "SELECT (($total_sponsor_tickets_purchased) - ($fifteen_sponsor_tickets_used) - ($twenty_sponsor_tickets_used) - ($thirty_euro_sponsor_tickets_used))/30 as tickets_remaining";
$res_sponsor_tickets_remain = $UPLINK->query($sql_sponsor_tickets_remain);
$remaining_tickets = mysqli_fetch_array($res_sponsor_tickets_remain);
$sql_donations = "SELECT sum(v3.field_value) AS total_donations from jml_eb_registrants r
              join jml_eb_field_values v3 ON (v3.registrant_id = r.id AND v3.field_id = 102)
				      WHERE  r.event_id = $selected_event AND $notCancelled;";
$donations = mysqli_fetch_array($UPLINK->query($sql_donations));

