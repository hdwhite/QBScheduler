<div class="scontainer">
	<div class="name">
		<h2 class="tourneyname">&nbsp;</h2>
	</div>
	<div class="phase">
		<div class="phaseheader">
			<h2>Schedule</h2>
		</div>
		<div class="schedule center narrow">
			<table>
				<thead>
					<tr><th>Round</th><th class="room0"></th><th class="room1"></th><th class="room2"></th><th class="room3"></th><th class="room4"></th><th class="room5"></th></tr>
				</thead>
				<tbody>
				<?php
					$teamorder = array(array(8, 4, 7, 5, 0, 6, 9, 3, 10, 2, 11, 1),
					                   array(3, 8, 1, 10, 2, 9, 0, 11, 4, 7, 5, 6),
									   array(9, 1, 6, 4, 7, 3, 8, 2, 0, 5, 10, 11),
									   array(4, 5, 11, 9, 1, 8, 2, 7, 3, 6, 0, 10),
									   array(10, 9, 5, 3, 6, 2, 7, 1, 8, 11, 4, 0),
									   array(5, 2, 10, 8, 11, 7, 1, 6, 9, 0, 3, 4),
									   array(11, 6, 4, 2, 5, 1, 3, 0, 7, 10, 8, 9),
									   array(6, 10, 9, 7, 8, 0, 11, 5, 1, 4, 2, 3),
									   array(1, 3, 2, 0, 4, 11, 5, 10, 6, 9, 7, 8),
									   array(0, 7, 8, 6, 9, 5, 10, 4, 11, 3, 1, 2),
									   array(2, 11, 0, 1, 3, 10, 4, 9, 5, 8, 6, 7));
					foreach($teamorder as $round => $roundorder)
					{
						echo("<tr><th>" . ($round + 1) . "</th>");
						for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
							echo("<td><span class='team" . $roundorder[$j] . "'></span>&nbsp;<br><span class='team" . $roundorder[$j+1] . "'></span>&nbsp;</td>");
						//echo("<td><span class='team" . end($roundorder) . "'></span>&nbsp;</td>");
						echo("</tr>\n");
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="instruction">
		<p>Teams will play every other team once, for an eleven-game round-robin. After the final game, the champion will be detrmined as follows:</p>
		<ul>
			<div class="finals2 finals3" style="display:none"><li>If the first-place team has two or more wins than every other team, then that team wins the tournament outright without the need for a final.</li></div>
			<div class="finals1" style="display:none"><li>If there is a single team with the best record, then that team wins the tournament outright without the need for a final.</li></div>
			<div class="finals1 finals2 finals3" style="display:none"><li>If there is a two-way tie for first, those teams would play in a one-game final. If there is a tie of three or more teams, those teams will play a series of single-elimination matches, seeded by points per game.</li></div>
			<div class="finals2" style="display:none"><li>If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then entry into the finals will be broken by points per game.</li></div>
			<div class="finals3" style="display:none"><li>If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then those teams will play each other to determine entry into the finals.</li></div>
		</ul>
	</div>
</div>
