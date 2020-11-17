<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");

/* no login means NO PLAY. GET OUT. */
if (!isset($jid)) {
  echo "<h1 style=\"font-family: arial;\">[ERR 440]</h1>";
  exit();
}
if (!isset($UPLINK)) {
  echo "<h1 style=\"font-family: arial;\">[ERR 442]</h1>";
  exit();
}

// CREATE IMPLANT FORM
if (isset($_POST['createImplantForm']) && $_POST['createImplantForm'] == true) {

  // validate, then print if valid.
  $AUG = $_POST['createImplantForm'];

  if ($AUG['type'] == 'symbiont' || $AUG['type'] == 'cybernetic' || $AUG['type'] == 'flavour') {

    if (isset($AUG['char']) && $AUG['char'] != "") {

      $AUG['char'] = (int)$AUG['char'];

      $sql = "SELECT characterID FROM `ecc_characters` WHERE characterID = '" . mysqli_real_escape_string($UPLINK, $AUG['char']) . "' AND accountID = '" . mysqli_real_escape_string($UPLINK, (int)$jid) . "' LIMIT 1";
      $res = $UPLINK->query($sql);

      if ($res && mysqli_num_rows($res) == 1) {

        $printresult = "<form name=\"newImplant\">"
          . "<input type=\"hidden\" name=\"newImplant[char]\" value=\"" . $AUG['char'] . "\" />"
          . "<input type=\"hidden\" name=\"newImplant[type]\" value=\"" . $AUG['type'] . "\" />"
          . "<div class=\"formitem\"><label><h2>Augmentation type: " . $AUG['type'] . "</h2></label></div>";

        if ($AUG['type'] == 'cybernetic') {

          $xSQL = "SELECT name, siteindex FROM `ecc_skills_groups` WHERE psychic = 'false' AND parents = 'none' ORDER BY name ASC";
          $xRES = $UPLINK->query($xSQL);
          if ($xRES && mysqli_num_rows($xRES) > 0) {

            $printresult .= "<div class=\"formitem\">"
              . "<label><h3>Skill to emulate:</h3></label>"
              . "<select name=\"newImplant[skillgroup_siteindex]\">";

            while ($row = mysqli_fetch_assoc($xRES)) {
              $printresult .= "<option value=\"" . $row['siteindex'] . "\">" . $row['name'] . "</option>";
            }

            $printresult .= "</select></div>";

            $printresult .= "<div class=\"formitem\"><label><h3>Skill Level:</h3></label>"
              . "<input autocomplete=\"off\" type=\"number\" max=\"5\" min=\"1\" name=\"newImplant[skillgroup_level]\" value=\"1\" />"
              . "</div>";
          }
        } else if ($AUG['type'] == 'symbiont') {

          $xSQL = "SELECT name, siteindex FROM `ecc_skills_groups` WHERE primaryskill_id = '12003' OR primaryskill_id = '12009' ";
          $xRES = $UPLINK->query($xSQL);
          if ($xRES && mysqli_num_rows($xRES) > 0) {

            $printresult .= "<div class=\"formitem\">"
              . "<label><h3>Skill to emulate:</h3></label>"
              . "<select name=\"newImplant[skillgroup_siteindex]\">";

            while ($row = mysqli_fetch_assoc($xRES)) {
              $printresult .= "<option value=\"" . $row['siteindex'] . "\">" . $row['name'] . "</option>";
            }

            $printresult .= "</select></div>";

            $printresult .= "<div class=\"formitem\"><label><h3>Skill Level:</h3></label>"
              . "<input autocomplete=\"off\" type=\"number\" max=\"5\" min=\"1\" name=\"newImplant[skillgroup_level]\" value=\"1\" />"
              . "</div>";
          }
        }

        $printresult .= "<div class=\"formitem\"><label><h3>Description: <em>(max 230)</em></h3></label>"
          . "<textarea name=\"newImplant[description]\" placeholder=\"A name, story, or both about this specific augmentation.\" maxlength=\"230\"></textarea>"
          . "</div>";

        $printresult .= "<div class=\"formitem\">"
          . "<a class=\"button green no-bg\" onclick=\"IM_submitNewImplant(); return false;\"><i class=\"fas fa-save\"></i>&nbsp;Add new augmentation.</a>" . "</form><br/>"
          . "</div>";
      } else {
        echo "[ERR 443]"; // validated account/sheet
        exit();
      }
    } else {
      echo "[ERR 444]"; // check for sheet ID
      exit();
    }
  } else {
    echo "[ERR 445]"; // implant type validation
    exit();
  }

  echo $printresult;
  unset($printresult);
  unset($AUG);
  exit();
}

