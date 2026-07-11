<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
$charid = $_POST["charid"];
$src = $_SERVER["DOCUMENT_ROOT"] . $_POST["image_name"];
$dst = APP_ROOT . '/img/passphoto/' . $_POST["charid"] . '.jpg';
rename($src, $dst);
header("Location: ../../index.php?viewChar=" . $charid . "&editInfo=true");