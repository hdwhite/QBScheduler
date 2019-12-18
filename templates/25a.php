<?php
$bracketparams = array();
$bracketparams['numteams'] = 5;
?>
<div class="scontainer">
	<div class="name">
		<h2 class="tourneyname">&nbsp;</h2>
	</div>
	<div class="phase">
		<div class="phaseheader">
			<h2>Preliminary Rounds</h2>
		</div>
		<?php for($k = 0; $k < 5; $k++) {
			if($k == 3) echo("<div class=\"pagebreak\"></div>\n"); ?>
		<h3 class="prelimbracket<?=$k ?>">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php 
				$bracketparams['teamoffset'] = 5*$k;
				$bracketparams['roomoffset'] = 2*$k;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into 5 brackets of 5, in which they will play a four-game round-robin. The top two teams within each bracket will be placed into two five-team brackets, containing a mix of top and second-place finishers. The remaining 15 teams will be placed into 3 brackets, each of which contains teams that finished in the same position in the preliminary rounds.</p>
		<p class="finals1" style="display:none">Each team will play a four-game round-robin within their new brackets. After the final game, the top team in each of the two top brackets will play in a one-game final match, while the second, third, and fourth-place teams in these brackets will play their counterparts in the other top bracket to determine 3rd, 5th, 7th, and 9th place.</p>
		<p class="finals2" style="display:none">Each team will play a four-game round-robin within their new brackets. After the final game, there will be a four-team single-elimination bracket to determine the top places. The top team in each of the top two brackets will play the second-place team in the other bracket. The winners of those matches will play in the finals, while the losers will play for 3rd place. Meanwhile, the third and fourth-place teams in these brackets will play their counterparts in the other top bracket to determine 5th, 7th, and 9th place.</p>
	</div>
	<div class="phase">
		<div class="phaseheader">
			<h2>Playoff Rounds</h2>
		</div>
		<?php
		$bracketparams['firstround'] = 6;
		for($k = 0; $k < 5; $k++) {
			if($k == 3) echo("<div class=\"pagebreak\"></div>\n"); ?>
		<h3 class="playoffbracket<?=$k ?>">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<?php 
				$bracketparams['teamoffset'] = 5*$k;
				$bracketparams['roomoffset'] = 2*$k;
				echo(createBracket($bracketparams));
				?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
