<?php
if($_SERVER['HTTP_REFERER'] == "http://hdwhite.org/login.php")
	echo("<script>window.opener.location.reload(true);\nwindow.close();</script>");
?>
<html>
	<head>
		<style type="text/css">
			@import url("/harry.css");
			<?php if($schedulecss) { ?>
			@import url("/harrybig.css");
			@import url("/qb/schedules/schedules.css");
			@import url("/qb/schedules/print.css") print;
			<?php } ?>
		</style>
		<title><?=$title ?></title>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h2><?=$headertext ?></h2>
				<?php include("../header.php"); ?>
			</div>
