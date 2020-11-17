<?php
// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");


include_once($APP["root"] . "/header.php");

if (!isset($_SESSION)) {
  session_start();
}


echo "<div class=\"wsleft cell\">";

if (isset($_POST['updateSkills']) && $_POST['updateSkills'] != "") {

  foreach ($_POST['updateSkills'] as $key => $value) {
    $sql2 = "UPDATE `ecc_skills_allskills` SET `description` = '" . $value['description'] . "', `label` = '" . $value['label'] . "' WHERE `skill_id` = " . $key . ";";
    $res2 = $UPLINK->query($sql2) or trigger_error(mysqli_error($UPLINK));
  }
}

echo "</div>";

$sql = "SELECT count( `skill_id` ) AS totalskills FROM `ecc_skills_allskills` ";
$res = $UPLINK->query($sql);
$skillcount = mysqli_fetch_assoc($res)['totalskills'];

$offset = 0;
$perPage = 15;
$printresult = "";

if (isset($_GET['offset']) && (int)$_GET['offset'] > 0) {
  $offset = (int)$_GET['offset'];
}

$limitFirst = $offset * $perPage;

// make pages for results.
$pageNumber = 1;
for ($x = 0; $x < $skillcount; $x = ($x + $perPage)) {

  // echo $pageNumber . ' -> '. $x . '/'.($x+$perPage).' (' . $skillcount . ')<br/>';

  if (($pageNumber - 1) == $offset) {
    $printresult .= "<span style=\"padding:8px 4px; color: #31e184;\">[$pageNumber]&nbsp;</span>";
  } else {
    $printresult .= "<a style=\"padding:8px 4px;\" href=\"" . $APP['header'] . "/dev/skills.php?offset=" . ($pageNumber - 1) . "\">[$pageNumber]&nbsp;</a>";
  }

  $pageNumber++;
}

echo "<div class=\"menu cell\">"
  . "<h1>&nbsp;Skills <br/>&nbsp;($offset/" . ($pageNumber - 1) . ")</h1>"
  . "</div>"

  . "<div class=\"main cell\">"
  . "<div class=\"content\">"

  . "<p>$skillcount skills, split into " . ($pageNumber - 1) . " pages. Showing $perPage per page.</p><br/>"
  . "<p><strong>Pages:</strong>&nbsp;" . $printresult . "</p><hr/>";

$printresult = "";

// $sql = "SELECT a.skill_id, a.label, a.parent, a.level, a.description, g.name
//         FROM ecc_skills_allskills a
//           LEFT JOIN ecc_skills_groups g ON g.primaryskill_id = a.skill_id
//         ORDER BY a.skill_id LIMIT ".(int)$limitFirst." , ".(int)$perPage." ";

$sql = "SELECT skill_id, label, parent, level, description FROM `ecc_skills_allskills` ORDER BY `skill_id` LIMIT " . (int)$limitFirst . " , " . (int)$perPage . " ";
$res = $UPLINK->query($sql);

// echo $sql; exit();

$printresult = "<form name=\"updateSkills\" method=\"POST\" action=\"" . $APP['header'] . "/dev/skills.php?offset=$offset\">"
  . "<div class=\"formitem skillsubmitbox\">"
  . "<input type=\"submit\" class=\"button blue\" value=\"Save changes\" />"
  . "</div>"
  . "<div class=\"row\" style=\"flex-wrap: wrap;\">";

while ($row = mysqli_fetch_assoc($res)) {

  // var_dump($row); exit();
  $sql2 = "SELECT name FROM `ecc_skills_groups` WHERE primaryskill_id = '" . $row['parent'] . "' LIMIT 1";
  $res2 = $UPLINK->query($sql2);
  $row2 = mysqli_fetch_assoc($res2);

  $printresult .=
    "<div class=\"box33\" style=\"border: 1px solid #3b414e;\">"
    . "<label>Options for <strong>" . $row2['name'] . "</strong> lvl. <strong>" . $row['level'] . "</strong></label><br/>"
    . "<div class=\"formitem\">"
    . "<label>Name:</label>"
    . "<input type=\"text\" name=\"updateSkills[" . $row['skill_id'] . "][label]\" value=\"" . EMS_echo($row['label']) . "\" required=\"required\" maxlength=\"47\">"
    . "</div>"

    . "<div class=\"formitem\">"
    . "<label>Skill description:</label><br/>"
    . "<textarea name=\"updateSkills[" . $row['skill_id'] . "][description]\" required=\"required\" />" . EMS_echo($row['description']) . "</textarea>"
    . "</div>"
    . "</div>";

  $printresult .= "<hr/><br/>";

  unset($sql2);
  unset($row2);
  unset($res2);
}

$printresult .= "</div>" . "<div class=\"formitem skillsubmitbox\">"
  . "<input type=\"submit\" class=\"button blue\" value=\"Save changes\" />"
  . "</div>"
  . "</form>";

echo $printresult;
unset($printresult);
?>
</div>
</div>

<div class="wsright cell"></div>

<?php
include_once($APP["root"] . "/footer.php");
