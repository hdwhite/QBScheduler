<?php
function listteams($bracketlist, $teamlist)
{
	echo("<table>\n<thead>\n<tr><th>No.</th>");
	foreach($bracketlist as $bracket)
		echo("<th>$bracket</th>");
	echo("</tr>\n</thead>\n<tbody>\n");
	for($i = 0; $i < count($teamlist[0]); $i++)
	{
		echo("<tr><th>" . ($i + 1) . "</th>");
		for($j = 0; $j < count($teamlist); $j++)
			echo("<td>" . $teamlist[$j][$i] . "</td>");
		echo("</tr>\n");
	}
	echo("</tbody>\n</table>\n");
}

function listblankteams($bracketlist, $teams)
{
	echo("<table>\n<thead>\n<tr><th>No.</th>");
	foreach($bracketlist as $bracket)
		echo("<th>$bracket</th>");
	echo("</tr>\n</thead>\n<tbody>\n");
	for($i = 0; $i < $teams; $i++)
	{
		echo("<tr><th>" . ($i + 1) . "</th>");
		for($j = 0; $j < count($bracketlist); $j++)
			echo("<td></td>");
		echo("</tr>\n");
	}
	echo("</tbody>\n</table>\n");
}


function finalstext($finals)
{
	$text = "<ul>\n";
	switch($finals)
	{
		case 1:
			$text = $text . "<li>If the first-place team is one or more games ahead of the second-place team(s), then the first-place team has won the tournament without the need for a final.</li>\n" .
			                "<li>If there is a two-way tie for first, it will be played off as a single-game final.</li>\n" .
							"<li>If three or more teams are tied for first, the top two teams as determined by points per game will play in the final.</li>\n";
			break;
		case 2:
			$text = $text . "<li>If the first-place team is two or more games ahead of the second-place team(s), then the first-place team has won the tournament without the need for a final.</li>\n" .
	 		                "<li>If there is a two-way tie for first, it will be played off as a single game. If there is a three-way tie, the teams will be seeded by PPG and the second and third seeds will play a full game, with the winner playing the first seed for the tournament title.</li>\n" .
			                "<li>If the first-place team is exactly one game ahead of the second-place team, then a weighted final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once.</li>\n";
			break;
		case 3:
			$text = $text . "<li>If the first-place team is two or more games ahead of the second-place team(s), then the first-place team has won the tournament without the need for a final.</li>\n" .
	 		                "<li>If there is a two-way tie for first, it will be played off as a single game. If there is a three-way tie, the teams will be seeded by PPG and the second and third seeds will play a full game, with the winner playing the first seed for the tournament title.</li>\n" .
			                "<li>If the first-place team is exactly one game ahead of the second-place team, then a weighted final of up to two games will take place, with the second-place team needing to win twice but the first-place team needing to win only once.</li>\n";
			                "<li>If there are two teams tied for second place, exactly one game behind the first-place team, then the two teams in the tie will play a full-game tiebreaker, with the winner entering the weighted final against the first-place team.</li>\n";
			break;
	}
	$text = $text . "</ul>";
	return $text;
}

function numformat($num)
{
	switch($num)
	{
		case 1:
			return "one";
		case 2:
			return "two";
		case 3:
			return "three";
		case 4:
			return "four";
		case 5:
			return "five";
		case 6:
			return "six";
		case 7:
			return "seven";
		case 8:
			return "eight";
		case 9:
			return "nine";
		case 10:
			return "ten";
		default:
			return "$num";
	}
}

function article($num)
{
	switch($num)
	{
		case 8:
		case 11:
		case 18:
			return "an " . numformat($num);
		default:
			return "a " . numformat($num);
	}
}

function singleRRInstructions($finals, $numgames, $numrrs = 1)
{
	$ordinal = ($numrrs == 1 ? "once" : ($numrrs == 2 ? "twice" : "three times"));
	$times = ($numrrs == 1 ? "" : ($numrrs == 2 ? " double" : " triple"));
	return "<p>Teams will play every other team $ordinal, for " . article($numgames) . "-game$times round-robin. Teams will be ranked based on number of wins, and then final matches will be played according to the following criteria:<br></p>\n" . finalstext($finals);
}

function splitRRInstructions($finals, $numgames, $topteams, $botteams)
{
	return "<p>Teams will play every other team once, for " . article($numgames) . "-game round-robin. Afterwards, the top " . numformat($topteams) . " and bottom " . numformat($botteams) . " teams will split off into two brackets and play a round-robin within each bracket. All games will count for final standing, and the final matches will be played according to the following criteria:</p><br>\n" . finalstext($finals);
}

function rebracketRRInstructions($finals, $numbrackets, $numgames, $repeats = 0, $plural = 0)
{
	$team = ($plural == 0 ? "team" : ($plural == 1 ? "teams" : "teams(s)"));
	return "Teams will be initially seeded into " . numformat($numbrackets) . " brackets. Each team will play the other members in its bracket for " . article($numgames) . "-game round-robin. Afterwards, teams will be placed into playoff brackets based on their performance in the preliminary rounds. Teams will once again play a round-robin within their new bracket" . ($repeats == 0 ? ", with the exception of the $team they played in the prelims" : "") . ". Only " . ($repeats == 0 ? "games against teams in the same playoff bracket" : "playoff games") . " will count towards final standing within each bracket. Finals in the top bracket will be played according to the following criteria:</p>\n" . finalstext($finals);
}
?>
