<?php
//This contains the Javascript logic for the schedule forms.
require_once("dbnames.inc");
require_once($_dbconfig);
require_once("templates/brackets.php");
//Here we get the information of all of the formats and store them in arrays
//It's of the form $schedulelist[<Field Size>][<Format name>].
$schedulequery = $mysqli->query("SELECT * FROM $_templatedb " .
	"ORDER BY teams ASC, games ASC, rounds ASC") or die($mysqli->error);
$schedulelist = array();
while($sdetail = $schedulequery->fetch_assoc())
	if($sdetail['id'] > 0)
		$schedulelist[$sdetail['teams']][$sdetail['url']] = array(
			"description" => $sdetail['description'] . " (" . $sdetail['rounds'] . " rounds" .
			($sdetail['games'] == $sdetail['rounds'] ? "" : ", " . $sdetail['games'] . " games minimum") .")",
			"rounds" => $sdetail['rounds'],
			"rooms" => $sdetail['rooms'],
			"brackets" => $sdetail['brackets'],
			"playoffbrackets" => $sdetail['playoffbrackets'],
			"playofflist" => $sdetail['playofflist'],
			"finalstype" => $sdetail['finalstype']);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/analytics.php"); ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script>
			//I dunno why, but this extra line of comments makes the Vim syntax
			//highlihting work more reliably.
			<?php
				$prelimBrackets = array();
				$playoffBrackets = array();
				$playoffBracketSize = array();
				//Splitting all the format info into separate arrays
				foreach($schedulelist as $teamschedulelist)
					foreach($teamschedulelist as $surl => $sdetails)
					{
						$prelimBrackets[$surl] = $sdetails['brackets'];
						$playoffBrackets[$surl] = $sdetails['playoffbrackets'];
						$rounds[$surl] = $sdetails['rounds'];
						$rooms[$surl] = $sdetails['rooms'];
						$playoffBracketSize[$surl] = $sdetails['playofflist'];
						$finalstype[$surl] = $sdetails['finalstype'];
					}
			?>
			//Initializing variables and transferring PHP to Javascript variables
			var timeout = null;
			var prelimBrackets = <?=json_encode($prelimBrackets) ?>;
			var playoffBrackets = <?=json_encode($playoffBrackets) ?>;
			var numRounds = <?=json_encode($rounds) ?>;
			var numRooms = <?=json_encode($rooms) ?>;
			var playoffSize = <?=json_encode($playoffBracketSize) ?>;
			var finalsType = <?=json_encode($finalstype) ?>;
			var teamList = [];
			var playoffTeamList = [];
			var roomList = [];
			var playoffBracketList = [];
			var numTeams = 0;
			var numPackets = 0;
			var url;

			//Magic goes here
			$(document).ready(function()
			{
				//The update functions can be called on load if we're editing
				//a tournament, so we split it into two functions
				$('#numTeams').change(function()
				{
					numTeams = $(this).val();
					updateNumTeams();
				});
				
				//Here we hide the rest of the form and show the appropriate
				//choices for all format options for the given number of teams
				function updateNumTeams()
				{
					div = $('#' + numTeams + "teamformat");
					$('.format').hide();
					if(numTeams != "Teams")
						$('#formatpreface').show();
					div.show();
					$('.teamform').hide();
					$('.roomblock').hide();
					$('.formatbox').prop('checked', false);
					$('.formatbox').prop('required', false);
					$('#' + numTeams + 'teamformat > input').each(function() { $(this).prop('required', true); });
					$('.schedulecontent').hide();
				}

				//Once we update the format, we have to do a lot of stuff
				$('.formatbox').change(function()
				{
					url = $(this).attr('id');
					updateFormat();
				});
				function updateFormat()
				{
					//Here we get all the teams (and possibly playoff teams) and
					//Store them into arrays for now
					for (i = 7; i >= 0; i--)
					{
						teamList = $('#teams' + i).val().split('\n').concat(teamList);
						$('#teams' + i).val('');
						<?php if($mode === "edit") { ?>
						playoffTeamList = $('#playoffteams' + i).val().split('\n').concat(playoffTeamList);
						$('#playoffteams' + i).val('');
						<?php } ?>
					}
					//Removing empty elements form the arrays
					teamList = teamList.filter(function(e){return e});
					playoffTeamList = playoffTeamList.filter(function(e){return e});

					//Show all the necessary bits
					$('.teamform').show();
					$('#teampreface').show();
					$('#teamtable').show();
					$('.roomblock').show();
					$('.finals').prop('checked', false);
					$('.finalsformat').hide();
					numPackets = parseInt(numRounds[url]);
					numPlayoffBrackets = playoffBrackets[url];

					//If there are no playoff brackets, then we are using a
					//single-elimination format. (Might probably be unneeded.)
					if (numPlayoffBrackets == 0)
					{
						$('#singleelim').show();
						$('#numpackets').html(numPackets);
						$('#packets').show();
						$('.finals').prop('required', false);
						$('.playoffBrackets').hide();
						$('#playoffBrackets').attr('required', false);
					}
					else
					{
						//Finals type of 0: A single top bracket
						//Finals type of 1: Two parallel top brackets
						if(finalsType[url] == 0)
							$('#rrfinals').show();
						else if(finalsType[url] == 1)
							$('#crossfinals').show();
						$('#packets').hide();
						$('.finals').prop('required', true);

						//Gotta show the right number of playoff brackets if they exist
						if(numPlayoffBrackets > 1)
						{
							$('.playoffBrackets').show();
							$('#playoffBrackets').attr('rows', playoffBrackets[url]);
							$('#playoffBrackets').attr('required', true);
							bracketSizes = playoffSize[url].split(",");
							for (i = 0; i < 8; i++)
							{
								$('#playoffBracket' + i).hide();
								$('#playoffteams' + i).hide();
							}
							for (i = 0; i < numPlayoffBrackets; i++)
							{
								$('#playoffBracket' + i).show();
								$('#playoffteams' + i).show();
								curSize = bracketSizes[i];
								$('#playoffteams' + i).attr('rows', curSize);
								//Put all the teams in the brackets
								$('#playoffteams' + i).val(playoffTeamList.slice(0, curSize).join('\n'));
								playoffTeamList = playoffTeamList.slice(curSize);
							}
						}
						else
						{
							$('.playoffBrackets').hide();
							$('#playoffBrackets').attr('required', false);
						}
					}
					$('#rooms').attr('rows', numRooms[url]);

					//Now we do the same thing with prelim brackets
					var numPrelimBrackets = prelimBrackets[url];
					var numRows = Math.floor(numTeams / numPrelimBrackets);
					var extras = numTeams % numPrelimBrackets;
					for (i = 0; i < 8; i++)
					{
						$('#prelimBracket' + i).hide();
						$('#teams' + i).hide();
						$('#prelimBracket' + i).prop('required', false);
						$('#teams' + i).prop('required', false);
					}
					for (i = 0; i < numPrelimBrackets; i++)
					{
						var tempRows;
						$('#prelimBracket' + i).show();
						$('#teams' + i).show();
						$('#prelimBracket' + i).prop('required', true);
						$('#teams' + i).prop('required', true);
						if(extras > i)
							tempRows = numRows + 1;
						else
							tempRows = numRows;
						$('#teams' + i).attr('rows', tempRows);
						$('#teams' + i).val(teamList.slice(0, tempRows).join('\n'));
						teamList = teamList.slice(tempRows);
					}

					//Don't need to show bracket names if there's only one
					if (numPrelimBrackets == 1)
					{
						$('#prelimBracket0').hide();
						$('#prelimBracket0').prop('required', false);
						$('#bpreface').hide();
					}
					else
						$('#bpreface').show();

					$('.schedulecontent').hide();
					$('#' + url + 'content').show();
					updateTeams();
				}

				//Updating finals format is easy. Just gotta update the number
				//of packets and the text describing the finals.
				$('.finals').change(function()
				{
					updateFinals(parseInt($(this).attr('value')));
				});
				function updateFinals(finalsFormat)
				{
					numPackets = parseInt(numRounds[url]) + finalsFormat;
					$('#numpackets').html(numPackets);
					$('#packets').show();
					for (i = 0; i < 4; i++)
					{
						$('.finals' + i).hide();
						$('.finals' + i).hide();
					}
					if(finalsType[url] == 0)
						$('.finals' + finalsFormat).show();
					else if(finalsType[url] == 1)
						$('.finals' + finalsFormat).show();
				}

				//Updating the name. Easy enough.
				$('#tournamentname').on('input', function()
				{
					updateTourneyName($('#tournamentname').val());
				});
				function updateTourneyName(tourneyName)
				{
					$('.tourneyname').text(tourneyName);
				}

				//Updating rooms is also easy, but we wait until there's been no
				//activity for 0.5 second to prevent lag from updating too quickly 
				$('#rooms').on('input', function()
				{
					roomList = $('#rooms').val().split('\n');
					clearTimeout(timeout)
					timeout = setTimeout(function() { updateRooms(); }, 500);
				});
				function updateRooms()
				{
					for (i = 0; i < roomList.length; i++)
						$('.room' + i).text(roomList[i]);
				}

				//We do the same timeout check with team names
				$('.teaminput').on('input', function()
				{
					clearTimeout(timeout)
					timeout = setTimeout(function() { updateTeams(); }, 500);
				});
				function updateTeams()
				{
					//We need to clear the team names first, in case a row has
					//been deleted
					for (i = 0; i < numTeams; i++)
					{
						$('.team' + i).text('');
						$('.playoffteam' + i).text('');
					}

					teamList = [];
					playoffTeamList = [];
					var curteamid = 0;
					//We go through each bracket and display the new team names
					for (i = 0; i < 8; i++)
					{
						teamList = $('#teams' + i).val().split('\n');
						//It's important to know how big the bracket is
						numTeamsInBracket = parseInt($('#teams' + i).attr('rows'));
						$('.prelimbracket' + i).text($("#prelimBracket" + i).val() + '\xa0');
						//We keep adding teams to the bracket until it fills up
						for (j = 0; j < teamList.length; j++)
						{
							if (j == numTeamsInBracket)
								break;
							$('.team' + (curteamid + j)).text(teamList[j]);
						}
						//Used if the number of teams entered is less than the bracket size
						curteamid = curteamid + numTeamsInBracket;
					}

					//And now we do the same for playoff teams
					var curteamid = 0;
					for (i = 0; i < 8; i++)
					{
						playoffTeamList = $('#playoffteams' + i).val().split('\n');
						numTeamsInBracket = parseInt($('#playoffteams' + i).attr('rows'));
						$('.playoffbracket' + i).text($("#playoffBracket" + i).val() + '\xa0');
						for (j = 0; j < playoffTeamList.length; j++)
						{
							if (j == numTeamsInBracket)
								break;
							$('.playoffteam' + (curteamid + j)).text(playoffTeamList[j]);
						}
						curteamid = curteamid + numTeamsInBracket;
					}
				}

				//You get the drill now
				$('#playoffBrackets').on('input', function()
				{
					clearTimeout(timeout)
					timeout = setTimeout(function() { updatePlayoffBrackets(); }, 500);
				});
				function updatePlayoffBrackets()
				{
					playoffBracketList = $('#playoffBrackets').val().split('\n');
					for (i = 0; i < playoffBracketList.length; i++)
						$('.playoffbracket' + i).text(playoffBracketList[i] + '\xa0');
				}

				//Gonna be honest, I'm not quite sure why this is here.
				//I think it might have been from an earlier design.
				<?php if(isset($_POST['numTeams'])) { ?>
					var startTeams = <?=$_POST['numTeams'] ?>;
					var startUrl = "<?=$_POST[$_POST['numTeams'] . "teamschedules"] ?>";
					$('#numTeams').val(startTeams).trigger("change");
					$('#' + startUrl).prop('checked', true).trigger("change");
					<?php if(isset($_POST['finals'])) { ?>
						$('#<?=$_POST['finals'] ?>').prop('checked', true).trigger("change");
				<?php }} ?>
				
				//If you're editing, you need to prefill the fields
				<?php if($mode === "edit") { ?>
					//Tournament name
					tname = <?=json_encode($tourneyname) ?>;
					document.title = "Editing " + tname;
					$('#headername').text(tname);

					//Number of teams
					$('#numTeams').val(<?=$formatteams ?>);
					numTeams = <?=$formatteams ?>;
					updateNumTeams();

					//Specific tournament format
					$('#<?=$formatcode ?>').prop("checked", true);
					url = '<?=$formatcode ?>';
					updateFormat();
					<?php if($numfinals > 0) { 
						if($formatfinals == 0) { ?>
							$('#rrfinals<?=$numfinals ?>').prop("checked", true);
						<?php } elseif($formatfinals == 1) { ?>
							$('#crossfinals<?=$numfinals ?>').prop("checked", true);
						<?php } ?>
						updateFinals(<?=$numfinals ?>);
					<?php } ?>

					//Tournament name
					updateTourneyName(tname);

					//Room names
					$('#rooms').val(<?=json_encode($roomlist) ?>.join("\n"));
					roomList = <?=json_encode($roomlist) ?>;
					updateRooms();

					//Team names
					<?php for($i = 0; $i < count($bracketdata); $i++) { ?>
						$('#teams<?=$i ?>').val(<?=json_encode($bracketdata[$i]) ?>.join("\n"));
					<?php } ?>

					//Prelim bracket names
					<?php foreach($prelimbracketnames as $sequence => $name) { ?>
						$('#prelimBracket<?=$sequence ?>').val(<?=json_encode($name) ?>);
					<?php } ?>

					//Playoff team names
					<?php for($i = 0; $i < count($playoffbracketdata); $i++) { ?>
						$('#playoffteams<?=$i ?>').val(<?=json_encode($playoffbracketdata[$i]) ?>.join("\n"));
					<?php } ?>

					//Playoff bracket names
					<?php foreach($playoffbracketnames as $sequence => $name) { ?>
						$('#playoffBracket<?=$sequence ?>').val(<?=json_encode($name) ?>);
					<?php } ?>

					updateTeams();
					$('#playoffBrackets').val(<?=json_encode($playoffbracketnames) ?>.join("\n"));
					updatePlayoffBrackets();
				<?php } ?>
			});
		</script>
		<style type="text/css">
			@import url("/harry.css");
			@import url("/harrybig.css");
			@import url("/qb/schedules/schedules.css");
			@import url("/qb/schedules/print.css") print;
		</style>
		<title>Quizbowl Schedule Generator</title>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h2 id="headername">Quizbowl Schedule Generator</h2>
				<?php include("header.php"); ?>
			</div>
