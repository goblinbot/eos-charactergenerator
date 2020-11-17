<?php


function ar_getEventIDs()
{
  global $_CONFIG, $UPLINK;

  $EVENTIDSarray = array();
  $EVENTID = '8';
  $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as id from jml_eb_registrants r
    join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
    where r.event_id = $EVENTID and ((r.published = 1 AND (r.payment_method = 'os_ideal' or r.payment_method = 'os_paypal')) OR (r.published in (0,1) AND r.payment_method = 'os_offline'));";
  $result = $UPLINK->query($sql);
  $EVENTIDSarray = $result;
  return $EVENTIDSarray;
};
