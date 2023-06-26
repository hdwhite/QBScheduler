<?php
//This page displays a given schedule.
$urlarray = explode("/", $_SERVER['REQUEST_URI']);
$tournamentid = htmlentities($urlarray[3]);
require_once("dbnames.inc");
require_once($_dbconfig);
require_once("templates/brackets.php");
$scheduleinfo = $mysqli->query("SELECT * FROM $_scheduledb WHERE id=$tournamentid")->fetch_assoc();
if(is_null($scheduleinfo))
{
	header("HTTP/1.0 404 Not Found");
	require("../../errors/404.php");
	exit();
}
$bracketdata = $mysqli->query("SELECT * FROM $_bracketdb WHERE tournament=$tournamentid");
$roomdata = $mysqli->query("SELECT * FROM $_roomdb WHERE tournament=$tournamentid");
$teamdata = $mysqli->query("SELECT * FROM $_teamdb WHERE tournament=$tournamentid AND phase=0");
$playoffdata = $mysqli->query("SELECT * FROM $_teamdb WHERE tournament=$tournamentid AND phase=1");
$template = json_decode(file_get_contents("templates.json"))->schedules->$scheduleinfo['format'];
?>

<html>
	<head>
		<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/analytics.php"); ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script>
			$(document).ready(function()
			{
				//First things first, we gotta display everything once it loads
				//Also the text() function is slightly less vulnerable to injection
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
			<?php if($template->landscape) { ?>
			@import url("/qb/schedules/landscape.css") print;
			<?php } else { ?>
			@import url("/qb/schedules/print.css") print;
			<?php } ?>
		</style>
		<title>Viewing a Schedule</title>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h2 id="headername">Viewing a Schedule</h2>
				<?php include("header.php"); ?>
			</div>
			<div id="content">
				<div class="entry printinfo">
					<p>This schedule is printable. The printed copy will contain a QR code that links back to this page. It is recommended that you print in <?php if($template->landscape) echo("landscape"); else echo("portrait"); ?> mode. If you wish to print individualised schedules for each team and room, <a href="<?=$rootpath ?>/<?=$tournamentid ?>/print">click here</a>.</p>
				</div>
				<div class="entry">
					<img id="qrcode" src="<?=$rootpath ?>/generateqr.php?id=<?=$tournamentid ?>" />
					<?php include("templates/" . $scheduleinfo['format'] . ".php"); ?>
				</div>
			</div>
<?php include("footer.php"); ?>	
