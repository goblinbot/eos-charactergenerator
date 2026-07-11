<?php
require_once __DIR__ . '/../_includes/includes.php';
?>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../_includes/css/style.css" rel="stylesheet" type="text/css" />
  <link href="../_includes/css/skill_desc.css" rel="stylesheet" type="text/css" />
</head>

<?php
echo "<div class='body'><body>";
echo '<button onclick="history.go(-1);">Back </button> &nbsp; &nbsp; &nbsp; <img src="../img/outpost-icc-pm.png"  width="200" >';
$skillid = $_GET["id"];

$stmt = db::$conn->prepare(
  "SELECT s.label, s.level, s.description, g.name as parent from ecc_skills_allskills s
    LEFT JOIN ecc_skills_groups g on (g.primaryskill_id = s.parent)
  WHERE skill_id = $skillid;"
);
$res = $stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($res as $SKILL => $VALUES) {
  $printableSkills[$VALUES['parent']] = $VALUES;
}
echo "<h1 font-size='6vw'>Name: " . $VALUES['label'] . "</h1>";
echo "<h2>" . $VALUES['parent'] . " level:" . $VALUES['level'] . "</h2>";
echo nl2br($VALUES['description']) . "</body></div>";
echo "</html>";
