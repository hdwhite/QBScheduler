<?php
$bracketparams = array();
$bracketparams['numteams'] = 4;
$bracketparams['iterations'] = 3;
?>
<div class="scontainer">
	<div class="name">
		<h2 class="tourneyname">&nbsp;</h2>
	</div>
	<div class="phase">
		<div class="phaseheader">
			<h2>Schedule</h2>
		</div>
		<div class="schedule center">
			<?php echo(createBracket($bracketparams)); ?>
		</div>
	</div>
	<div class="instruction">
		<p>Teams will play every other team three times, for a nine-game triple round-robin. After the final game, the champion will be detrmined as follows:</p>
		<ul>
			<li class="finals2 finals3" style="display:none">If the first-place team has two or more wins than every other team, then that team wins the tournament outright without the need for a final.</li>
			<li class="finals1" style="display:none">If there is a single team with the best record, then that team wins the tournament outright without the need for a final.</li>
			<li class="finals1 finals2 finals3" style="display:none">If there is a two-way tie for first, those teams would play in a one-game final. If there is a tie of three or more teams, those teams will play a series of single-elimination matches, seeded by points per game.</li>
			<li class="finals2" style="display:none">If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then entry into the finals will be broken by points per game.</li>
			<li class="finals3" style="display:none">If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then those teams will play each other to determine entry into the finals.</li>
		</ul>
	</div>
</div>
