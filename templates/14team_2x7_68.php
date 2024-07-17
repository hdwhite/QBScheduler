<?php
$bracketparams = array();
$bracketparams['numteams'] = 7;
?>
<div class="scontainer">
	<div class="name">
		<h2 class="tourneyname">&nbsp;</h2>
	</div>
	<div class="phase">
		<div class="phaseheader">
			<h2>Preliminary Rounds</h2>
		</div>
		<h3 class="prelimbracket0">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php echo(createBracket($bracketparams)); ?>
			</div>
		</div>
		<h3 class="prelimbracket1">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php 
				$bracketparams['teamoffset'] = 7;
				$bracketparams['roomoffset'] = 3;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into two brackets of 7, in which they will play a six-game round-robin. Afterwards, the teams will be placed into playoff brackets of 6 and 8 teams, respectively, based on their performance in the preliminary rounds. Teams in the top bracket will play a full round-robin within their new bracket, while the teams in the bottom bracket will play the four teams in their bracket that they have yet to play. Only games played against teams in the same playoff bracket will count towards final standing within each bracket. Finals in the top bracket will be played according to the following criteria:</p>
		<ul>
			<li class="finals2 finals3" style="display:none">If the first-place team has two or more wins than every other team, then that team wins the tournament outright without the need for a final.</li>
			<li class="finals1" style="display:none">If there is a single team with the best record, then that team wins the tournament outright without the need for a final.</li>
			<li class="finals1 finals2 finals3" style="display:none">If there is a two-way tie for first, those teams would play in a one-game final. If there is a tie of three or more teams, those teams will play a series of single-elimination matches, seeded by points per game.</li>
			<li class="finals2" style="display:none">If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then entry into the finals will be broken by points per game.</li>
			<li class="finals3" style="display:none">If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then those teams will play each other to determine entry into the finals.</li>
		</ul>
	</div>
	<div class="pagebreak">
		<div class="name">
			<h2 class="tourneyname">&nbsp;</h2>
		</div>
	</div>
	<div class="phase">
		<div class="phaseheader">
			<h2>Playoff Rounds</h2>
		</div>
		<h3 class="playoffbracket0">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php 
				$bracketparams['numteams'] = 6;
				$bracketparams['teamoffset'] = 0;
				$bracketparams['roomoffset'] = 0;
				$bracketparams['firstround'] = 8;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<h3>&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<h3 class="playoffbracket1">&nbsp;</h3>
				<?php 
				$bracketparams['numteams'] = 8;
				$bracketparams['teamoffset'] = 6;
				$bracketparams['roomoffset'] = 3;
				$bracketparams['crossovers'] = 4;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
	</div>
</div>
