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
					<tr><th>Round</th><th class="room0"></th><th class="room1"></th><th class="room2"></th><th class="room3"></th><th class="room4"></th><th class="room5"><th>Bye</th></tr>
				</thead>
				<tbody>
				<?php
					$teamorder = array(array(6, 7, 5, 8, 4, 9, 3, 10, 2, 11, 1, 12, 0),
					                   array(7, 8, 6, 9, 5, 10, 4, 11, 3, 12, 0, 2, 1),
									   array(8, 9, 7, 10, 6, 11, 5, 12, 0, 4, 1, 3, 2),
									   array(9, 10, 8, 11, 7, 12, 0, 6, 1, 5, 2, 4, 3),
									   array(10, 11, 9, 12, 0, 8, 1, 7, 2, 6, 3, 5, 4),
									   array(11, 12, 0, 10, 1, 9, 2, 8, 3, 7, 4, 6, 5),
									   array(0, 12, 1, 11, 2, 10, 3, 9, 4, 8, 5, 7, 6),
									   array(0, 1, 2, 12, 3, 11, 4, 10, 5, 9, 6, 8, 7),
									   array(1, 2, 0, 3, 4, 12, 5, 11, 6, 10, 7, 9, 8),
									   array(2, 3, 1, 4, 0, 5, 6, 12, 7, 11, 8, 10, 9),
									   array(3, 4, 2, 5, 1, 6, 0, 7, 8, 12, 9, 11, 10),
									   array(4, 5, 3, 6, 2, 7, 1, 8, 0, 9, 10, 12, 11),
									   array(5, 6, 4, 7, 3, 8, 2, 9, 1, 10, 0, 11, 12));
					foreach($teamorder as $round => $roundorder)
					{
						echo("<tr><th>" . ($round + 1) . "</th>");
						for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
							echo("<td><span class='team" . $roundorder[$j] . "'></span>&nbsp;<br><span class='team" . $roundorder[$j+1] . "'></span>&nbsp;</td>");
						echo("<td><span class='team" . end($roundorder) . "'></span>&nbsp;</td>");
						echo("</tr>\n");
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="instruction">
		<p>Teams will play every other team once, for a twelve-game round-robin. After the final game, the champion will be detrmined as follows:</p>
		<ul>
			<div class="finals2 finals3" style="display:none"><li>If the first-place team has two or more wins than every other team, then that team wins the tournament outright without the need for a final.</li></div>
			<div class="finals1" style="display:none"><li>If there is a single team with the best record, then that team wins the tournament outright without the need for a final.</li></div>
			<div class="finals1 finals2 finals3" style="display:none"><li>If there is a two-way tie for first, those teams would play in a one-game final. If there is a tie of three or more teams, those teams will play a series of single-elimination matches, seeded by points per game.</li></div>
			<div class="finals2" style="display:none"><li>If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then entry into the finals will be broken by points per game.</li></div>
			<div class="finals3" style="display:none"><li>If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then those teams will play each other to determine entry into the finals.</li></div>
		</ul>
	</div>
</div>
