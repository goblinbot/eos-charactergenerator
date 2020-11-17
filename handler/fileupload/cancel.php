<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
$charid = $_POST["charid"];
$src = $_SERVER["DOCUMENT_ROOT"] . $_POST["image_name"];
unlink($src);
header("Location: ../../index.php?viewChar=" . $charid . "&editInfo=true");
