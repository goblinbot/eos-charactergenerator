<?php
include_once __DIR__ . "/../../_includes/includes.php";
$UPLINK->set_charset("utf8mb4");

// 1. Permissions & Redirects
if (!in_array("66", $jgroups, true) || in_array("64", $jgroups,true)) {
  header('Location: /', true, 303);
  exit;
}

$sql = "SELECT faction FROM ecc_characters WHERE accountID = $jid AND sheet_status = 'active'";
$res = $UPLINK->query($sql);
$char = mysqli_fetch_array($res);
$faction = $char['faction'];
$pdf_file = "briefings/$faction.pdf";

// Check if file exists to avoid errors
if (file_exists($pdf_file)) {
    echo '<div style="width:100%; height:100vh;">
            <iframe 
                src="' . $pdf_file . '" 
                width="100%" 
                height="100%" 
                style="border: none;">
                <p>Your browser does not support iframes. 
                <a href="' . $pdf_file . '">Click here to view the PDF.</a></p>
            </iframe>
          </div>';
} else {
    echo "File not found.";
}