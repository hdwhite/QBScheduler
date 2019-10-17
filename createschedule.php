<?php
require_once("dbnames.inc");
require_once($_dbconfig);

$tournamentid = $_POST['tournamentid'];
$editcode = $_POST['hash'];
$tournamentname = addslashes(trim($_POST['name']));
$numteams = $_POST['numTeams'];
$format = $_POST[$numteams . 'teamschedules'];
$prelimbrackets = array();
$teamlist = array();
$playofflist = array();
for($i = 0; $i < 8; $i++)
{
	$prelimbrackets[$i] = $_POST['prelimBracket' . $i];
	$teamlist[$i] = explode("\n", $_POST['teams' . $i]);
}
$roomlist = explode("\n", $_POST['rooms']);
$numfinals = $_POST['finals'];
$submit = $_POST['submit'];
if($submit != "Generate")
	exit();

$formatdetails = $mysqli->query("SELECT * FROM $_templatedb WHERE url='$format'")->fetch_assoc();
$formatid = $formatdetails['id'];
$numprelims = $formatdetails['brackets'];
$numplayoffs = $formatdetails['playoffbrackets'];
$playoffformat = explode(",", $formatdetails['playofflist']);

if($tournamentid > 0)
{
	for($i = 0; $i < 8; $i++)
	{
		$playoffbrackets[$i] = $_POST['playoffBracket' . $i];
		$playofflist[$i] = explode("\n", $_POST['playoffteams' . $i]);
	}
	$scheduleinfo = $mysqli->query("SELECT * FROM $_scheduledb WHERE id=$tournamentid")->fetch_assoc();
	if(is_null($scheduleinfo))
		exit();
	$bracketdata = $mysqli->query("SELECT * FROM $_bracketdb WHERE tournament=$tournamentid");
	$roomdata = $mysqli->query("SELECT * FROM $_roomdb WHERE tournament=$tournamentid");
	$teamdata = $mysqli->query("SELECT * FROM $_teamdb WHERE tournament=$tournamentid");
	if($scheduleinfo['editcode'] != $editcode)
		exit();
	$schedulestmt = $mysqli->prepare("UPDATE $_scheduledb SET name = ?, format = ?, finals = ? WHERE id=$tournamentid");
	$schedulestmt->bind_param("sii", $tournamentname, $formatid, $numfinals);
	$schedulestmt->execute();
	$mysqli->query("DELETE FROM $_bracketdb WHERE tournament=$tournamentid");
	$mysqli->query("DELETE FROM $_roomdb WHERE tournament=$tournamentid");
	$mysqli->query("DELETE FROM $_teamdb WHERE tournament=$tournamentid");
}
else
{
	$playofflist = array_fill(0, 8, array());
	$playoffbrackets = explode("\n", $_POST['playoffBrackets']);
	$editcode = substr(md5(json_encode($_POST) . microtime()), 0, 8);
	$schedulestmt = $mysqli->prepare("INSERT INTO $_scheduledb (name, format, finals, editcode) VALUES(?, ?, ?, ?)");
	$schedulestmt->bind_param("siis", $tournamentname, $formatid, $numfinals, $editcode);
	$schedulestmt->execute();
	$tournamentid = $mysqli->insert_id;
}
$bracketstmt = $mysqli->prepare("INSERT INTO $_bracketdb (name, tournament, phase, position) VALUES(?, ?, ?, ?)");
$bracketstmt->bind_param("siii", $bracketname, $tournamentid, $phase, $position);
$teamstmt = $mysqli->prepare("INSERT INTO $_teamdb (name, tournament, phase, bracket, position) VALUES(?, ?, ?, ?, ?)");
$teamstmt->bind_param("siiii", $teamname, $tournamentid, $phase, $bracketnum, $teamposition);
$phase = 0;
$teamposition = 0;
for($position = 0; $position < $numprelims; $position++)
{
	if($numprelims > 1)
		$bracketname = addslashes(trim($prelimbrackets[$position]));
	else
		$bracketname = NULL;
	$bracketstmt->execute();
	$bracketnum = $mysqli->insert_id;
	
	for($i = 0; $i < count($teamlist[$position]); $i++)
	{
		$teamname = addslashes(trim($teamlist[$position][$i]));
		$teamstmt->execute();
		$teamposition++;
	}
}
if($numplayoffs > 1)
{
	$phase = 1;
	$bracketstart = 0;
	for($position = 0; $position < $numplayoffs; $position++)
	{
		$bracketname = addslashes(trim($playoffbrackets[$position]));
		$bracketstmt->execute();
		$bracketnum = $mysqli->insert_id;
		for($i = 0; $i < count($playofflist[$position]); $i++)
		{
			$teamposition = $bracketstart + $i;
			$teamname = addslashes(trim($playofflist[$position][$i]));
			$teamstmt->execute();
		}
		$bracketstart += $playoffformat[$position];
	}
}

$roomstmt = $mysqli->prepare("INSERT INTO $_roomdb (name, tournament, position) VALUES(?, ?, ?)");
$roomstmt->bind_param("sii", $roomname, $tournamentid, $position);
for($position = 0; $position < count($roomlist); $position++)
{
	$roomname = addslashes(trim($roomlist[$position]));
	$roomstmt->execute();
}
header("Location: $tournamentid/edit/$editcode");
exit;
?>
