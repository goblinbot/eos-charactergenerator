<?php


function ar_getEventIDs()
{
    global $_CONFIG, $UPLINK;

    $EVENTIDSarray = array();
    $EVENTID = '8';
    $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(v1.field_value,' - ',2),' - ',-1) as id, v2.field_value as building from jml_eb_registrants r
    join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)

    where r.event_id = $EVENTID and v5.field_value = 'speler' and v2.field_value NOT LIKE 'medische%' AND ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR (r.published in (0,1) AND r.payment_method = 'os_offline'))
    UNION
/*
This TSQL Statement grabs data for medical sleepers 
*/
select r.id, LEFT(v6.field_value,LOCATE(',',v6.field_value) - 1) as building  from joomla.jml_eb_registrants r
join joomla.jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 36)
join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
left join joomla.jml_eb_field_values v6 on (v6.registrant_id = r.id and v6.field_id = 71)
where r.event_id = $EVENTID and v5.field_value = 'speler' and v2.field_value LIKE 'medische%' and ((r.published = 1 AND (r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal' OR r.payment_method = 'os_bancontact')) OR
(r.published in (0,1) AND r.payment_method = 'os_offline'));";
    $result = $UPLINK->query($sql);
    $EVENTIDSarray = $result;
    return $EVENTIDSarray;
};

