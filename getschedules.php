<?php
//This creates a JSON object with all the tournament info
//At some point I ought to change this to API queries
require_once("dbnames.inc");
require_once($_dbconfig);
$tournament = $_GET['t'];
$scheduleinfo = $mysqli->query("SELECT * FROM $_scheduledb WHERE id=$tournament")->fetch_assoc();
if(is_null($scheduleinfo))
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
$bracketdata = $mysqli->query("SELECT * FROM $_bracketdb WHERE tournament=$tournament");
$roomdata = $mysqli->query("SELECT * FROM $_roomdb WHERE tournament=$tournament");
$teamdata = $mysqli->query("SELECT * FROM $_teamdb WHERE tournament=$tournament");
$template = $mysqli->query("SELECT * FROM $_templatedb WHERE id=" . $scheduleinfo['format'])->fetch_assoc();
$numteams = $template['teams'];
$numrooms = $template['rooms'];

$prelimbrackets = array();
$playoffbrackets = array();
while($curbracket = $bracketdata->fetch_assoc())
	if($curbracket['phase'] == 0)
		$prelimbrackets[$curbracket['position']] = (object) ["name" => htmlentities($curbracket['name']), "matches" => array()];
	else
		$playoffbrackets[$curbracket['position']] = (object) ["name" => htmlentities($curbracket['name']), "matches" => array()];
$bracketarray = (object) ["prelims" => $prelimbrackets, "playoffs" => $playoffbrackets];

$roomarray = array();
while($curroom = $roomdata->fetch_assoc())
	if($curroom['position'] < $numrooms)
		$roomarray[$curroom['position']] = (object) ["name" => htmlentities($curroom['name']), "matches" => array()];

$teamarray = array();
$playoffteams = array();
while($curteam = $teamdata->fetch_assoc())
{
	if($curteam['position'] < $numteams)
	{
		if($curteam['phase'] == 0)
			$teamarray[$curteam['position']] = (object) ["name" => htmlentities($curteam['name']), "prelimbracket" => NULL, "playoffbracket" => NULL, "matches" => array()];
		else
			$playoffteams[$curteam['position']] = $curteam['name'];
	}
}

$phasepairings = array_fill(0, count($teamarray), 99);
foreach($playoffteams as $playoffid => $curplayoff)
{
	foreach($teamarray as $prelimid => $curprelim)
	{
		$teamname = $curprelim->name;
		if(trim($teamname) == trim($curplayoff))
		{
			$phasepairings[$playoffid] = $prelimid;
			break;
		}
	}
}

$maxrounds = $template['rounds'];
$roundarray = array();
for($i = 1 ; $i <= $maxrounds; $i++)
	$roundarray[$i] = array();

$hasbrackets = ($template['brackets'] > 1);
$templateurl = $template['url'];
$filetext = file_get_contents("$rootpath/$tournament");

if($hasbrackets)
	preg_match_all("/<h3 class=\"(\w+)bracket(\d+)\".*<thead>(.+)<\/thead>.*<tbody>(.+)<\/tbody>/Us", $filetext, $bracketgrep, PREG_SET_ORDER);
else
{
	$playoffbrackets[$curbracket['position']] = (object) ["name" => $curbracket['name'], "matches" => array()];
	preg_match_all("/()()<thead>(.+)<\/thead>.*<tbody>(.+)<\/tbody>/Us", $filetext, $bracketgrep, PREG_SET_ORDER);
}
foreach($bracketgrep as $num => $brackettext)
{
	$isplayoffs = ($hasbrackets ? ($brackettext[1] == "playoff") : $num == 1);
	$bracketnum = ($hasbrackets ? $brackettext[2] : 0);
	preg_match_all("/room(\d+)/", $brackettext[3], $temp, PREG_PATTERN_ORDER);
	$roomorder = $temp[1];
	$roundtext = explode("\n", trim($brackettext[4]));

	foreach($roundtext as $curround)
	{
		preg_match("/round'>(\d+)/", $curround, $temp);
		$roundnum = $temp[1];
		if($isplayoffs)
			$bracketarray->playoffs[$bracketnum]->matches[$roundnum] = array();
		else
			$bracketarray->prelims[$bracketnum]->matches[$roundnum] = array();

		preg_match_all("/<td>.*team(\d+)'.*team(\d+)'.*<\/td>/U", $curround, $matchtext, PREG_SET_ORDER);
		for($i = 0; $i < count($roomorder); $i++)
		{
			$curmatch = $matchtext[$i];
			$curroom = $roomorder[$i];
			$team1 = $curmatch[1];
			$team2 = $curmatch[2];

			if($team1 >= 99 && $team2 >= 99)
				continue;
			
			if($isplayoffs)
			{
				$team1 = $phasepairings[$team1];
				$team2 = $phasepairings[$team2];
				if($team1 < 99)
					$teamarray[$team1]->playoffbracket = $bracketnum;
				if($team2 < 99)
					$teamarray[$team2]->playoffbracket = $bracketnum;
				$bracketarray->playoffs[$bracketnum]->matches[$roundnum][] = (object) ["room" => $curroom, "teams" => [$team1, $team2]];
			}
			else
			{
				$teamarray[$team1]->prelimbracket = $bracketnum;
				$teamarray[$team2]->prelimbracket = $bracketnum;
				$bracketarray->prelims[$bracketnum]->matches[$roundnum][] = (object) ["room" => $curroom, "teams" => [$team1, $team2]];
			}
			
			if($team1 < 99)
				$teamarray[$team1]->matches[$roundnum] = (object) ["room" => $curroom, "opponent" => $team2];
			if($team2 < 99)
				$teamarray[$team2]->matches[$roundnum] = (object) ["room" => $curroom, "opponent" => $team1];
			$roomarray[$curroom]->matches[$roundnum] = [$team1, $team2];
			$roundarray[$roundnum][] = (object) ["bracket" => $bracketnum, "room" => $curroom, "teams" => [$team1, $team2]];
		}
	}
}
$output = ["teams" => $teamarray, "rooms" => $roomarray, "rounds" => $roundarray, "brackets" => $bracketarray];
echo(json_encode($output));
?>
