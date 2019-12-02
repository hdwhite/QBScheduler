<html>
	<head>
		<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/analytics.php"); ?>
		<STYLE TYPE="text/css">
			@import url("/harry.css");
		</STYLE>
		<title>Quizbowl Schedule Generator FAQ</title>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h2>Quizbowl Schedule Generator FAQ</h2>
				<?php include("../header.php"); ?>
			</div>
			<div id="content">
				<div class="entry">
					<h4>How do crossover brackets work?</h4>
					<p>In an attempt to reduce redundant games and provide more room for more meaningful matches, if two teams in the same prelim bracket end up in the same playoff bracket, they will not be scheduled to play each other again and instead their result from earlier in the day would be counted.</p><br>
					<p>As an example, in a 16-team tournament, teams would be divided into two brackets of 8. After the morning rounds are done, teams A1 through A4 (in bracket A) and B1 through B4 are sent to the top playoff bracket (and A5-A8 and B5-B8 to the bottom bracket). Normally we would then have each team play each other team in the new brackets, but A1 has already played A2, A3, and A4, and so on for all the other teams. Rather than make every team play some of the same teams again, we can assume that they'll perform the same way and we can carry over those earlier games into the playoffs. In addition, this allows us to finish everything except the finals in 11 rounds, rather than forcing a 14-round marathon.</p>
				</div>
				<div class="entry">
					<h4>How do paired top brackets work?</h4>
					<p>For tournaments with over 24 teams, paired top brackets allow a champion to be decided quickly but without eliminating too many teams and potential contenders after the prelims due to an upset or poor seeding.</p><br>
					<p>For instance, let's assume a 32-team tournament. The prelims feature 4 brackets of 8, and let us assume that after those 7 rounds, bracket A features teams A1 through A8 in order of placement. Similarly, bracket B contains teams B1-B8, and so on for brackets C and D. For the playoff rounds, we would create one 4-team bracket featuring teams A1, B2, C1, and D2, and a second one with A2, B1, C2, and D1. Within each of these new brackets, the four teams will play a round-robin, and then the top teams in each playoff bracket will play each other for 1st place, the 2nd place teams for 3rd overall, the 3rd best teams for 5th overall, and the bottom teams for 7th. Alternatively, the top team in one playoff bracket could play the 2nd-place team in the other bracket and vice-versa, and then the winners would play for the championship (and the losers for 3rd place). Meanwhile, teams A3, B3, C3, and D3 would play in their own bracket to determine 9th through 12th place, the 4th place teams would play for 13th place, and so on all the way down.</p>
				</div>
				<div class="entry">
					<h4>Why isn't Swiss paring or the card system used?</h4>
					<p>Swiss pairing, and its cousin the card system, are both useful in very large tournaments where seeding teams is difficult. However, Swiss pairing requires all games to be completed and reporting before the next set of matches can be determined, which can cause significant delays to the point where a team can spend two hours of their day waiting to know where to go next. The card system, on the other hand, eliminates this delay but is vulernable to repeat matches and games featuring teams with mismatched records as the day goes along. Furthermore, both formats have very little margin for error, and even the smallest mistake can cascade into showstopping issues.</p>
				</div>
				<div class="entry">
					<h4>Why aren't playoffs single-elimination or double-elimination?</h4>
					<p>Single-elimination is useful when the goal is to find the best team as quickly as possible. In a league like the NFL, where teams can only play one game a week, single-elimination is necessary for finding a champion. However, it does a poor job of ranking all the other teams in the tournament, it is susceptible to a single poor game by a top team completely messing up the bracket, and fully half the teams only get a chance to play one game. Double-elimination ameliorates some of those issues, but even an 8-team bracket would take 7 rounds to run and it still has many of the same problems that a single-elim format has.</p><br>
					<p>Having round-robin brackets in both the prelims and playoffs gives the most teams the most possible games, a way to accurately rank teams from first to last, and the most bang for the buck. Every team gets to play several meaningful games against other teams of approximately the same skill level, and even teams that placed near the bottom in the prelims will have real chances for redemption and victories.</p>
				</div>
				<div class="entry">
					<h4>Why don't you have schedules for a 37-team tournament?</h4>
					<p>With the possible exception of 40- and 48-team events, very few tournaments in a given year have more than 36 teams. It's not really worth it on my end to create a schedule that would never get used. Additionally, at that size, it becomes hard to create a fair schedule that gives all teams an acceptable number of games without taking too many rounds to play. If your event gets too big, it might be worthwhile to split up the field into "novice" and "varsity" divisions or something similar.</p>
				</div>
 			</div>
		<?php include("../../../footer.php"); ?>
		</div>
	</body>
</html>
