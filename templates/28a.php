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
		<?php for($k = 0; $k < 4; $k++) { ?>
		<h3 class="prelimbracket<?=$k ?>">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php 
				$bracketparams['teamoffset'] = 7*$k;
				$bracketparams['roomoffset'] = 3*$k;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into 4 brackets of 7, in which they will play a six-game round-robin. The top two teams within each bracket will be placed into two four-team brackets, each of which contains two top finishers and two second-place finishers. The remaining 20 teams will be placed into five brackets, each of which contains teams that finished in the same position in the preliminary rounds.</p>
		<p class="finals1" style="display:none">Each team will play a three-game round-robin within their new brackets. After the final game, the top team in each of the two top brackets will play in a one-game final match, while the second, third, and fourth-place teams in these brackets will play their counterparts in the other top bracket to determine 3rd, 5th, and 7th place.</p>
		<p class="finals2" style="display:none">Each team will play a three-game round-robin within their new brackets. After the final game, there will be a four-team single-elimination bracket to determine the top places. The top team in each of the top two brackets will play the second-place team in the other bracket. The winners of those matches will play in the finals, while the losers will play for 3rd place. Meanwhile, the third and fourth-place teams in these brackets will play their counterparts in the other top bracket to determine 5th and 7th place.</p>
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
		$bracketparams['numteams'] = 4;
		$bracketparams['firstround'] = 8;
		for($k = 0; $k < 3; $k++) { ?>
		<div class="phaserow">
			<div class="schedule left">
				<h3 class="playoffbracket<?=(2*$k) ?>">&nbsp;</h3>
				<?php 
				$bracketparams['teamoffset'] = 8*$k;
				$bracketparams['roomoffset'] = 4*$k;
				echo(createBracket($bracketparams));
				?>
			</div>
			<div class="schedule left">
				<h3 class="playoffbracket<?=(2*$k+1) ?>">&nbsp;</h3>
				<?php 
				$bracketparams['teamoffset'] = 8*$k+4;
				$bracketparams['roomoffset'] = 4*$k+2;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<h3>&nbsp;</h3>
		<?php } ?>
		<div class="phaserow">
			<div class="schedule center">
				<h3 class="playoffbracket4">&nbsp;</h3>
				<?php 
				$bracketparams['teamoffset'] = 24;
				$bracketparams['roomoffset'] = 12;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
	</div>
</div>
