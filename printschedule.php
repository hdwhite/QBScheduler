<?php
require_once("dbnames.inc");
$urlarray = explode("/", $_SERVER['REQUEST_URI']);
$tournamentid = htmlentities($urlarray[3]);
$scheduledata = json_decode(file_get_contents("$rootpath/getschedules.php?t=$tournamentid"), true);
$teamdata = $scheduledata['teams'];
$roomdata = $scheduledata['rooms'];
$bracketdata = $scheduledata['brackets'];

$numrounds = 0;
foreach($bracketdata['playoffs'] as $curplayoff)
	$numrounds = max($numrounds, max(array_keys($curplayoff['matches'])));
if($numrounds == 0)
	$numrounds = max(array_keys($bracketdata['prelims'][0]['matches']));

foreach($teamdata as $teamid => $curteam)
{
	echo("Team: " . $curteam['name'] . "\n");
	$numprelims = max(array_keys($bracketdata['prelims'][$curteam['prelimbracket']]['matches']));
	for($i = 1; $i <= $numrounds; $i++)
	{
		if(array_key_exists($i, $curteam['matches']))
		{
			$opponent = $curteam['matches'][$i]['opponent'];
			$oname = ($opponent > 98 ? "Unknown" : $teamdata[$opponent]['name']);
			echo("Round: $i\tOpponent: $oname\tRoom: " . $roomdata[$curteam['matches'][$i]['room']]['name'] . "\n");
		}
		elseif($i <= $numprelims)
			echo("Round: $i\tBye\n");
		else
			echo("Round: $i\tUnknown\n");
	}
	echo("\n");
}

foreach($roomdata as $roomid => $curroom)
{
	echo("Room: " . $curroom['name'] . "\n");
	for($i = 1; $i <= max(array_keys($curroom['matches'])); $i++)
	{
		if(array_key_exists($i, $curroom['matches']))
		{
			$curmatch = $curroom['matches'][$i];
			$team1 = ($curmatch[0] > 98 ? "Unknown" : $teamdata[$curmatch[0]]['name']);
			$team2 = ($curmatch[1] > 98 ? "Unknown" : $teamdata[$curmatch[1]]['name']);
			echo("Round: $i\tTeam 1: $team1\tTeam 2: $team2\n");
		}
		else
			echo("Round: $i\tBye\n");
	}
	echo("\n");
}
print_r($scheduledata);
?>
