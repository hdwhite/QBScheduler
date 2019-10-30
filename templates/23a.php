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
			<div class="schedule center narrow">
				<table>
					<thead>
						<tr><th>Round</th><th class="room0"></th><th class="room1"></th><th class="room2"></th><th class="room3"></th><th class="room4"></th><th class="room5"></th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(4, 8, 5, 7, 0, 6, 3, 9, 2, 10, 1, 11),
										   array(3, 8, 1, 10, 2, 9, 0, 11, 4, 7, 5, 6),
										   array(1, 9, 4, 6, 3, 7, 2, 8, 0, 5, 10, 11),
										   array(4, 5, 9, 11, 1, 8, 2, 7, 3, 6, 0, 10),
										   array(9, 10, 3, 5, 2, 6, 1, 7, 8, 11, 0, 4),
										   array(2, 5, 8, 10, 7, 11, 1, 6, 0, 9, 3, 4),
										   array(6, 11, 2, 4, 1, 5, 0, 3, 7, 10, 8, 9),
										   array(6, 10, 7, 9, 0, 8, 5, 11, 1, 4, 2, 3),
										   array(1, 3, 0, 2, 4, 11, 5, 10, 6, 9, 7, 8),
										   array(0, 7, 6, 8, 5, 9, 4, 10, 3, 11, 1, 2),
										   array(2, 11, 0, 1, 3, 10, 4, 9, 5, 8, 6, 7));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 1) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='team" . $roundorder[$j] . "'></span>&nbsp;<br><span class='team" . $roundorder[$j+1] . "'></span>&nbsp;</td>");
							// echo("<td><span class='team" . end($roundorder) . "'></span>&nbsp;</td>");
							echo("</tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<h3 class="prelimbracket1">&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule center narrow">
				<table>
					<thead>
						<tr><th>Round</th><th class="room6"></th><th class="room7"></th><th class="room8"></th><th class="room9"></th><th class="room10"></th><th>Bye</th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(5, 6, 4, 7, 3, 8, 2, 9, 1, 10, 0),
										   array(6, 7, 5, 8, 4, 9, 3, 10, 0, 2, 1),
										   array(7, 8, 6, 9, 5, 10, 0, 4, 1, 3, 2),
										   array(8, 9, 7, 10, 0, 6, 1, 5, 2, 4, 3),
										   array(9, 10, 0, 8, 1, 7, 2, 6, 3, 5, 4),
										   array(0, 10, 1, 9, 2, 8, 3, 7, 4, 6, 5),
										   array(0, 1, 2, 10, 3, 9, 4, 8, 5, 7, 6),
										   array(1, 2, 0, 3, 4, 10, 5, 9, 6, 8, 7),
										   array(2, 3, 1, 4, 0, 5, 6, 10, 7, 9, 8),
										   array(3, 4, 2, 5, 1, 6, 0, 7, 8, 10, 9),
										   array(4, 5, 3, 6, 2, 7, 1, 8, 0, 9, 10));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 1) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='team" . ($roundorder[$j] + 12) . "'></span>&nbsp;<br><span class='team" . ($roundorder[$j+1] + 12) . "'></span>&nbsp;</td>");
							echo("<td><span class='team" . (end($roundorder) + 12) . "'></span>&nbsp;</td>");
							echo("</tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="instruction">
		<p>Teams will be initially seeded into brackets of 11 and 12, in which they will play a full round-robin. Afterwards, the teams will be placed into five playoff brackets of 4 and a playoff bracket of 3 based on their performance in the preliminary rounds. Each team will once again play a round-robin within their new bracket, with the excepion of the team they played in the prelims. Only games played against teams in the same playoff bracket will count towards final standing within each bracket. Finals in the top bracket will be played according to the following criteria:</p>
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
		<div class="phaserow">
			<div class="schedule left">
				<h3 class="playoffbracket0">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room0"></th><th class="room1"></th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(0, 3, 1, 2),
						                   array(0, 2, 1, 3));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 11) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . $roundorder[$j] . "'></span>&nbsp;<br><span class='playoffteam" . $roundorder[$j+1] . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
			<div class="schedule left">
				<h3 class="playoffbracket1">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room2"></th><th class="room3"></th></tr>
					</thead>
					<tbody>
					<?php
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 11) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 4) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 4) . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<h3>&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule left">
				<h3 class="playoffbracket2">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room4"></th><th class="room5"></th></tr>
					</thead>
					<tbody>
					<?php
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 11) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 8) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 8) . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
			<div class="schedule left">
				<h3 class="playoffbracket3">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room6"></th><th class="room7"></th></tr>
					</thead>
					<tbody>
					<?php
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 11) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 12) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 12) . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<h3>&nbsp;</h3>
		<div class="phaserow">
			<div class="schedule left">
				<h3 class="playoffbracket4">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room8"></th><th class="room9"></th></tr>
					</thead>
					<tbody>
					<?php
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 11) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 16) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 16) . "'></span>&nbsp;</td>");
							// echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
			<div class="schedule left">
				<h3 class="playoffbracket5">&nbsp;</h3>
				<table>
					<thead>
						<tr><th>Round</th><th class="room10"></th><th>Bye</th></tr>
					</thead>
					<tbody>
					<?php
						$teamorder = array(array(1, 2, 0),
						                   array(0, 2, 1));
						foreach($teamorder as $round => $roundorder)
						{
							echo("<tr><th>" . ($round + 11) . "</th>");
							for($j = 0; $j < sizeof($roundorder) - 1; $j += 2)
								echo("<td><span class='playoffteam" . ($roundorder[$j] + 20) . "'></span>&nbsp;<br><span class='playoffteam" . ($roundorder[$j+1] + 20) . "'></span>&nbsp;</td>");
							echo("<td><span class='playoffteam" . end($roundorder) . "'></span>&nbsp;</td></tr>\n");
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
