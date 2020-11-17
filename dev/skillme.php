<?php


// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");
include_once($APP["root"] . "/_includes/functions.sheet.php");


echo "<pre>";
echo "<p>" . generateCode(25, 'hex') . "</p>";
echo "<p>" . generateCode(25, 'hex') . "</p>";
echo "<p>" . generateCode(25, 'hex') . "</p>";
echo "<p>" . generateCode(25, 'hex') . "</p>";
echo "<p>" . generateCode(25, 'hex') . "</p>";
echo "<p>" . generateCode(25, 'hex') . "</p>";
echo "</pre>";
echo "<br/><br/>";
echo "faction samples: ";
echo "<pre>";
echo "<p>(5)" . generateCode(12, 'number') . "</p>";
echo "<p>(5)" . generateCode(12, 'number') . "</p>";
echo "<p>(9)" . generateCode(12, 'number') . "</p>";
echo "<p>(8)" . generateCode(12, 'number') . "</p>";
echo "<p>(7)" . generateCode(12, 'number') . "</p>";
echo "<p>(7)" . generateCode(12, 'number') . "</p>";
echo "</pre>";
exit();

// $sql = "SELECT * FROM `ecc_skills_groups`";
// $res = $UPLINK->query($sql);
//
// echo "<h1>Oh god here we go</h1><br/>";
//
// $i = 0;
// $result = array();
//
// while($row = mysqli_fetch_assoc($res)) {


  // echo "<pre>";
  // echo "Id| ".$i."<br/>";
  // echo "Na| ".$row["name"]."<br/>";
  // echo "Ix| ".$row["siteindex"]."<br/>";
  // echo "Pa| ".$row["parents"]."<br/>";
  // echo "V#| 1<br/>";
  // echo "</pre>";
  // echo "<hr/>";

  // for($x = 1; $x <= 5; $x++) {

    // $result[$i] = array();
    // $result[$i]['name'] = 'skill title';
    // $result[$i]['versionNumber'] = 1;
    // $result[$i]['siteindex'] = $row["siteindex"] . "_".$x;
    // $result[$i]['level'] = $x;
    // $result[$i]['description'] = 'Description of skill';

  //   if($row["parents"] != 'none') { $y = ($x + 5); } else { $y = $x; }
  //
  //   $xsql = "INSERT INTO `ecc_skills_allskills`
  //   (
  //     `label`,
  //     `skill_index`,
  //     `level`,
  //     `version`,
  //     `description`
  //   ) VALUES (
  //     'Skill ".$row["siteindex"]." ".$y."',
  //     '".$row["siteindex"] . "_". $y."',
  //     '".$y."',
  //     '1',
  //     'Skill description');";
  //   // $xres = $UPLINK->query($xsql) or trigger_error(mysqli_error($UPLINK));
  //
  //
  //   $i++;
  // }



// }

// $sql = "SELECT * FROM `ecc_skills_allskills`";
// $res = $UPLINK->query($sql);
//
// echo "<h1>Oh god here we go</h1><br/>";
//
// while($row = mysqli_fetch_assoc($res)) {
//   $sql2 = "UPDATE `ecc_skills_allskills` SET `skill_id` = '".(31000 + $row['skill_id'])."' WHERE `ecc_skills_allskills`.`skill_id` = ".$row['skill_id'].";";
//   $res2 = $UPLINK->query($sql2) OR trigger_error(mysqli_error($UPLINK));
// }

// $sql = "SELECT * FROM `ecc_skills_allskills`";
// $res = $UPLINK->query($sql);
//
// echo "<h1>Oh god here we go</h1><br/>";
//
// while($row = mysqli_fetch_assoc($res)) {
//
//
//   $temp = explode(" ",$row['label']);
//
//   echo $row['label'] . " => " . $temp[1] . "<br/>";
//
//     $sql2 = "UPDATE `ecc_skills_allskills` SET `parent` = '".$temp[1]."' WHERE `ecc_skills_allskills`.`skill_id` = ".$row['skill_id'].";";
//     $res2 = $UPLINK->query($sql2) OR trigger_error(mysqli_error($UPLINK));
// }

// echo "<pre>";
// var_dump($result);
// echo "</pre>";



// $sql = "SELECT skill_id,skill_index,parent FROM `ecc_skills_allskills`";
// $res = $UPLINK->query($sql);
//
//
// while($row = mysqli_fetch_assoc($res)) {
//
//   echo "<p>";
//   echo $row['skill_index'] . ", parent = ". $row['parent'];
//   echo "  ======>  ";
//
//   $xSQL = "SELECT primaryskill_id FROM ecc_skills_groups WHERE siteindex = '".$row['parent']."' LIMIT 1";
//   $xRES = $UPLINK->query($xSQL);
//
//   $xROW = mysqli_fetch_assoc($xRES);
//
//   echo (int)$xROW['primaryskill_id'];
//
//   $sql2 = "UPDATE `ecc_skills_allskills` SET `parent` = '".(int)$xROW['primaryskill_id']."' WHERE `skill_id` = ".$row['skill_id'].";";
//   $res2 = $UPLINK->query($sql2) OR trigger_error(mysqli_error($UPLINK));
//
//   echo "</p>";
// }













// EINDE
