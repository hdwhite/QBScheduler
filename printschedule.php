<?php
//This page includes a printable schedule for each team and room
require_once("dbnames.inc");
require_once($_dbconfig);
require_once("templates/brackets.php");
$urlarray = explode("/", $_SERVER['REQUEST_URI']);
$tournamentid = htmlentities($urlarray[3]);
//Return a 404 if the tournament doesn't exist
$scheduleinfo = $mysqli->query("SELECT * FROM $_scheduledb WHERE id=$tournamentid")->fetch_assoc();
if(is_null($scheduleinfo))
{
	header("HTTP/1.0 404 Not Found");
	require("../../errors/404.php");
	exit();
}

//Get the JSON from the GetSchedules page.
//Should probably be converted to an API call.
$scheduledata = json_decode(file_get_contents("$rootpath/getschedules.php?t=$tournamentid"), true);
$teamdata = $scheduledata['teams'];
$roomdata = $scheduledata['rooms'];
$bracketdata = $scheduledata['brackets'];

//Gotta figure out how many rounds the tournament takes
$numrounds = 0;
foreach($bracketdata['playoffs'] as $curplayoff)
	$numrounds = max($numrounds, max(array_keys($curplayoff['matches'])));
if($numrounds == 0)
	$numrounds = max(array_keys($bracketdata['prelims'][0]['matches']));
?>
<html>
	<head>
		<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/analytics.php"); ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<style type="text/css">
			@import url("/qb/schedules/printschedule.css");
		</style>
		<title>Printable Team and Room Schedules</title>
	</head>
	<body>
		<div id="instructions">
			<p><a href="<?=$rootpath ?>/<?=$tournamentid ?>">Click here to go back to the web-friendly schedule</a></p>
			<h3>How to use</h4>
			<p>This page contains printable schedules for all teams and all rooms at the tournament. This page automatically contains page breaks and each printed page will contain a QR code linking to the page containing the schedule.</p>
			<p>If you only wish to print a schedule for a certain team or room, please consult the following list:</p>
			<ul>
<?php
//This instruction page will not appear when printed
//We go through each team and room and figure out what page they'd be on
$curpage = 0;
foreach($teamdata as $teamid => $curteam)
{
	$curpage++;
	$teamname = $curteam['name'];
	echo("<li>Page $curpage: $teamname</li>");
}
echo("</ul><ul>");
foreach($roomdata as $roomid => $curroom)
{
	$curpage++;
	$roomname = $curroom['name'];
	echo("<li>Page $curpage: $roomname</li>");
}
?>
			</ul>
		</div>
<?php
//Now for each team, get and print their schedule
foreach($teamdata as $teamid => $curteam)
{
	?>
<div class="teamentry" id="team<?=$teamid ?>">
	<h2>Schedule for <?=$curteam['name'] ?></h2>
	<table>
		<thead><tr><th>Round</th><th style="min-width:275px">Opponent</th><th style="min-width:150px">Room</th></tr></thead>
		<tbody>
<?php
	$numprelims = max(array_keys($bracketdata['prelims'][$curteam['prelimbracket']]['matches']));
	for($i = 1; $i <= $numrounds; $i++)
	{
		//If we now who the opponent is, we display it
		if(array_key_exists($i, $curteam['matches']))
		{
			$opponent = $curteam['matches'][$i]['opponent'];
			//If the opponent ID is 99 or higher, that means we don't know who
			//they are yet; keep it blank
			$oname = ($opponent > 98 ? "&nbsp;" : $teamdata[$opponent]['name']);
			echo("<tr><th>$i</th><td>$oname</td><td>" . $roomdata[$curteam['matches'][$i]['room']]['name'] . "</td></tr>");
		}
		elseif($i <= $numprelims)
			echo("<tr><th>$i</th><td>Bye</td><td>N/A</td></tr>");
		else
			echo("<tr><th>$i</th><td>&nbsp;</td><td>&nbsp;</td></tr>");
	}
?>
		</tbody>
	</table>
	<img class="qrcode" src="<?=$rootpath ?>/generateqr.php?id=<?=$tournamentid ?>" />
</div>
<?php
}

//Now to do a schedule for each room
foreach($roomdata as $roomid => $curroom)
{
	?>
<div class="roomentry" id="room<?=$roomid ?>">
	<h2>Schedule for <?=$curroom['name'] ?></h2>
	<table>
		<thead><tr><th>Round</th><th style="min-width:250px">Team 1</th><th style="min-width:250px">Team 2</th></tr></thead>
		<tbody>
<?php
	for($i = 1; $i <= max(array_keys($curroom['matches'])); $i++)
	{
		if(array_key_exists($i, $curroom['matches']))
		{
			$curmatch = $curroom['matches'][$i];
			//Make it blank if we don't know what team will be there
			$team1 = ($curmatch[0] > 98 ? "&nbsp;" : $teamdata[$curmatch[0]]['name']);
			$team2 = ($curmatch[1] > 98 ? "&nbsp;" : $teamdata[$curmatch[1]]['name']);
			echo("<tr><th>$i</th><td>$team1</td><td>$team2</td></tr>");
		}
		else
			echo("<tr><th>$i</th><td colspan='2' style='text-align:center'>Bye</td></tr>");
	}
?>
		</tbody>
	</table>
	<img class="qrcode" src="<?=$rootpath ?>/generateqr.php?id=<?=$tournamentid ?>" />
</div>
<?php
}
?>
	</body>
</html>
