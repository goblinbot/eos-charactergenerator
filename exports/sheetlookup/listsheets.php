<?php
// BEGIN PLAYER COUNT QUERY
$sql = "SELECT count(character_name) as totalchars from ecc_characters  WHERE sheet_status = 'active' AND faction LIKE '$_FACTION' AND status NOT LIKE 'figurant%' AND character_name IS NOT NULL;";

$res = $UPLINK->query($sql);
$resCOUNT = mysqli_fetch_assoc($res)['totalchars'];
?>
<select id="factionswitch"
                  style="padding: 5px; border-radius: 2px; margin-bottom: 1rem;"
                <?php echo "onchange=\"location.href = '{$APP['header']}/exports/sheetlookup/displaysheets.php?offset=0&faction=' + this.value; \"";?>>
                <option value="">Select faction</option>
                <option value="%" <?php if($_FACTION=='%'){echo 'selected';}?>>All Factions</option>
                <option value="Aquila" <?php if($_FACTION=='Aquila'){echo 'selected';}?>>Aquila</option>
                <option value="Dugo" <?php if($_FACTION=='Dugo'){echo 'selected';}?>>Dugo</option>
                <option value="Ekanesh" <?php if($_FACTION=='Ekanesh'){echo 'selected';}?>>Ekanesh</option>
                <option value="Pendzal" <?php if($_FACTION=='Pendzal'){echo 'selected';}?>>Pendzal</option>
                <option value="Sona" <?php if($_FACTION=='Sona'){echo 'selected';}?>>Sona</option>
              </select>
<?php
echo '<h1>SL Character Sheet Master List</h1>';

$printresult = "";

if (isset($_GET['offset']) && (int) $_GET['offset'] > 0) {
    $offset = (int) $_GET['offset'];
}

$limitFirst = $offset * $perPage;


$pageNumber = 1;
echo "Page ";
for ($x = 0; $x < $resCOUNT; $x = ($x + $perPage)) {

    if (($pageNumber - 1) == $offset) {
        echo "<span style=\"padding:8px 4px; color: red;\"><button type='disabled'><strong><font size=4>$pageNumber</font></strong></button></span>";
    } else {
        echo "<a style=\"padding:8px 4px;\" href=\"" . $APP['header'] . "/exports/sheetlookup/displaysheets.php?offset=" . ($pageNumber - 1) . "&faction=$_FACTION\"><button>$pageNumber</button></a>";
    }

    $pageNumber++;
}

echo "<br/><br/>";


$sql = "SELECT characterID, character_name, faction from ecc_characters
        where sheet_status='active' AND `faction` LIKE '$_FACTION' AND status NOT LIKE 'figurant%' AND character_name IS NOT NULL
          ORDER BY character_name
          LIMIT " . (int) $limitFirst . " , " . (int) $perPage . " ";
$res = $UPLINK->query($sql);

if ($res) {

    echo "<table style=\"border: 0; width: 100%;\">"
        . "<th>ID</th><th>Name</th><th>Faction</th><th>Open Sheet</th>";
    while ($row = mysqli_fetch_assoc($res)) {
        // $xCHAR = $row['characterID'];
        $xTOPRINT = false;

        if ($row['character_name'] == "" || $row['character_name'] == null) {
            $row['character_name'] = '<span style="color: tomato;">no name</span>';
        }



        echo "<tr>"
            . "<td>#" . $row['characterID'] . "</td>"
            . "<td>" . $row['character_name'] . "</td><td>" . ucfirst($row['faction']) . "</td>"
            // ."<td><a href=\"".$APP['header']."/exports/sheetlookup/displaysheets.php?characterID=".$row['characterID']."\" target=\"_new\"><button>Sheets</button></a></td>"
            . "<td><button onclick=\"window.open('{$APP["header"]}/exports/sheetlookup/displaysheets.php?characterID={$row['characterID']}','sheets','width=1280,height=1000');\">View Sheet</button></td></tr>";
        unset($xSTATUS);
    }

    echo "</table>";
    if (isset($_GET['offset']) && (int) $_GET['offset'] > 0) {
        $offset = (int) $_GET['offset'];
    }

    $limitFirst = $offset * $perPage;


    $pageNumber = 1;
    echo "Page ";
    for ($x = 0; $x < $resCOUNT; $x = ($x + $perPage)) {

        if (($pageNumber - 1) == $offset) {
            echo "<span style=\"padding:8px 4px; color: red;\"><button type='disabled'><strong><font size=4>$pageNumber</font></strong></button></span>";
        } else {
            echo "<a style=\"padding:8px 4px;\" href=\"" . $APP['header'] . "/exports/sheetlookup/displaysheets.php?offset=" . ($pageNumber - 1) . "&faction=$_FACTION\"><button>$pageNumber</button></a>";
        }

        $pageNumber++;
    }

    echo "<br/><br/>";
}
?>