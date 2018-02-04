<?php

// include the CSS based on global config
function EMSincludeCSS() {

  global $APP;
  $printresult = "";

  if(isset($APP["includes"]["css"]) && count($APP["includes"]["css"]) > 0) {
    foreach($APP["includes"]["css"] AS $stylesheetUrl){
      $printresult .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$APP["header"] . $stylesheetUrl."\" />\n";
    }
  } else {
    // ERR:
  }
  return $printresult;
}

// include the JS based on global config
function EMSincludeJS() {

  global $APP;
  $printresult = "";

  if(isset($APP["includes"]["js"]) && count($APP["includes"]["js"]) > 0) {
    foreach($APP["includes"]["js"] AS $javascriptUrl){
      $printresult .= "\t<script type=\"text/javascript\" src=\"". $APP["header"] . $javascriptUrl ."\"></script>\n";
    }
  } else {
    // ERR:
  }
  return $printresult;
}

// show errorpage function
function showErrorPage($message = '451') {
  echo "<html style=\"background:#222; color: #EEE;\"><h1 style=\"color: #EEE;\">".$message."</h1></html>";
  exit();
}


// builds the left menu
function generateMenu($param = 'Home') {

  global $APP;

  $printresult = "";

  $class = (strtolower($param) == 'home') ? 'active' : '';
    $printresult .= "<a href=\"".$APP['header']."/\" class=\"menuitem $class\"><i class=\"fa fa-home\"></i><span>&nbsp;Home</span></a>";

  $class = (strtolower($param) == 'characters') ? 'active' : '';
    $printresult .= "<a href=\"".$APP['header']."/characters.php\" class=\"menuitem $class\"><i class=\"fa fa-user\"></i><span>&nbsp;Character(s)</span></a>";

  $class = (strtolower($param) == 'myaccount') ? 'active' : '';
    $printresult .= "<a href=\"".$APP['header']."/myaccount.php\" class=\"menuitem $class\"><i class=\"fa fa-cog\"></i><span>&nbsp;My account</span></a>";

  $class = 'disabled';
    $printresult .= "<a href=\"/\" class=\"menuitem $class\"><i class=\"fa fa-arrow-left\"></i><span>&nbsp;Back to site</span></a>";

  return $printresult;

}

// large update function to make updating a character's info easier.
function updateCharacterInfo($params = array(), $charID = 0) {
  global $TIJDELIJKEID, $UPLINK;

  // is charID set?
  if(isset($charID) && (int)$charID !== 0) {

    // check if charID belongs to the active account.
    $sql = "SELECT characterID, accountID FROM `ecc_characters` WHERE characterID = '".mysqli_real_escape_string($UPLINK,(int)$charID)."' AND accountID = '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."' LIMIT 1";
    $res = $UPLINK->query($sql);

    if($res && mysqli_num_rows($res) == 1) {

      if(is_array($params) && count($params) > 0) {

        // echo (int)$charID . "<br/>";

        foreach($params as $key => $value){

          $key = sanitize_spaces($key);
          $value = sanitize_spaces($value);
          huizingfilter($key);
          huizingfilter($value);

          $sql = "UPDATE `ecc_characters`
            SET ".$key." = '".mysqli_real_escape_string($UPLINK,$value)."'
            WHERE characterID = '".mysqli_real_escape_string($UPLINK,(int)$charID)."'
            AND accountID = '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."'
            LIMIT 1";
          $update = $UPLINK->query($sql) or trigger_error(mysqli_error($UPLINK));
        }

      } else {
        showErrorPage("Error code 0734");
        return false;
      }
    } else {
      showErrorPage("Error code 0731");
      return false;
    }


  } else {
    return false;
  }

}


// get character sheets
function getCharacterSheets() {
  global $TIJDELIJKEID, $UPLINK;

  $return = array();
  $return['characters'] = array();


  if(isset($UPLINK) && isset($TIJDELIJKEID) && $TIJDELIJKEID != "") {

    $sql = "SELECT * FROM ecc_characters WHERE accountID = '".(int)$TIJDELIJKEID."'";
    $res = $UPLINK->query($sql);

    if($res) {
      if(mysqli_num_rows($res) > 0) {

        while($row = mysqli_fetch_assoc($res)){

          $return['characters'][$row['characterID']] = array();

          foreach($row AS $KEY => $VALUE) {

            $return['characters'][$row['characterID']][$KEY] = EMS_echo($VALUE);

          }//foreach

          if(count($return['characters']) > 0) {

            $return['characters'][$row['characterID']]['sheets'] = array();

            foreach($row AS $KEY => $VALUE) {

              $xSQL = "SELECT * FROM ecc_char_sheet WHERE characterID = '".(int)$return['characters'][$row['characterID']]['characterID']."' ORDER BY versionNumber DESC";
              $xRES = $UPLINK->query($xSQL);

              if(mysqli_num_rows($xRES) > 0) {
                while($xROW = mysqli_fetch_assoc($xRES)){

                  foreach($xROW AS $xKEY => $xVALUE) {
                    $return['characters'][$row['characterID']]['sheets'][$xROW['charSheetID']][$xKEY] = EMS_echo($xVALUE);
                  }
                }

                $xRES->free();
              }
            }//foreach
          }

        }

        $res->free();

        $return['status'] = "ok";

      } else {

        $return['status'] = "noChar";
      }
    } else {

      $return['status'] = "noChar";
    }

  } else {

    $return['status'] = "noDB";
  }

  return $return;
}


// Wash away all unnecessary spaces, by brutishly looping for all them.
function sanitize_spaces($input = null) {

  $spaces = substr_count($input, " ");
  if($spaces > 0) {
    for($i = 0; $i < $spaces; $i++) {
      $input = str_replace("  "," ",$input);
    }
  }

  return $input;
}

// spam / escape filter, named after a friend of mine who taught me the importance of filtering user input.
function huizingfilter($input = null) {

  $triggers    = array('tps:/','tp:/',"src=","src =",'<','>','><','.js',';','$','[',']','(',')','@S','@s','GOTO ','DBCC ');
  $error       = false;

  foreach ($triggers as $trigger) { // loops through the huizing-huizingtriggertriggertrigger
    if (stripos($input,$trigger) !== false) {
      $error = true;
    }
  }

  if($error == true) {
    echo "<h2>Operations interrupted: Some of your input was flagged as malicious.</h2>";
    exit();
  } else {
    return "clear";
  }
}

/* EMS_echo : just a function to echo; However, if the variable you're trying to echo is undefined, it will still return "". */
function EMS_echo(&$var, $else = '') {
  return isset($var) && $var ? $var : $else;
}