// edit the amounts of events played
if (isset($_POST['EventsPlayedForm']) && $_POST['EventsPlayedForm'] != "") {

  $printresult = "";
  $xDATA = $_POST['EventsPlayedForm'];

  check4dead($xDATA['char']);

  // grab the existing nickname if it exists
  $sql = "SELECT aantal_events FROM ecc_characters WHERE accountID = '" . mysqli_real_escape_string($UPLINK, $jid) . "' AND characterID = '" . mysqli_real_escape_string($UPLINK, $xDATA['char']) . "' LIMIT 1";
  $res = $UPLINK->query($sql);

  if ($res && mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_assoc($res);
    $row = $row['aantal_events'];
  } else {
    $row = "";
  }

  $printresult .= "<form name=\"\" action=\"" . $APP['header'] . "/index.php?viewChar=" . $xDATA['char'] . "\" method=\"post\">"
    . "<div class=\"formitem\">"
    . "<label>Events played:</label><br/>"
    . "<input autocomplete=\"off\" type=\"number\" name=\"updateEventsPlayed[value]\" value=\"" . $row . "\" min=\"0\" max=\"35\" />"
    . "</div><div class=\"formitem\">"
    . "<input type=\"submit\" class=\"button green no-bg\" value=\"Update\"/>"
    . "</div>"
    . "</form>";

  echo $printresult;
  unset($printresult);
  exit();
}

// EDIT OR DELETE AN IMPLANT
if (isset($_POST['removeImplant']) && $_POST['removeImplant'] != "") {

  $AUG = $_POST['removeImplant'];
  $printresult = false;

  $sql = "SELECT * FROM `ecc_char_implants` WHERE charID = '" . mysqli_real_escape_string($UPLINK, $AUG['char']) . "' AND modifierID = '" . mysqli_real_escape_string($UPLINK, $AUG['aug']) . "'  AND accountID = '" . mysqli_real_escape_string($UPLINK, (int)$jid) . "' LIMIT 1";
  $res = $UPLINK->query($sql) or trigger_error(mysqli_error($res));

  if ($res && mysqli_num_rows($res) == 1) {

    $row = mysqli_fetch_assoc($res);
    $printresult = "<div class=\"dialog\">"
      . "<h3 class=\"text-bold text-center\"><i class=\"fas fa-question\"></i>&nbsp;Removing this augmentation could have some side effects. Do you want to proceed?</h3>"
      . "<button class=\"button bar green no-bg\" onclick=\"IM_removeImplantConfirmed('" . $row['modifierID'] . "'); return false;\">"
      . "<i class=\"fas fa-check\"></i>&nbsp;<strong>Yes,</strong> I wish to regain a bit of my humanity."
      . "</button>"
      . "<br/>"
      . "<button class=\"button bar blue no-bg\" onclick=\"location.reload(); return false;\">"
      . "<i class=\"fas fa-times\"></i>&nbsp;I don't like the sound of that. <strong>Cancel</strong> the operation."
      . "</button>"
      . "</div>";
  } else {
    $printresult = "[ERR 501]";
  }

  echo $printresult;
  unset($printresult);
  exit();
}

if (isset($_POST['deleteImplantConfirm']) && $_POST['deleteImplantConfirm'] != "") {

  $sql = "SELECT * FROM `ecc_char_implants` WHERE modifierID = '" . mysqli_real_escape_string($UPLINK, (int)$_POST['deleteImplantConfirm']) . "' AND accountID = '" . mysqli_real_escape_string($UPLINK, (int)$jid) . "' LIMIT 1";
  $res = $UPLINK->query($sql) or trigger_error(mysqli_error($res));

  if ($res && mysqli_num_rows($res) == 1) {

    $row = mysqli_fetch_assoc($res);

    $sql = "UPDATE `ecc_char_implants`
      SET status = 'removed'
      WHERE modifierID = '" . mysqli_real_escape_string($UPLINK, $row['modifierID']) . "'
      AND accountID = '" . mysqli_real_escape_string($UPLINK, (int)$jid) . "'
      LIMIT 1";
    $update = $UPLINK->query($sql) or trigger_error(mysqli_error($UPLINK));
    echo "<p class=\"dialog\"><i class=\"fas fa-user-times green\"></i>&nbsp;Unplugging... just a moment please.</p>";
  } else {
    echo "[ERR 502]";
  }

  exit();
}


