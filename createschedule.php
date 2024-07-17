<?php
//This page does all the necessary backend work to get the given schedule
//created or edited, and then redirects the user to display the new schedule.
require_once("dbnames.inc");
require_once($_dbconfig);

//Turns all the POST data into variables
$tournamentid = isset($_POST['tournamentid']) ? $_POST['tournamentid'] : 0;
$editcode = isset($_POST['hash']) ? $_POST['hash'] : "";
$tournamentname = isset($_POST['name']) ? trim($_POST['name']) : "";
$numteams = isset($_POST['numTeams']) ? $_POST['numTeams'] : 0;
$format = isset($_POST[$numteams . 'teamschedules']) ? $_POST[$numteams . 'teamschedules'] : "";
$prelimbrackets = array();
$teamlist = array();
$playofflist = array();
for($i = 0; $i < 8; $i++)
{
	$prelimbrackets[$i] = isset($_POST['prelimBracket' . $i]) ? $_POST['prelimBracket' . $i] : "";
	$teamlist[$i] = isset($_POST['teams' . $i]) ? explode("\n", $_POST['teams' . $i]) : array();
}
$roomlist = isset($_POST['rooms']) ? explode("\n", $_POST['rooms']) : array();
$numfinals = isset($_POST['finals']) ? $_POST['finals'] : "";
$submit = isset($_POST['submit']) ? $_POST['submit'] : "";
if($submit != "Generate")
	exit();

//Gets the details of the particular format used
$formatdetails = $mysqli->query("SELECT * FROM $_templatedb WHERE url='$format'")->fetch_assoc();
$formatid = $formatdetails['id'];
$numprelims = $formatdetails['brackets'];
$numplayoffs = $formatdetails['playoffbrackets'];
$playoffformat = explode(",", $formatdetails['playofflist']);
//If there's a pre-existing tournament ID, that means we're editing a schedule
if($tournamentid > 0)
{
	//Playoff teams show differently if we're editing a schedule
	for($i = 0; $i < 8; $i++)
	{
		$playoffbrackets[$i] = $_POST['playoffBracket' . $i];
		$playofflist[$i] = explode("\n", $_POST['playoffteams' . $i]);
	}
	//We gotta make sure the schedule in question actually exists
	$scheduleinfo = $mysqli->query("SELECT * FROM $_scheduledb WHERE id=$tournamentid")->fetch_assoc();
	if(is_null($scheduleinfo))
		exit();
	//Just to make sure people who shouldn't be editing aren't editing
	if($scheduleinfo['editcode'] != $editcode)
		exit();
	//Update the existing entry while deleting the old bracket, room, and team info
	$curtime = date("Y-m-d H:i:s");
	$schedulestmt = $mysqli->prepare("UPDATE $_scheduledb SET name = ?, format = ?, finals = ?, updated = ? WHERE id=$tournamentid");
	$schedulestmt->bind_param("siis", $tournamentname, $formatid, $numfinals, $curtime);
	$schedulestmt->execute();
	$mysqli->query("DELETE FROM $_bracketdb WHERE tournament=$tournamentid");
	$mysqli->query("DELETE FROM $_roomdb WHERE tournament=$tournamentid");
	$mysqli->query("DELETE FROM $_teamdb WHERE tournament=$tournamentid");
}
//Meanwhile, for a new tournament
else
{
	$playofflist = array_fill(0, 8, array());
	$playoffbrackets = explode("\n", $_POST['playoffBrackets']);
	//TODO: Create a better editcode generation method
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
//We iterate through each of the prelim brackets
for($position = 0; $position < $numprelims; $position++)
{
	//No need for bracket names if there's only one
	if($numprelims > 1)
		$bracketname = trim($prelimbrackets[$position]);
	else
		$bracketname = NULL;
	$bracketstmt->execute();
	$bracketnum = $mysqli->insert_id;
	
	//Inserting all the teams within each bracket
	for($i = 0; $i < count($teamlist[$position]); $i++)
	{
		$teamname = trim($teamlist[$position][$i]);
		$teamstmt->execute();
		$teamposition++;
	}
}

//Don't need to do this if there aren't playoff brackets
if($numplayoffs > 1)
{
	$phase = 1;
	$bracketstart = 0;
	for($position = 0; $position < $numplayoffs; $position++)
	{
		$bracketname = trim($playoffbrackets[$position]);
		$bracketstmt->execute();
		$bracketnum = $mysqli->insert_id;
		for($i = 0; $i < count($playofflist[$position]); $i++)
		{
			$teamposition = $bracketstart + $i;
			$teamname = trim($playofflist[$position][$i]);
			$teamstmt->execute();
		}
		$bracketstart += $playoffformat[$position];
	}
}

//Inserting room info
$roomstmt = $mysqli->prepare("INSERT INTO $_roomdb (name, tournament, position) VALUES(?, ?, ?)");
$roomstmt->bind_param("sii", $roomname, $tournamentid, $position);
for($position = 0; $position < count($roomlist); $position++)
{
	$roomname = trim($roomlist[$position]);
	$roomstmt->execute();
}
header("Location: $tournamentid/edit/$editcode");
exit;
?>
