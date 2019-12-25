<?php
//This creates a PNG of the QR code used to get to the schedule
$id = (int)$_GET['id'];
require_once("dbnames.inc");
require_once($_qrlib);
if($id > 0)
	QRcode::png("$rootpath/$id");
else
	//You shouldn't get here, but if you do I'll find it funny
	QRcode::png("https://www.youtube.com/watch?v=dQw4w9WgXcQ");
?>
