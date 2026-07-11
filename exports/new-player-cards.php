<?php
// config variable.
require_once __DIR__ . "/../_includes/includes.php";

$UPLINK->set_charset("utf8mb4");
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
$sql = "SELECT title FROM jml_eb_events where id = $EVENTID;";
$res = $UPLINK->query($sql);
$eventrow = mysqli_fetch_array($res);
$sqlpart1 = "SELECT c.character_name, r.email as email, c.faction ,c.ICC_number,  c.card_id, c.characterID, c.aantal_events, c.bastion_clearance
                from jml_eb_registrants r
                join jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
                join jml_eb_field_values v2 on (v2.registrant_id = r.id and v2.field_id = 14)
                join jml_eb_field_values newplayer on (newplayer.registrant_id = r.id and newplayer.field_id = 54)
                join ecc_characters c ON (c.characterID = SUBSTRING_INDEX(v1.field_value,' - ',-1))
                join jml_users u ON (c.accountID = u.id) 
                WHERE 
                c.card_id IS NULL AND
                 r.event_id = $EVENTID AND v2.field_value = 'Speler' AND $notCancelled";
if (isset($NPCCards))
  $sqlpart2 = " UNION SELECT character_name, NULL as email, faction, ICC_number, card_id, characterID, aantal_events, bastion_clearance from ecc_characters WHERE (characterID in ($NPCCards) AND card_id is NULL)";
else
  $sqlpart2 = ' ';
