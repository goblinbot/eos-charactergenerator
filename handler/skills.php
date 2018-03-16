<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");

/* no login means NO PLAY. GET OUT. */
if(!isset($jid)) {
  echo "[ERR 440]";
  exit();
}
if(!isset($UPLINK)) {
  echo "[ERR 442]";
  exit();
}


// GET SKILLS HIER EN STOP ZE IN DE SESSIE
