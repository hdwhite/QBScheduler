<?php
$urlarray = explode("/", $_SERVER['REQUEST_URI']);
$tournamentid = htmlentities($urlarray[3]);
require_once("dbnames.inc");
require_once($_dbconfig);
$scheduleinfo = $mysqli->query("SELECT * FROM $_scheduledb WHERE id=$tournamentid")->fetch_assoc();
if(is_null($scheduleinfo))
	exit();
$bracketdata = $mysqli->query("SELECT * FROM $_bracketdb WHERE tournament=$tournamentid");
$roomdata = $mysqli->query("SELECT * FROM $_roomdb WHERE tournament=$tournamentid");
$teamdata = $mysqli->query("SELECT * FROM $_teamdb WHERE tournament=$tournamentid AND phase=0");
$playoffdata = $mysqli->query("SELECT * FROM $_teamdb WHERE tournament=$tournamentid AND phase=1");
$template = $mysqli->query("SELECT * FROM $_templatedb WHERE id=" . $scheduleinfo['format'])->fetch_assoc();
?>

<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script>
			$(document).ready(function()
			{
				tournamentname = <?=json_encode($scheduleinfo['name']) ?>;
				$('.tourneyname').text(tournamentname);
				<?php
					while($curbracket = $bracketdata->fetch_assoc())
					{
						if($curbracket['phase'] == 0)
							echo("$('.prelimbracket" . $curbracket['position'] . "').text(" . json_encode($curbracket['name']) . ");\n");
						elseif($curbracket['phase'] == 1)
							echo("$('.playoffbracket" . $curbracket['position'] . "').text(" . json_encode($curbracket['name']) . ");\n");
					}
					
					while($curroom = $roomdata->fetch_assoc())
						echo("$('.room" . $curroom['position'] . "').text(" . json_encode($curroom['name']) . ");\n");
					
					while($curteam = $teamdata->fetch_assoc())
						echo("$('.team" . $curteam['position'] . "').text(" . json_encode($curteam['name']) . ");\n");
					
					while($curteam = $playoffdata->fetch_assoc())
						echo("$('.playoffteam" . $curteam['position'] . "').text(" . json_encode($curteam['name']) . ");\n");
				?>
				$('.finals' + <?php echo($scheduleinfo['finals']); ?>).show();
				document.title = "Schedule for " + tournamentname;
				$('#headername').text(tournamentname);
			});
		</script>
		<style type="text/css">
			@import url("/harry.css");
			@import url("/harrybig.css");
			@import url("/qb/schedules/schedules.css");
			@import url("/qb/schedules/print.css") print;
		</style>
		<title>Viewing a Schedule</title>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h2 id="headername">Viewing a Schedule</h2>
				<?php include("../header.php"); ?>
			</div>
			<div id="content">
				<div class="entry">
					<?php include("templates/" . $template['url'] . ".php"); ?>
				</div>
			</div>
<?php include("footer.php"); ?>	
