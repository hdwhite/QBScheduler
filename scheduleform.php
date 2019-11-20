<?php if($mode === "edit") { ?>
<div class="entry">
	<h4>You are in edit mode</h4>
	<p>Anyone who has access to this URL can edit your tournament schedule at will. Please only share this page with people whom you trust. Save this URL, as it is the only way to edit a schedule without having to create a new one from scratch.</p>
	<p>Your sharable online schedule can be found at <a href="http://hdwhite.org/qb/schedules/<?=$tournamentid ?>">http://hdwhite.org/qb/schedules/<?=$tournamentid ?></a>.</p>
</div>
<?php } ?>
<div class="entry">
	<h4>Welcome to the Quizbowl Schedule Generator</h4>
	<p>The Quizbowl Schedule Generator allows you to create and edit schedules for high school and college tournaments. Simply fill in the relevant information in the form below, watch the schedule appear in real time, and click on Generate to create an online schedule that you can share to your teams and rooms. You will also be able to edit schedules to include playoffs or to accommodate last-minute signups or drops.</p><br>
	<p><b>This tool is still in development.</b> I hope no bugs made it to production, but if you find anything wrong, even if it's as simple as a typo or a wrong round number, please either <a href="https://github.com/hdwhite/QBScheduler/issues">create an issue on Github</a>, <a href="mailto:contact@hdwhite.org">email me</a>, or <a href="https://hsquizbowl.org/forums/viewtopic.php?f=123&t=23356">post on the HSQuizbowl Forums</a> so I can work on fixing it.</p><br>
	<p>If you are running a tournament, I would highly suggest reading through Chris Chiego's <a href="https://socalquizbowl.org/tournament-hosting-guide/">tournament hosting guide</a>. It contains very detailed instructions on hosting and best practices.</p><br>
	<p>Not sure how a certain aspect of the schedule works? Feel free to browse the <a href="faq">FAQ</a>.</p>
