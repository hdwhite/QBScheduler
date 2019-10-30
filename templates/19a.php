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
				<table>
					<thead>
						<tr><th>Round</th><th class="room0"></th><th class="room1"></th><th class="room2"></th><th class="room3"></th><th class="room4"></th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(4, 8, 7, 9, 1, 6, 2, 5, 0, 3),
										   array(5, 9, 6, 8, 0, 7, 3, 4, 1, 2),
										   array(2, 7, 1, 4, 3, 8, 0, 9, 5, 6),
										   array(3, 6, 0, 5, 2, 9, 1, 8, 4, 7),
										   array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
										   array(5, 7, 4, 9, 1, 3, 0, 8, 2, 6),
										   array(4, 6, 5, 8, 0, 2, 1, 9, 3, 7),
										   array(3, 9, 0, 6, 7, 8, 2, 4, 1, 5),
										   array(2, 8, 1, 7, 6, 9, 3, 5, 0, 4));
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
		<h3 class="prelimbracket1">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<table>
					<thead>
						<tr><th>Round</th><th class="room5"></th><th class="room6"></th><th class="room7"></th><th class="room8"></th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(4, 5, 3, 6, 2, 7, 1, 8, 0),
										   array(5, 6, 4, 7, 3, 8, 0, 2, 1),
										   array(6, 7, 5, 8, 0, 4, 1, 3, 2),
										   array(7, 8, 0, 6, 1, 5, 2, 4, 3),
										   array(0, 8, 1, 7, 2, 6, 3, 5, 4),
										   array(0, 1, 2, 8, 3, 7, 4, 6, 5),
										   array(1, 2, 0, 3, 4, 8, 5, 7, 6),
										   array(2, 3, 1, 4, 0, 5, 6, 8, 7),
										   array(3, 4, 2, 5, 1, 6, 0, 7, 8));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 1) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='team" . ($roundorder[$j] + 10) . "'></span>&nbsp;<br><span class='team" . ($roundorder[$j+1] + 10) . "'></span>&nbsp;</td>");
							echo("<td><span class='team" . (end($roundorder) + 10) . "'></span>&nbsp;</td>");
							echo("</tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into brackets of 10 and 9, in which they will play a full round-robin. Afterwards, teams will be placed into playoff brackets of 8, 6, and 5 teams, respectively, based on their performance in the preliminary rounds. Each team will once again play a round-robin within their new bracket, with the exception of the team they played in the prelims. Only games against teams in the same playoff bracket will count towards final standing within each bracket. Finals in the top bracket will be played according to the following criteria:</p>
		<ul>
			<div class="finals2 finals3" style="display:none"><li>If the first-place team has two or more wins than every other team, then that team wins the tournament outright without the need for a final.</li></div>
			<div class="finals1" style="display:none"><li>If there is a single team with the best record, then that team wins the tournament outright without the need for a final.</li></div>
			<div class="finals1 finals2 finals3" style="display:none"><li>If there is a two-way tie for first, those teams would play in a one-game final. If there is a tie of three or more teams, those teams will play a series of single-elimination matches, seeded by points per game.</li></div>
			<div class="finals2" style="display:none"><li>If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then entry into the finals will be broken by points per game.</li></div>
			<div class="finals3" style="display:none"><li>If the first-place team has exactly one more win than the second-place team, then an advantaged final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once. If there is a tie for second place, then those teams will play each other to determine entry into the finals.</li></div>
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
				<table>
					<thead>
						<tr><th>Round</th><th class="room0"></th><th class="room1"></th><th class="room2"></th><th class="room3"></th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(1, 4, 2, 5, 3, 6, 0, 7),
										   array(3, 5, 0, 6, 1, 7, 2, 4),
										   array(2, 7, 1, 6, 3, 4, 0, 5),
										   array(1, 5, 0, 4, 2, 6, 3, 7));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 10) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . $roundorder[$j] . "'></span>&nbsp;<br><span class='playoffteam" . $roundorder[$j+1] . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<h3 class="playoffbracket1">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<table>
					<thead>
						<tr><th>Round</th><th class="room4"></th><th class="room5"></th><th class="room6"></th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(2, 4, 0, 5, 1, 3),
										   array(1, 5, 2, 3, 0, 4),
										   array(0, 3, 1, 4, 2, 5));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 10) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 8) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 8) . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<h3 class="playoffbracket2">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center">
				<table>
					<thead>
						<tr><th>Round</th><th class="room7"></th><th class="room8"></th><th>Bye</th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(2, 4, 1, 3, 0),
										   array(0, 4, 2, 3, 1),
										   array(0, 3, 1, 4, 2));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 10) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 14) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 14) . "'></span>&nbsp;</td>");
							echo("<td><span class='playoffteam" . (end($roundorder) + 14) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
