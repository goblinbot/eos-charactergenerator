<?php
require_once "../../_includes/includes.php";
include_once ("../../_includes/functions.playercap.php");


if (isset($_GET['selected_event'])) {
  $selected_event = $_GET['selected_event'];
} else {
  $selected_event = $EVENTID;
}
function deactivate_character($id)
{
  $stmt = db::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $stmt = db::$conn->prepare("UPDATE ecc_characters SET sheet_status='inactive' WHERE characterID=$id;");
  $stmt->execute(); // execute the prepared query
  $count = $stmt->rowcount();
  if ($count > 0) {
    return 1;
  } else {
    return print_r($stmt->errorInfo());
  }
}
function redirect($url)
{
  global $name;
  header('Location: ' . $url);
  die();
}


if (!in_array("32", $jgroups, true) && !in_array("30", $jgroups, true)) {
  header('Status: 303 Moved Temporarily', false, 303);
  header('Location: ../');
}

?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="../../_includes/css/participants.css">
</head>

<body>
  <form action="player_cap.php?faction=<?php echo $_GET['faction']; ?>" method="post">
    <input type="submit" class="backButton" name="Back" value="Back" />
  </form>
  <h1> Deactivate Character</h1>
  <table>
    <tr>
      <th width="10%">Character Name</th>
      <th width="10%">Faction</th>
      <th width="20%">Photo</th>
    </tr>
    <?php
    $active_player = get_active_player($_GET['id']);
    while ($row = mysqli_fetch_array($active_player)) {
      echo "<tr>";
      echo '<td>' . $row['character_name'] . "</td>";
      echo '<td>' . ucwords($row['faction']) . "</td>";
      echo '<td><img src="../../img/passphoto/' . $_GET['id'] . '.jpg" alt="Pasfoto" height="300"></td>';
      echo '</tr>';
      $name = $row['character_name'];
    }
    ?>
  </table>
  <h2> Are you certain that you wish to deactivate this character? The character can only be reactivated easily by the
    player.</h2>
  <form action="deactivate_character.php?faction=<?php echo $_GET['faction']; ?>&id=<?php echo $_GET['id']; ?>"
    method="post">
    <input type="submit" class="deactivateButton" name="Deactivate" value="Deactivate" />
  </form>
  <?php
  if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Deactivate'])) {
    $deactivate = deactivate_character($_GET['id']);
    if ($deactivate == 1) {
      $url = './player_cap.php?faction=' . $_GET['faction'] . '&name=' . $name . '&deactivate=true';
      redirect($url);
    } else {
      echo '<script>alert("ERROR: Something has gone wrong and ' . $name . ' has NOT been deactivated; Reason: ' . $deactivate . '")</script>';
    }
  }
  ?>
  <form action="player_cap.php?faction=<?php echo $_GET['faction']; ?>" method="post">
    <input type="submit" class="cancelButton" name="Cancel" value="Cancel" />
  </form>
  </div>
</body>

</html>