<?php
$id = (int)$_GET['id'];
require_once("dbnames.inc");
require_once($_qrlib);
if($id > 0)
	QRcode::png("$rootpath/$id");
else
	QRcode::png("https://www.youtube.com/watch?v=dQw4w9WgXcQ");
?>