// UPLOAD NEW AUGMENT
if (isset($_POST['newImplant']) && $_POST['newImplant'] == true) {

  $NEWIMP = $_POST['newImplant'];

  $sql = "SELECT characterID FROM `ecc_characters` WHERE characterID = '" . mysqli_real_escape_string($UPLINK, $NEWIMP['char']) . "' AND accountID = '" . mysqli_real_escape_string($UPLINK, (int)$jid) . "' LIMIT 1";
  $res = $UPLINK->query($sql);

  if ($res && mysqli_num_rows($res) == 1) {

    // VALIDATIONS
    $NEWIMP['description'] = EMS_echo($NEWIMP['description']);

    if (!isset($NEWIMP['skillgroup_level']) || (int)$NEWIMP['skillgroup_level'] < 0 || (int)$NEWIMP['skillgroup_level'] > 5) {
      $NEWIMP['skillgroup_level'] = 1;
    }

    foreach ($NEWIMP as $key => $value) {
      $value = EMS_echo($value);
      huizingfilter($key);
      huizingfilter($value);
    }
    // END VALIDATIONS


    if (isset($NEWIMP['type']) && $NEWIMP['type'] == "flavour") {

      $sql = "INSERT INTO `ecc_char_implants`
      (`charID`, `accountID`, `type`, `skillgroup_level`, `skillgroup_siteindex`, `status`, `description`)
      VALUES
      ('" . (int)$NEWIMP['char'] . "', '" . (int)$jid . "', '" . mysqli_real_escape_string($UPLINK, $NEWIMP['type']) . "', '0', 'none', 'active', '" . mysqli_real_escape_string($UPLINK, $NEWIMP['description']) . "')";
      $xRES = $UPLINK->query($sql) or trigger_error(mysqli_error($xRES));

      echo "<p class=\"dialog\"><i class=\"fas fa-check green\"></i>&nbsp;Added new augment. Refreshing...</p>";
    } else if (isset($NEWIMP['type']) && $NEWIMP['type'] == "cybernetic") {

      $sql = "INSERT INTO `ecc_char_implants` (
        `charID`,
        `accountID`,
        `type`,
        `skillgroup_level`,
        `skillgroup_siteindex`,
        `status`,
        `description`
      ) VALUES (
        '" . (int)$NEWIMP['char'] . "',
        '" . (int)$jid . "',
        '" . mysqli_real_escape_string($UPLINK, $NEWIMP['type']) . "',
        '" . (int)$NEWIMP['skillgroup_level'] . "',
        '" . mysqli_real_escape_string($UPLINK, $NEWIMP['skillgroup_siteindex']) . "',
        'active',
        '" . mysqli_real_escape_string($UPLINK, $NEWIMP['description']) . "'
      )";
      $xRES = $UPLINK->query($sql) or trigger_error(mysqli_error($xRES));

      echo "<p class=\"dialog\"><i class=\"fas fa-check green\"></i>&nbsp;Added new augment. Refreshing...</p>";
    } else if (isset($NEWIMP['type']) && $NEWIMP['type'] == "symbiont") {

      $sql = "INSERT INTO `ecc_char_implants` (
        `charID`,
        `accountID`,
        `type`,
        `skillgroup_level`,
        `skillgroup_siteindex`,
        `status`,
        `description`
      ) VALUES (
        '" . (int)$NEWIMP['char'] . "',
        '" . (int)$jid . "',
        '" . mysqli_real_escape_string($UPLINK, $NEWIMP['type']) . "',
        '" . (int)$NEWIMP['skillgroup_level'] . "',
        '" . mysqli_real_escape_string($UPLINK, $NEWIMP['skillgroup_siteindex']) . "',
        'active',
        '" . mysqli_real_escape_string($UPLINK, $NEWIMP['description']) . "'
      )";
      $xRES = $UPLINK->query($sql) or trigger_error(mysqli_error($xRES));

      echo "<p class=\"dialog\"><i class=\"fas fa-check green\"></i>&nbsp;Added new augment. Refreshing...</p>";
    } else {

      echo "<p class=\"dialog\"><i class=\"fas fa-question\"></i>&nbsp;An error has occured. Please try again.. (331)</p>";
      exit();
    }
  } else {

    echo "<p class=\"dialog\"><i class=\"fas fa-question\"></i>&nbsp;An error has occured. Please try again.. (330)</p>";
    exit();
  }

  unset($res);
  unset($xRES);
  exit();
}
