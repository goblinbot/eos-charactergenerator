<?php
require_once "../../_includes/includes.php";
include_once ("../../_includes/functions.playercap.php");


if (isset($_GET['selected_event'])) {
  $selected_event = $_GET['selected_event'];
} else {
  $selected_event = $EVENTID;
}


if (!in_array("32", $jgroups, true) && !in_array("30", $jgroups, true)) {
  header('Status: 303 Moved Temporarily', false, 303);
  header('Location: ../');
}

function deactivate_character($name)
{
  echo '<script>alert("' . $name . ' has been deactivated.")</script>'; 
}

if(isset($_GET['deactivate']))
{
    deactivate_character($_GET['name']);
}

?>
<!DOCTYPE html>
<html>

<head>
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
  <link rel="stylesheet" href="../../_includes/css/participants.css">
</head>

<body>
<form action="../participants.php" method="post">
    <input type="submit" class="backButton" name="Back" value="Back" />
<!-- <button class="backButton" id="backButton" style="width: 100px;"
    onClick="window.history.go(-1); return false;">Back</button> -->
  <button class="button" id="printPageButton" style="width: 100px;" onClick="window.print();">Print</button><br>
  </form>
  <?php
  $event_title = explode(' ', player_cap_count_from());
  $event_number = $event_title[1];
  $event_title_converted = $event_title[0] . ' ' . roman_to_integer($event_number);
  ?>
  <h1> Active <?php echo ucwords($_GET['faction']); ?> Players since <?php echo $event_title_converted;?></h1>
  
  <table>
    <tr>
      <th width="10%">Character Name</th>
      <th width="10%">Latest Event</th>
      <?php
      if (in_array("32", $jgroups, true)) { ?>
        <th width="10%">Deactivate</th>
      <?php } ?>
    </tr>
    <?php
    $active_players = get_active_players($_GET['faction']);
    while ($row = mysqli_fetch_array($active_players)) {
      echo "<tr>";
      echo '<td>' . ucwords($row['character_name']) . "</td>";
      $last_event_player = get_latest_event_player($row['characterID']);
      $last_event_title = explode(' ', $last_event_player['title']);
      $last_event_number = $last_event_title[1];
      $last_event_title_converted = $last_event_title[0] . ' ' . roman_to_integer($last_event_number);
      echo '<td>' . $last_event_title_converted .'</td>';  
      if (in_array("32", $jgroups, true)) {
        echo '<td width="10%">';
        echo '<a href="./deactivate_character.php?faction=' . $_GET['faction'] . '&id=' . $row['characterID'] . '" class="deactivateButton">Deactivate</a>';
        echo '</td>';
      }
      echo '</tr>';
    } ?>
  </table>
  </div>
</body>

</html>