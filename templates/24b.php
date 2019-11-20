<?php
$bracketparams = array();
$bracketparams['numteams'] = 8;
?>
<div class="scontainer">
	<div class="name">
		<h2 class="tourneyname">&nbsp;</h2>
	</div>
	<div class="phase">
		<div class="phaseheader">
			<h2>Preliminary Rounds</h2>
		</div>
		<?php for($k = 0; $k < 3; $k++) { ?>
		<h3 class="prelimbracket<?=$k ?>">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php 
				$bracketparams['teamoffset'] = 8*$k;
				$bracketparams['roomoffset'] = 4*$k;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into three brackets of 8, in which they will play a seven-game round-robin. Afterwards, the teams will be placed into four playoff brackets of 6 based on their performance in the preliminary rounds. Each team will once again play a round-robin within their new bracket, with the excepion of the team they played in the prelims. Only games played against teams in the same playoff bracket will count towards final standing within each bracket. Finals in the top bracket will be played according to the following criteria:</p>
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
		<?php
		$bracketparams['numteams'] = 6;
		$bracketparams['firstround'] = 8;
		$bracketparams['crossovers'] = 2;
		for($k = 0; $k < 4; $k++) { ?>
		<h3 class="playoffbracket<?=$k ?>">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php 
				$bracketparams['teamoffset'] = 6*$k;
				$bracketparams['roomoffset'] = 3*$k;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
