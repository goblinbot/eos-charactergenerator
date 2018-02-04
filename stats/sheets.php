<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eos-charactergenerator/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");

  include_once($APP["root"] . "/header.php");

  if(!isset($_SESSION)) {
    session_start();
  }

  if(!isset($_GET['viewChar']) || $_GET['viewChar'] == "") {
    echo "<h1>Error 0444</h1>";
    exit();
  }

  if(isset($sheetArr['characters'][$_GET['viewChar']]) && $sheetArr['characters'][$_GET['viewChar']] != "") {
    $activeCharacter = $sheetArr['characters'][$_GET['viewChar']];

    if(count($activeCharacter['sheets']) > 0) {

      foreach($activeCharacter['sheets'] AS $sheetRow) {
        $activeCharacter['sheets'][$sheetRow['charSheetID']] = getFullCharSheet($sheetRow['charSheetID']);
      }

      if(count($activeCharacter['sheets'][$sheetRow['charSheetID']]) > 0) {



      } else {
        $activeCharacter['sheets'][$sheetRow['charSheetID']]['status'] = 'noskill';
      }

    }


  } else {
    echo "<h1>Error 0451</h1>";
    exit();
  }

?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">

    <h1>[CHARACTER NAME] - Skills</h1>

    <hr>

    <?php
      echo "<pre>";
      var_dump($activeCharacter);
      echo "</pre>";

      //INSERT INTO `ecc_char_sheet` (`charSheetID`, `characterID`, `accountID`, `status`, `eventName`, `versionNumber`) VALUES (NULL, '1', '451', 'ontwerp', 'Frontier9', '0');


      if(isset($activeCharacter['sheets'])) {



        if(count($activeCharacter['sheets']) > 0) {



        } else {

          // no sheet yet? No problem. Make the first one.
          $sql = "INSERT INTO `ecc_char_sheet`
            (
              `characterID`,
              `accountID`,
              `eventName`
            ) VALUES (
              '".mysqli_real_escape_string($UPLINK,(int)$_GET['viewChar'])."',
              '".mysqli_real_escape_string($UPLINK,(int)$TIJDELIJKEID)."',
              '".mysqli_real_escape_string($UPLINK,$COMINGEVENT)."'
            );";

          $res = $UPLINK->query($sql);

          header("location: ".$APP['header']."/stats/sheets.php?viewChar=".$_GET['viewChar']);
          exit();
        }
      } else {

      }


    ?>

  </div>
</div>

<div class="wsright cell"></div>

<?php
  include_once($APP["root"] . "/footer.php");
