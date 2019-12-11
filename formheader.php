<?php
require_once("dbnames.inc");
require_once($_dbconfig);
require_once("templates/brackets.php");
$schedulequery = $mysqli->query("SELECT * FROM $_templatedb " .
	"ORDER BY teams ASC, games ASC, rounds ASC") or die($mysqli->error);
$schedulelist = array();
while($sdetail = $schedulequery->fetch_assoc())
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
			<?php
				$prelimBrackets = array();
				$playoffBrackets = array();
				$playoffBracketSize = array();
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
			$(document).ready(function()
			{
				$('#numTeams').change(function()
				{
					numTeams = $(this).val();
					updateNumTeams();
				});
				
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


				$('.formatbox').change(function()
				{
					url = $(this).attr('id');
					updateFormat();
				});

				function updateFormat()
				{
					for (i = 7; i >= 0; i--)
					{
						teamList = $('#teams' + i).val().split('\n').concat(teamList);
						$('#teams' + i).val('');
						<?php if($mode === "edit") { ?>
						playoffTeamList = $('#playoffteams' + i).val().split('\n').concat(playoffTeamList);
						$('#playoffteams' + i).val('');
						<?php } ?>
					}
					teamList = teamList.filter(function(e){return e});
					playoffTeamList = playoffTeamList.filter(function(e){return e});
					numPackets = parseInt(numRounds[url]);
					$('.teamform').show();
					$('#teampreface').show();
					$('#teamtable').show();
					$('.roomblock').show();
					$('.finals').prop('checked', false);
					$('.finalsformat').hide();
					numPlayoffBrackets = playoffBrackets[url];
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
						if(finalsType[url] == 0)
							$('#rrfinals').show();
						else if(finalsType[url] == 1)
							$('#crossfinals').show();
						$('#packets').hide();
						$('.finals').prop('required', true);
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

				$('#tournamentname').on('input', function()
				{
					updateTourneyName($('#tournamentname').val());
				});

				function updateTourneyName(tourneyName)
				{
					$('.tourneyname').text(tourneyName);
				}

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

				$('.teaminput').on('input', function()
				{
					clearTimeout(timeout)
					timeout = setTimeout(function() { updateTeams(); }, 500);
				});

				function updateTeams()
				{
					for (i = 0; i < numTeams; i++)
					{
						$('.team' + i).text('');
						$('.playoffteam' + i).text('');
					}
					teamList = [];
					playoffTeamList = [];
					var curteamid = 0;
					for (i = 0; i < 8; i++)
					{
						teamList = $('#teams' + i).val().split('\n');
						numTeamsInBracket = parseInt($('#teams' + i).attr('rows'));
						$('.prelimbracket' + i).text($("#prelimBracket" + i).val() + '\xa0');
						for (j = 0; j < teamList.length; j++)
						{
							if (j == numTeamsInBracket)
								break;
							$('.team' + (curteamid + j)).text(teamList[j]);
						}
						curteamid = curteamid + numTeamsInBracket;
					}

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

				<?php if(isset($_POST['numTeams'])) { ?>
					var startTeams = <?=$_POST['numTeams'] ?>;
					var startUrl = "<?=$_POST[$_POST['numTeams'] . "teamschedules"] ?>";
					$('#numTeams').val(startTeams).trigger("change");
					$('#' + startUrl).prop('checked', true).trigger("change");
					<?php if(isset($_POST['finals'])) { ?>
						$('#<?=$_POST['finals'] ?>').prop('checked', true).trigger("change");
				<?php }} ?>
				
				<?php if($mode === "edit") { ?>
					tname = <?=json_encode($tourneyname) ?>;
					document.title = "Editing " + tname;
					$('#headername').text(tname);
					$('#numTeams').val(<?=$formatteams ?>);
					numTeams = <?=$formatteams ?>;
					updateNumTeams();
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
					updateTourneyName(tname);
					$('#rooms').val(<?=json_encode($roomlist) ?>.join("\n"));
					roomList = <?=json_encode($roomlist) ?>;
					updateRooms();
					<?php for($i = 0; $i < count($bracketdata); $i++) { ?>
						$('#teams<?=$i ?>').val(<?=json_encode($bracketdata[$i]) ?>.join("\n"));
					<?php } ?>
					<?php foreach($prelimbracketnames as $sequence => $name) { ?>
						$('#prelimBracket<?=$sequence ?>').val(<?=json_encode($name) ?>);
					<?php } ?>
					<?php for($i = 0; $i < count($playoffbracketdata); $i++) { ?>
						$('#playoffteams<?=$i ?>').val(<?=json_encode($playoffbracketdata[$i]) ?>.join("\n"));
					<?php } ?>
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
