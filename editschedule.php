<?php
$urlarray = explode("/", $_SERVER['REQUEST_URI']);
$tournamentid = htmlentities($urlarray[3]);
$editcode = htmlentities($urlarray[5]);
$mode = "edit";
require_once("dbnames.inc");
require_once($_dbconfig);
$scheduleinfo = $mysqli->query("SELECT * FROM $_scheduledb WHERE id=$tournamentid")->fetch_assoc();
if(is_null($scheduleinfo))
	exit();
if($scheduleinfo['editcode'] !== $editcode)
	exit();

$formatinfo = $mysqli->query("SELECT * FROM $_templatedb WHERE id=" . $scheduleinfo['format'])->fetch_assoc();
$formatteams = $formatinfo['teams'];
$formatcode = $formatinfo['url'];
$numfinals = $scheduleinfo['finals'];
$tourneyname = $scheduleinfo['name'];
$playoffsizes = explode(",", $scheduleinfo['playofflist']);

$roomlist = Array();
$roominfo = $mysqli->query("SELECT * FROM $_roomdb WHERE tournament=$tournamentid ORDER BY position ASC");
while($curroom = $roominfo->fetch_assoc())
	$roomlist[] = $curroom['name'];

$bracketdata = array_fill(0, 8, Array());
$teaminfo = $mysqli->query("SELECT a.name AS tname, a.position AS tpos, b.position AS bpos FROM $_teamdb a JOIN $_bracketdb b ON a.bracket = b.id WHERE a.tournament = $tournamentid AND a.phase=0 ORDER BY tpos ASC");
while($curteam = $teaminfo->fetch_assoc())
	$bracketdata[$curteam['bpos']][] = $curteam['tname'];

$playoffbracketdata = array_fill(0, 8, Array());
$playoffteaminfo = $mysqli->query("SELECT a.name AS tname, a.position AS tpos, b.position AS bpos FROM $_teamdb a JOIN $_bracketdb b ON a.bracket = b.id WHERE a.tournament = $tournamentid AND a.phase=1 ORDER BY tpos ASC");
while($curteam = $playoffteaminfo->fetch_assoc())
	$playoffbracketdata[$curteam['bpos']][] = $curteam['tname'];

$prelimbracketnames = Array();
$playoffbracketnames = Array();
$bracketinfo = $mysqli->query("SELECT * FROM $_bracketdb WHERE tournament=$tournamentid");
while($curbracket = $bracketinfo->fetch_assoc())
	if($curbracket['phase'] == 0)
		$prelimbracketnames[$curbracket['position']] = $curbracket['name'];
	else
		$playoffbracketnames[$curbracket['position']] = $curbracket['name'];

$title = "Editing $tourneyname";
$headertext = "Editing a tournament";
require("formheader.php");
require("scheduleform.php");
require("footer.php");
?>
