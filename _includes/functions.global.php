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
function updateCharacterInfo($charID) {
  global $TIJDELIJKEID, $UPLINK;

  if(isset($charID) && (int)$charID !== 0) {




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

              $xSQL = "SELECT * FROM ecc_char_sheet WHERE characterID = '".(int)$return['characters'][$row['characterID']]['characterID']."' ORDER BY charSheetID DESC";
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

    }

  } else {

    $return['status'] = "noDB";
  }


  return $return;
}

// spam / escape filter, named after a friend of mine.
function huizingfilter($input = null) {

  $triggers    = array('tps:/','tp:/',"src=","src =",'<','>','><','.js',';','$','[',']','(',')',':');
  $error       = false;

  foreach ($triggers as $trigger) { // loops through the huizing-huizingtriggertriggertrigger
    if (strpos($input,$trigger) !== false) {
      $error = true;
    }
  }

  if($error == true) {
    echo "<h1>Invalid input detected. Operations ended.</h1>";
    exit();
  } else {
    return "clear";
  }
}

/* EMS_echo : just a function to echo; However, if the variable you're trying to echo is undefined, it will still return "". */
function EMS_echo(&$var, $else = '') {
  return isset($var) && $var ? $var : $else;
}
