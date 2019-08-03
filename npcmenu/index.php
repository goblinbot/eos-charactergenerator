<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
  include_once($APP["root"] . "/_includes/functions.sheet.php");

  include_once($APP["root"] . "/header.php");

  // THIS IS AN ADDON FOR DURING THE EVENT
?>
<div class="wsleft cell"></div>

<div class="menu cell">
  <?=generateMenu('characters');?>
</div>

<div class="main cell">
  <div class="content">

    <?php
    if($jid == 451 || $jid == 740 || $jid == 746) {

    } else {
      exit();
    }


    if (isset($_GET['create']) && $_GET['create'] == true) {

      if(isset($_POST['newNPC']) && $_POST['newNPC'] != "") {

        $sql = "UPDATE `ecc_characters` SET `status` = 'npcOff', `card_id` = '".time()."' WHERE `card_id` = '".mysqli_real_escape_string($UPLINK,$_POST['card_id'])."' ";
        $res = $UPLINK->query($sql);

        $ICCID = generateICCID($_POST['newNPC']['faction']);

        $sql = "INSERT INTO `ecc_characters` (`accountID`, `faction`, `status`, `character_name`, `ICC_number`, `douane_disposition`,`threat_assessment`,`bastion_clearance`,`rank`,`card_id`,`douane_notes`)
          VALUES (
            '740',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['faction'])."',
            'npcOn',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['character_name'])."',
            '".mysqli_real_escape_string($UPLINK,$ICCID)."',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['douane_disposition'])."',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['threat_assessment'])."',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['bastion_clearance'])."',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['rank'])."',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['card_id'])."',
            '".mysqli_real_escape_string($UPLINK,$_POST['newNPC']['douane_notes'])."'
          );";
        $res = $UPLINK->query($sql) or trigger_error(mysqli_error($UPLINK));

        // header("location: ".$APP['header']."/npcmenu/index.php?edit=true");
        echo $sql;
        // exit();

      } else {

        echo "<h2>Create-A-Minion</h2>";
        echo "<p><a href=\"".$APP['header']."/npcmenu/index.php\" class=\"button\">Back</a></p>";

        echo "<form method=\"POST\" action=\"".$APP['header']."/npcmenu/index.php?create=true\">"
          ."<div class=\"formitem center-xs\">"
            ."<h3>Faction</h3>"
            ."<select name=\"newNPC[faction]\">"
              . "<option value=\"aquila\">Aquila</option>"
              . "<option value=\"dugo\">Dugo</option>"
              . "<option value=\"ekanesh\">Ekanesh</option>"
              . "<option value=\"pendzal\">Pendzal</option>"
              . "<option value=\"sona\">Sona</option>"
            . "</select>"
          ."</div>"

          ."<div class=\"formitem\">"
            ."<h3><i class=\"fas fa-user\"></i>&nbsp;Character Name</h3>"
            ."<input required type=\"text\" placeholder=\"Character Name\" maxlength=\"99\" name=\"newNPC[character_name]\"></input>"
          ."</div>"

          ."<div class=\"formitem\">
            <strong>Disposition</strong><br/>
            <input class=\"disposition-val ac\" checked name=\"newNPC[douane_disposition]\" value=\"ACCESS PENDING\" type=\"radio\">Access Pending<br>
            <input class=\"disposition-val ag\" name=\"newNPC[douane_disposition]\" value=\"ACCESS GRANTED\" type=\"radio\">Access Granted<br>
            <input class=\"disposition-val de\" name=\"newNPC[douane_disposition]\" value=\"DETAIN\" type=\"radio\">Detain<br>
            <input class=\"disposition-val iv\" name=\"newNPC[douane_disposition]\" value=\"ICC VETTED\" type=\"radio\">ICC Vetted<br>
          </div>"


          ."<div class=\"formitem\">

            <strong>Threat level</strong><br>
            <input class=\"disposition-val t0\" name=\"newNPC[threat_assessment]\" value=\"0\" type=\"radio\">0<br>
            <input class=\"disposition-val t1\" name=\"newNPC[threat_assessment]\" value=\"1\" type=\"radio\">1<br>
            <input class=\"disposition-val t2\" name=\"newNPC[threat_assessment]\" value=\"2\" type=\"radio\">2<br>
            <input class=\"disposition-val t3\" name=\"newNPC[threat_assessment]\" value=\"3\" type=\"radio\">3<br>
            <input class=\"disposition-val t4\" name=\"newNPC[threat_assessment]\" value=\"4\" type=\"radio\">4<br>
            <input class=\"disposition-val t5\" name=\"newNPC[threat_assessment]\" value=\"5\" type=\"radio\">5<br>

          </div>";

          ?>
          <div class="formitem">
            <strong>Clearance</strong><br>
            <input class="disposition-val c0" name="newNPC[bastion_clearance]" value="0" type="radio">0<br>
            <input class="disposition-val c1" name="newNPC[bastion_clearance]" value="1" type="radio">1<br>
            <input class="disposition-val c2" name="newNPC[bastion_clearance]" value="2" type="radio">2<br>
            <input class="disposition-val c3" name="newNPC[bastion_clearance]" value="3" type="radio">3<br>
          </div>

          <div class="formitem">
            <strong>Rank</strong><br>
            <input type="text" class="change-rank-val" name="newNPC[rank]" placeholder="Elemental Prince"><br><br>
            <strong>Card</strong><br>
            <input type="text" class="change-card" name="newNPC[card_id]"><br>
          </div>

          <div class="formitem">
            <strong>Douane Notes</strong><br/>
            <textarea name="newNPC[douane_notes]"></textarea>

          </div>


          <div class="formitem">
            <input type="submit" class="button blue" value="Create character"></input>
          </div>

          </form>
        <?php

      }


    } else if (isset($_GET['edit']) && $_GET['edit'] == true)  {

      echo "<p><a href=\"".$APP['header']."/npcmenu/index.php\" class=\"button\">Back</a></p>";



    } else {

    ?>

    <h1>Create or edit NPC</h1>

    <div class="row">
      <hr />
    </div>

    <div class="row">
      <p>
        <a class="button" href="<?=$APP['header']?>/npcmenu?create=true"><i class="fas fa-user-plus"></i> CREATE</a>
        &nbsp;
        <a class="button" href="<?=$APP['header']?>/npcmenu?edit=true"><i class="fas fa-users"></i> EDIT</a>
      </p>
    </div>

    <?php

    }

    ?>

  </div>
</div>

<div class="wsright cell"></div>

<?php
  include_once($APP["root"] . "/footer.php");
