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
				<table>
					<thead>
						<tr><th>Round</th><th class="room<?=(3*$k) ?>"></th><th class="room<?=(3*$k+1) ?>"></th><th class="room<?=(3*$k+2) ?>"></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(0, 1, 2, 3, 4, 5),
										   array(3, 5, 1, 4, 0, 2),
										   array(2, 4, 0, 3, 1, 5),
										   array(1, 3, 2, 5, 0, 4),
										   array(0, 5, 3, 4, 1, 2));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 1) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='team" . ($roundorder[$j] + 6*$k) . "'></span>&nbsp;<br><span class='team" . ($roundorder[$j+1] + 6*$k) . "'></span>&nbsp;</td>");
							// echo("<td><span class='team" . end($roundorder) . "'></span>&nbsp;</td>");
							echo("</tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into 4 brackets of 6, in which they will play a five-game round-robin. The top two teams within each bracket will be placed into two four-team brackets, each containing two top finishers and two second-place finishers. The remaining 16 teams will be placed into four brackets, each of which contains teams that finished in the same position in the preliminary rounds.</p>
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
		$teamorder = array(array(0, 3, 1, 2),
						   array(1, 3, 0, 2),
						   array(0, 1, 2, 3));
		for($k = 0; $k < 3; $k++) { ?>
		<div class="phaserow">
			<div class="schedule left">
				<h3 class="playoffbracket<?=(2*$k) ?>">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room<?=(4*$k) ?>"></th><th class="room<?=(4*$k+1) ?>"></th></tr>
					</thead>
					<tbody>
					<?php
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 6) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 8*$k) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 8*$k) . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
			<div class="schedule left">
				<h3 class="playoffbracket<?=(2*$k+1) ?>">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room<?=(4*$k+2) ?>"></th><th class="room<?=(4*$k+3) ?>"></th></tr>
					</thead>
					<tbody>
					<?php
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 6) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 8*$k + 4) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 8*$k + 4) . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<h3>&nbsp;</h3>
		<?php } ?>
	</div>
</div>
