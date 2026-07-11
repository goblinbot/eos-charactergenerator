<?php
mysqli_set_charset($UPLINK, 'utf8');
function get_player_cap_events()
{
  $stmt = db::$conn->prepare("SELECT id from jml_eb_events 
  WHERE title LIKE 'Frontier %' AND event_end_date < CURDATE()
  ORDER BY event_date DESC
  LIMIT 3");
  $stmt->execute(); // execute the prepared query
  $line = implode(',', $stmt->fetchAll(PDO::FETCH_COLUMN));
  return $line;
}

function player_cap_count_from()
{
  global $UPLINK;
  $sql = "SELECT min(res.id) as id FROM (SELECT id from jml_eb_events 
  WHERE title LIKE 'Frontier %' AND event_end_date < CURDATE()
  ORDER BY event_date DESC
  LIMIT 3) res";
  $res = $UPLINK->query($sql);
  while ($row = mysqli_fetch_row($res)) {
    $sql2 = "SELECT title from jml_eb_events WHERE id = $row[0];";
    $res2 = $UPLINK->query($sql2);
    while ($row2 = mysqli_fetch_row($res2)) {
      return $row2[0];
    }
  }
}

function get_active_factions()
{
  $notCancelled = "((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR (r.published in (0,1) AND r.payment_method = 'os_offline') OR (r.published = 1 AND r.payment_method = ''))";
  global $UPLINK;
  $events = get_player_cap_events();
  $sql = "SELECT faction, COUNT(faction) as count FROM ecc_characters
    WHERE sheet_status = 'active' AND characterID IN (
    SELECT DISTINCT substring_index(jml_eb_field_values.field_value,' - ',-1)
    FROM jml_eb_registrants r
    JOIN jml_eb_field_values ON (r.id = jml_eb_field_values.registrant_id AND jml_eb_field_values.field_id='21')
    WHERE $notCancelled AND r.event_id IN ($events) 
  )
  GROUP BY faction ORDER BY faction ASC;";
  $res = $UPLINK->query($sql);
  return $res;
}

function get_active_players($faction)
{
  $notCancelled = "((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR (r.published in (0,1) AND r.payment_method = 'os_offline') OR (r.published = 1 AND r.payment_method = ''))";
  global $UPLINK;
  $events = get_player_cap_events();
  $sql = "SELECT characterID, character_name, faction FROM ecc_characters 
  WHERE sheet_status = 'active' AND faction = '$faction' AND characterID IN (
  SELECT DISTINCT substring_index(jml_eb_field_values.field_value,' - ',-1) 
  FROM jml_eb_registrants r
  JOIN jml_eb_field_values ON (r.id = jml_eb_field_values.registrant_id AND jml_eb_field_values.field_id='21')
  WHERE $notCancelled AND r.event_id IN ($events))
  ORDER BY character_name;";
  $res = $UPLINK->query($sql);
  return $res;
}

function get_active_player($id)
{
  global $UPLINK;
  $sql = "SELECT characterID, character_name, faction FROM ecc_characters 
  WHERE characterID =  $id";
  $res = $UPLINK->query($sql);
  return $res;
}

function get_latest_event_player($id)
{
  $notCancelled = "((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR (r.published in (0,1) AND r.payment_method = 'os_offline') OR (r.published = 1 AND r.payment_method = ''))";
  global $UPLINK;
  $events = get_player_cap_events();
  $sql = "SELECT MAX(event_id) AS last_event_id
  FROM jml_eb_registrants r
  JOIN jml_eb_field_values ON (r.id = jml_eb_field_values.registrant_id AND jml_eb_field_values.field_id='21')
  WHERE $notCancelled AND r.event_id IN ($events) AND substring_index(jml_eb_field_values.field_value,' - ',-1) = $id";
  $res = $UPLINK->query($sql);
  $row = mysqli_fetch_assoc($res);
  $last_event = $row['last_event_id'];
  $sql2 = "SELECT id, title FROM jml_eb_events WHERE id = $last_event";
  $res2 = $UPLINK->query($sql2);
  $row2 = mysqli_fetch_assoc($res2);
  return $row2;
}