$sqlpart3 = " ORDER BY faction, character_name";
$sql = $sqlpart1 . $sqlpart2 . $sqlpart3;
$res = $UPLINK->query($sql);
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'Download Images') {
    $images = array();
    while ($row = mysqli_fetch_array($res)) {
      $filepath = $row['characterID'] . '.jpg';
      if (file_exists('../img/passphoto/' . $filepath)) {
        array_push($images, $filepath);
      }
    }
    function zipFilesAndDownload($file_names, $file_path)
    {
      $zip = new ZipArchive();
      $archive_file_name = 'Images - ' . date('Y-m-d H.i.s', time()) . '.zip';
      //create the file and throw the error if unsuccessful
      if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
        exit("cannot open <$archive_file_name>\n");
      }
      //add each files of $file_name array to archive
      foreach ($file_names as $files) {
        // echo $file_path . $files . '<br>';
        $zip->addFile($file_path . $files, $files);
      }
      $zip->close();
      // then send the headers to force download the zip file
      header("Content-type: application/zip");
      header("Content-Disposition: attachment; filename=$archive_file_name");
      header("Content-length: " . filesize($archive_file_name));
      header("Pragma: no-cache");
      header("Expires: 0");
      readfile("$archive_file_name");
      ignore_user_abort(true);
      unlink($archive_file_name);
      exit;
    }
    zipFilesAndDownload($images, '../img/passphoto/');
  }
  if ($_POST['action'] == 'Export to CSV') {
    $data = array();
    while ($row = mysqli_fetch_array($res)) {
      $imagefilename = $row['characterID'] . '.jpg';
      array_push($data, array(
        "Faction" => $row['faction'],
        "Name" => $row['character_name'],
        "ICC_Number" => $row['ICC_number'],
        "Bastion_Clearance" => $row['bastion_clearance'],
        "Filename" => $imagefilename
      ));
    }
    function filterData(&$str)
    {
      $str = preg_replace("/\t/", "\\t", $str);
      $str = preg_replace("/\r?\n/", "\\n", $str);
      if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    // Excel file name for download 
    $fileName = "new-player-export-" . date('Y-m-d H.i.s', time()) . ".csv";

    // Headers for download 
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type:  text/csv");

    $flag = false;
    echo chr(0xEF) . chr(0xBB) . chr(0xBF);
    $file = fopen('php://output', 'w+');
    $bom = chr(0xEF) . chr(0xBB) . chr(0xBF);
    fputs($file, $bom);
    foreach ($data as $row) {
      if (!$flag) {
        // display column names as first row 
        fputs($file, implode(",", array_keys($row)) . "\n");
        $flag = true;
      }
      // filter data 
      array_walk($row, 'filterData');
      fputs($file, implode(",", array_values($row)) . "\n");
    }
    fclose($file);
    exit;
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
  <script>
    function copyTo() {
      // Get the text field
      var copyText = document.getElementById("myInput");

      // Select the text field
      copyText.select();
      copyText.setSelectionRange(0, 99999); // For mobile devices

      // Copy the text inside the text field
      navigator.clipboard.writeText(copyText.value);
    }
  </script>
  <style>
    .hidden-text {
      display: none;
    }

    body {
      background: #000;
      color: #fff;
      font-family: 'Orbitron', sans-serif;
      /*padding-top:20px;*/
    }

    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    a {
      color: lightblue;
    }

    @page {
      size: auto;
      margin: 0;
    }

    @media print {
      #printPageButton {
        display: none;
      }

      * {
        -webkit-print-color-adjust: exact;
      }

      body {
        background: #fff;
        color: #000;
      }

      table {
        font-family: orbitron;
        border-collapse: collapse;
        font-size: 18px;
        width: 70%;
        margin-left: auto;
        margin-right: auto;
      }
    }

    thead {
      color: #41bee8;
    }

    tr:nth-child(even) {
      background-color: #262e3e;
      /* color:#000; */
    }
  </style>
</head>
<?php



echo '<h2>New Card Needed for ' . $eventrow['title'] . '</h2>';
?>

<body>
  <?php
  echo "<table>";
  // echo "<th>E-Mail</th>";
  echo "<th>Faction</th>";
  echo "<th>Name</th>";
  echo "<th>ICC Number</th>";
  echo "<th>Card ID</th>";
  echo "<th>Bastion Clearance</th>";
  echo "<th>Image Name</th>";
  echo "</tr>";
  $emails = '';
  $images = array();
  while ($row = mysqli_fetch_array($res)) {
    $filepath = '../img/passphoto/' . $row['characterID'] . '.jpg';
    if (file_exists($filepath)) {
      array_push($images, $filepath);
    } else {
      $emails = $emails . $row['email'] . ';';
    }
    echo "<tr>";
    // echo "<td><center>" . $row['email'] . "</center></td>";
    echo "<td><center>" . ucwords($row['faction']) . "</center></td>";
    if ($row['characterID'] == 402) {
      echo '<td><center>Invalid character specified by player.</center></td>';
      echo "<td><center>xxxx xxxxx xxxx</center></td>";
      echo "<td><center>n/a</center></td>";
    } else {
      echo '<td><center> <a href="/admin_sl/character-edit.php?id=' . $row['characterID'] . '">' . $row['character_name'] . "</a></center></td>";
      echo "<td><center>" . $row['ICC_number'] . "</center></td>";
      echo "<td><center>" . $row['card_id'] . "</center></td>";
      echo "<td><center>" . $row['bastion_clearance'] . "</center></td>";
      if (file_exists($filepath)) {
        echo '<td><center><img src="' . $filepath . '" alt="Character photo" width="42"><a href="../img/passphoto/' . $row['characterID'] . '.jpg " target="_blank" download">' . $row['characterID'] . '.jpg</a></center></td>';
      } else {
        echo '<td><center><i>Not yet uploaded...</i></center></td>';
      }
    }
    echo "</tr></center>";
  }
  echo "</table>";
  echo "<input type=\"text\" class=\"hidden-text\" value=\"$emails\" id=\"myInput\">";

  ?>
  <button class="button" onclick="copyTo()">Copy Participant E-mails with Mising Photos</button><br><br>
  <form method="post">
    <input type="submit" name="action" class="button" value="Download Images" /> &nbsp;&nbsp;
    <input type="submit" name="action" class="button" value="Export to CSV" />
  </form>
</body>

</html>

<?php
