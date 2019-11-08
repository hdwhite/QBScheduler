<?php
function createBracket($numteams, $teamoffset = 0, $roomoffset = 0, $firstround = 1, $crossovers = 0, $byestyle = 0, $iterations = 1)
{
	$tableheader = "<thead><tr><th>Round</th>";
	switch($numteams)
	{
	case 4:
		$numrooms = 2;
		$hasbye = 0;
		switch($crossovers)
		{
		case 0:
			switch($iterations)
			{
			case 1:
				$teamorder = array(array(0, 3, 1, 2),
				                   array(1, 3, 0, 2),
								   array(0, 1, 2, 3));
				break;
			case 2:
				$teamorder = array(array(0, 3, 1, 2),
				                   array(1, 3, 0, 2),
								   array(0, 1, 2, 3),
								   array(1, 2, 0, 3),
								   array(0, 2, 1, 3),
								   array(0, 1, 2, 3));
				break;
			case 3:
				$teamorder = array(array(1, 3, 0, 2),
				                   array(1, 2, 0, 3),
								   array(0, 1, 2, 3),
								   array(0, 2, 1, 3),
								   array(0, 3, 1, 2),
								   array(2, 3, 0, 1),
								   array(1, 3, 0, 2),
								   array(0, 3, 1, 2),
								   array(0, 1, 2, 3));
				break;
			case 4:
				$teamorder = array(array(1, 3, 0, 2),
				                   array(1, 2, 0, 3),
								   array(0, 1, 2, 3),
								   array(0, 2, 1, 3),
								   array(0, 3, 1, 2),
								   array(2, 3, 0, 1),
								   array(1, 3, 0, 2),
								   array(0, 3, 1, 2),
								   array(0, 1, 2, 3),
								   array(0, 2, 1, 3),
								   array(1, 2, 0, 3),
								   array(2, 3, 0, 1));
				break;
			}
		}
	}
	
	for($i = 0; $i < $numrooms; $i++)
		$tableheader = $tableheader . "<th class=\"room" . ($i + $roomoffset) . "\"></th>";
	if ($hasbye == 1)
		$tableheader = $tableheader . "<th>Bye</th>";
	$tableheader = $tableheader . "</tr></thead>";
	
	$tablebody = array();
	foreach($teamorder as $round => $roundorder)
	{
		$tablebody[$round] = "<tr><th>" . ($round + $firstround) . "</th>";
		for($j = 0; $j < $numrooms; $j++)
			$tablebody[$round] .= "<td><span class='team" . ($roundorder[2*$j] + $teamoffset) . "'></span>&nbsp;<br>" .
			                          "<span class='team" . ($roundorder[2*$j+1]+$teamoffset) . "'></span>&nbsp;</td>";
		if($hasbye == 1)
		{
			$tablebody[$round] .= "<td><span class='team" . ($roundorder[2*$numrooms] + $teamoffset) . "'></span>&nbsp;";
			for($j = 2*$numrooms + 1; $j < sizeof($roundorder); $j++)
				$tablebody[$round] .= "<br><span class='team" . ($roundorder[$j] + $teamoffset) . "'></span>&nbsp;";
			$tablebody[$round] .= "</td>";
		}
		$tablebody[$round] .= "</tr>";
	}

	return "<table>\n" . $tableheader . "\n<tbody>\n" . implode("\n", $tablebody) . "\n</tbody>\n</table>";
}
