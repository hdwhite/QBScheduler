<?php
$bracketparams = array();
$bracketparams['numteams'] = 6;
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
				<?php
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<h3 class="prelimbracket1">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php
				$bracketparams['teamoffset'] = 6;
				$bracketparams['roomoffset'] = 3;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php for($k = 2; $k < 5; $k++) {
			if($k == 3) echo("<div class=\"pagebreak\"></div>\n"); ?>
		<h3 class="prelimbracket<?=$k ?>">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php
				$bracketparams['numteams'] = 5;
				$bracketparams['teamoffset'] = 5*$k+2;
				$bracketparams['roomoffset'] = 2*$k+2;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into 3 brackets of 5 and 2 of 6, in which they will play a round-robin. The top two teams within each bracket, plus the two best third-place teams, will be placed into two six-team brackets, containing a mix of top, second-place, and third-place finishers. The remaining 15 teams will be placed into 3 brackets of 5, seeded by their finish in the preliminary rounds.</p>
		<p class="finals1" style="display:none">Each team will play a round-robin within their new brackets. After the final game, the top team in each of the two top brackets will play in a one-game final match, while the second, third, and fourth-place teams in these brackets will play their counterparts in the other top bracket to determine 3rd, 5th, 7th, 9th, and 11th place.</p>
		<p class="finals2" style="display:none">Each team will play a round-robin within their new brackets. After the final game, there will be a four-team single-elimination bracket to determine the top places. The top team in each of the top two brackets will play the second-place team in the other bracket. The winners of those matches will play in the finals, while the losers will play for 3rd place. Meanwhile, the third and fourth-place teams in these brackets will play their counterparts in the other top bracket to determine 5th, 7th, 9th, and 11th place.</p>
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
				$bracketparams['firstround'] = 6;
				$bracketparams['numteams'] = 6;
				$bracketparams['teamoffset'] = 0;
				$bracketparams['roomoffset'] = 0;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<h3 class="playoffbracket1">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php
				$bracketparams['teamoffset'] = 6;
				$bracketparams['roomoffset'] = 3;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php
		$bracketparams['numteams'] = 5;
		for($k = 2; $k < 5; $k++) {
			if($k == 3) echo("<div class=\"pagebreak\"></div>\n"); ?>
		<h3 class="playoffbracket<?=$k ?>">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php
				$bracketparams['teamoffset'] = 5*$k+2;
				$bracketparams['roomoffset'] = 2*$k+2;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