</div>
<div class="entry">
	<form action="/qb/schedules/createschedule.php" method="post">
		<input type="hidden" id="tournamentid" name="tournamentid" value="<?=$tournamentid; ?>">
		<input type="hidden" id="hash" name="hash" value="<?=$editcode; ?>">
		<p><b>Tournament name:</b> <input type="text" name="name" id="tournamentname" value="<?=$tourneyname ?>" required></p>
		<p><b>Number of teams:</b> 
		<select name="numTeams" id="numTeams" required>
			<option value="">Teams</option>
			<?php
				foreach($schedulelist as $numteams => $teamschedulelist)
					echo("<option value='$numteams'>$numteams</option>\n");
			?>
		</select></p>
		<div id="formatpreface" class="format" style="display:none;">
			<p><b>Select a tournament format:</b></p>
		</div>
		<?php
			foreach ($schedulelist as $numteams => $teamschedulelist)
			{
				echo("<div id='$numteams" . "teamformat' class='format' style='display:none;'>\n");
				foreach ($teamschedulelist as $surl => $sdetails)
					echo("<input type='radio' name='$numteams" . "teamschedules' id='$surl' value='$surl' class='formatbox'>" . $sdetails['description'] . "<br>\n");
				echo("</div>\n");
			}
		?>
		<div class="teamform" style="display:none;">
			<div id="teampreface">
				<br><p><b>Team<span id="bpreface"> and bracket</span> names:</b></p>
			</div>
			<table id="teamtable">
				<tr>
					<?php for($i = 0; $i < 4; $i++) echo("<td><input type='text' name='prelimBracket$i' id='prelimBracket$i' class='teaminput' placeholder='Bracket name' style='width:185px; display:none;'></td>"); ?>
				</tr>
				<tr>
					<?php for($i = 0; $i < 4; $i++) echo("<td style='vertical-align:top;'><textarea name='teams$i' id='teams$i' class='teaminput' placeholder='Team names (one per line)' rows='8' style='width:185px; display:none; overflow:hidden;'></textarea></td>"); ?>
				</tr>
				<tr>
					<?php for($i = 4; $i < 8; $i++) echo("<td><input type='text' name='prelimBracket$i' id='prelimBracket$i' class='teaminput' placeholder='Bracket name' style='width:185px; display:none;'></td>"); ?>
				</tr>
				<tr>
					<?php for($i = 4; $i < 8; $i++) echo("<td style='vertical-align:top;'><textarea name='teams$i' id='teams$i' class='teaminput' placeholder='Team names (one per line)' rows='8' style='width:185px; display:none; overflow:hidden;'></textarea></td>"); ?>
				</tr>
			</table>
			<div class="playoffBrackets" style="display:none;">
				<?php if($mode === "edit") { ?>
				<p><b>Playoff team and bracket names:</b></p>
				<table id="playofftable">
					<tr>
						<?php for($i = 0; $i < 4; $i++) echo("<td><input type='text' name='playoffBracket$i' id='playoffBracket$i' class='teaminput' placeholder='Bracket name' style='width:185px; display:none;'></td>"); ?>
					</tr>
					<tr>
						<?php for($i = 0; $i < 4; $i++) echo("<td style='vertical-align:top;'><textarea name='playoffteams$i' id='playoffteams$i' class='teaminput' placeholder='Team names (one per line)' rows='8' style='width:185px; display:none; overflow:hidden;'></textarea></td>"); ?>
					</tr>
					<tr>
						<?php for($i = 4; $i < 8; $i++) echo("<td><input type='text' name='playoffBracket$i' id='playoffBracket$i' class='teaminput' placeholder='Bracket name' style='width:185px; display:none;'></td>"); ?>
					</tr>
					<tr>
						<?php for($i = 4; $i < 8; $i++) echo("<td style='vertical-align:top;'><textarea name='playoffteams$i' id='playoffteams$i' class='teaminput' placeholder='Team names (one per line)' rows='8' style='width:185px; display:none; overflow:hidden;'></textarea></td>"); ?>
					</tr>
				</table>
				<p>Playoff brackets are sequentially ordered such that the top bracket is on the left. Within each playoff bracket, it is important that all teams from a given prelim bracket are listed next to each other.</p>
				<?php } else { ?>
				<p><b>Playoff bracket names:</b></p>
				<textarea type="text" name="playoffBrackets" id="playoffBrackets" placeholder="Playoff bracket names (one per line)" rows="2" style="width:185px; overflow:hidden;"></textarea>
				<?php } ?>
			</div>
		</div>
		<div id="roomblock" class="roomblock" style="display:none;">
			<p><b>Rooms:</b></p>
			<textarea name="rooms" id="rooms" rows="8" style="width:185px;" required></textarea><br>
		</div>
		<div id="rrfinals" class="roomblock finalsformat" style="display:none;">
			<br><p><b>Number of finals matches:</b></p>
			<input type="radio" name="finals" class="finals" id="rrfinals1" value="1">1 (Run a finals match only if the top two teams have equal records.)<br>
			<input type="radio" name="finals" class="finals" id="rrfinals2" value="2">2 (The above, plus advantaged finals if the top two teams are separated by one game.)<br>
			<input type="radio" name="finals" class="finals" id="rrfinals3" value="3">3 (The above, plus play-in matches if there is a tie for second place.)<br>
		</div>
		<div id="crossfinals" class="roomblock finalsformat" style="display:none;">
			<br><p><b>Number of finals matches:</b></p>
			<input type="radio" name="finals" class="finals" id="crossfinals1" value="1">1 (The top team from each of the two top brackets play in a one-game finals.)<br>
			<input type="radio" name="finals" class="finals" id="crossfinals2" value="2">2 (The top two teams from each of the top two brackets play in a 4-team elimination bracket.)<br>
		</div>
		<div id="singleelim" class="roomblock finalsformat" style="display:none;">
			<br><p>This format features a single-elimination playoff.</p>
		</div>
		<div id="packets" class="roomblock" style="display:none;">
			<br><p>This tournament will require a minimum of <b><span id="numpackets"></span></b> packets. This does not include any tiebreaker or backup packets you might need.</p>
		<br>
		<input type="submit" name="submit" value="Generate">
	</div>
	</form>
</div>
<?php
	foreach ($schedulelist as $numteams => $teamschedulelist)
	{
		foreach ($teamschedulelist as $surl => $sdetails)
		{
			echo("<div id='" . $surl . "content' class='schedulecontent entry' style='display:none'>");
			include("templates/$surl.php");
			echo("</div>\n");
		}
	}
?>
