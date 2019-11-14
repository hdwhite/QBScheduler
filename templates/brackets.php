<?php
function createBracket($params)
{
	if(array_key_exists("numteams", $params))
		$numteams = $params['numteams'];
	else
	{
		echo("ERROR: Please set number of teams.");
		exit;
	}
	$teamoffset = (array_key_exists("teamoffset", $params) ? $params['teamoffset'] : 0);
	$roomoffset = (array_key_exists("roomoffset", $params) ? $params['roomoffset'] : 0);
	$firstround = (array_key_exists("firstround", $params) ? $params['firstround'] : 1);
	$crossovers = (array_key_exists("crossovers", $params) ? $params['crossovers'] : 0);
	$byestyle   = (array_key_exists("byestyle", $params)   ? $params['byestyle']   : 0);
	$iterations = (array_key_exists("iterations", $params) ? $params['iterations'] : 1);
	$inplaceplayoffs = (array_key_exists("inplaceplayoffs", $params) ? $params['inplaceplayoffs'] : 0);
	
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
			break;
		case 2:
			$teamorder = array(array(0, 3, 1, 2),
			                   array(0, 2, 1, 3));
		}
		break;
	case 5:
		$numrooms = 2;
		$hasbye = 1;
		switch($crossovers)
		{
		case 0:
			switch($iterations)
			{
			case 1:
				$teamorder = array(array(2, 3, 1, 4, 0),
				                   array(3, 4, 0, 2, 1),
								   array(0, 4, 1, 3, 2),
								   array(0, 1, 2, 4, 3),
								   array(1, 2, 0, 3, 4));
				break;
			case 2:
				$teamorder = array(array(2, 3, 1, 4, 0),
				                   array(3, 4, 0, 2, 1),
								   array(0, 4, 1, 3, 2),
								   array(0, 1, 2, 4, 3),
								   array(1, 2, 0, 3, 4),
				                   array(2, 3, 1, 4, 0),
				                   array(3, 4, 0, 2, 1),
								   array(0, 4, 1, 3, 2),
								   array(0, 1, 2, 4, 3),
								   array(1, 2, 0, 3, 4));
				break;
			}
			break;
		}
		if($inplaceplayoffs == 1)
			$teamorder = array(array(1, 2, 3, 4, 0),
		                       array(0, 2, 3, 4, 1),
							   array(0, 1, 99, 99, 2));
		break;
	case 6:
		$numrooms = 3;
		$hasbye = 0;
		switch($crossovers)
		{
		case 0:
			switch($iterations)
			{
			case 1:
				$teamorder = array(array(0, 1, 2, 3, 4, 5),
								   array(3, 5, 1, 4, 0, 2),
								   array(2, 4, 0, 3, 1, 5),
								   array(1, 3, 2, 5, 0, 4),
								   array(0, 5, 3, 4, 1, 2));
				break;
			case 2:
				$teamorder = array(array(0, 1, 2, 3, 4, 5),
								   array(3, 5, 1, 4, 0, 2),
								   array(2, 4, 0, 3, 1, 5),
								   array(1, 3, 2, 5, 0, 4),
								   array(0, 5, 3, 4, 1, 2),
								   array(4, 5, 0, 1, 2, 3),
								   array(0, 2, 3, 5, 1, 4),
								   array(1, 5, 2, 4, 0, 3),
								   array(0, 4, 1, 3, 2, 5),
								   array(1, 2, 0, 5, 3, 4));
				break;
			}
			break;
		case 3:
			$teamorder = array(array(2, 4, 0, 5, 1, 3),
						       array(1, 5, 2, 3, 0, 4),
							   array(0, 3, 1, 4, 2, 5));
			break;
		}
		break;
	case 7:
		$numrooms = 3;
		$hasbye = 1;
		switch($crossovers)
		{
		case 0:
			switch($iterations)
			{
			case 1:
				$teamorder = array(array(3, 4, 2, 5, 1, 6, 0),
				                   array(4, 5, 3, 6, 0, 2, 1),
								   array(5, 6, 0, 4, 1, 3, 2),
								   array(0, 6, 1, 5, 2, 4, 3),
								   array(0, 1, 2, 6, 3, 5, 4),
								   array(1, 2, 0, 3, 4, 6, 5),
								   array(2, 3, 1, 4, 0, 5, 6));
				break;
			case 2:
				$teamorder = array(array(3, 4, 2, 5, 1, 6, 0),
				                   array(4, 5, 3, 6, 0, 2, 1),
								   array(5, 6, 0, 4, 1, 3, 2),
								   array(0, 6, 1, 5, 2, 4, 3),
								   array(0, 1, 2, 6, 3, 5, 4),
								   array(1, 2, 0, 3, 4, 6, 5),
								   array(2, 3, 1, 4, 0, 5, 6),
								   array(3, 4, 2, 5, 1, 6, 0),
				                   array(4, 5, 3, 6, 0, 2, 1),
								   array(5, 6, 0, 4, 1, 3, 2),
								   array(0, 6, 1, 5, 2, 4, 3),
								   array(0, 1, 2, 6, 3, 5, 4),
								   array(1, 2, 0, 3, 4, 6, 5),
								   array(2, 3, 1, 4, 0, 5, 6));
				break;
			}
			break;
		case 4:
			$teamorder = array(array(3, 6, 2, 5, 1, 4, 0),
							   array(2, 4, 0, 6, 3, 5, 1),
							   array(1, 6, 3, 4, 0, 5, 2),
							   array(0, 4, 1, 5, 2, 6, 3));
		}
		if($inplaceplayoffs == 1)
			$teamorder = array(array(0, 3, 1, 2, 5, 6, 4),
							   array(1, 3, 0, 2, 4, 6, 5),
							   array(0, 1, 2, 3, 4, 5, 6));
		break;
	case 8:
		$numrooms = 4;
		$hasbye = 0;
		switch($crossovers)
		{
		case 0:
			$teamorder = array(array(0, 1, 2, 3, 4, 5, 6, 7),
							   array(4, 6, 5, 7, 0, 2, 1, 3),
							   array(0, 3, 1, 2, 4, 7, 5, 6),
							   array(1, 5, 0, 4, 2, 6, 3, 7),
							   array(2, 7, 1, 6, 3, 4, 0, 5),
							   array(3, 5, 0, 6, 1, 7, 2, 4),
							   array(1, 4, 2, 5, 3, 6, 0, 7));
			break;
		case 4:
			$teamorder = array(array(0, 7, 1, 4, 2, 5, 3, 6),
							   array(3, 5, 0, 6, 1, 7, 2, 4),
							   array(1, 6, 2, 7, 3, 4, 0, 5),
							   array(0, 4, 1, 5, 2, 6, 3, 7));
			break;
		}
		if($inplaceplayoffs == 1)
			$teamorder = array(array(0, 3, 1, 2, 4, 7, 5, 6),
							   array(1, 3, 0, 2, 5, 7, 4, 6),
							   array(0, 1, 2, 3, 4, 5, 6, 7));
		break;
	case 9:
		$numrooms = 4;
		$hasbye = 1;
		switch($crossovers)
		{
		case 0:
			$teamorder = array(array(4, 5, 3, 6, 2, 7, 1, 8, 0),
							   array(5, 6, 4, 7, 3, 8, 0, 2, 1),
							   array(6, 7, 5, 8, 0, 4, 1, 3, 2),
							   array(7, 8, 0, 6, 1, 5, 2, 4, 3),
							   array(0, 8, 1, 7, 2, 6, 3, 5, 4),
							   array(0, 1, 2, 8, 3, 7, 4, 6, 5),
							   array(1, 2, 0, 3, 4, 8, 5, 7, 6),
							   array(2, 3, 1, 4, 0, 5, 6, 8, 7),
							   array(3, 4, 2, 5, 1, 6, 0, 7, 8));
		   break;
		}
		switch($inplaceplayoffs)
		{
		case 1:
			$numrooms = 3;
			$teamorder = array(array(1, 2, 4, 5, 7, 8, 0, 3, 6),
			                   array(0, 2, 3, 5, 6, 8, 1, 4, 7),
							   array(0, 1, 3, 4, 6, 7, 2, 5, 8));
			break;
		case 2:
			$numrooms = 4;
			$teamorder = array(array(1, 2, 0, 3, 5, 8, 6, 7, 4),
							   array(2, 3, 1, 4, 6, 8, 5, 7, 0),
							   array(3, 4, 0, 2, 5, 6, 7, 8, 1),
							   array(0, 4, 1, 3, 99, 99, 99, 99, 2),
							   array(0, 1, 2, 4, 99, 99, 99, 99, 3));
			break;
		}
		break;
	case 10:
		$numrooms = 5;
		$hasbye = 0;
		switch($crossovers)
		{
		case 0:
		$teamorder = array(array(4, 8, 7, 9, 1, 6, 2, 5, 0, 3),
						   array(5, 9, 6, 8, 0, 7, 3, 4, 1, 2),
						   array(2, 7, 1, 4, 3, 8, 0, 9, 5, 6),
						   array(3, 6, 0, 5, 2, 9, 1, 8, 4, 7),
						   array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
						   array(5, 7, 4, 9, 1, 3, 0, 8, 2, 6),
						   array(4, 6, 5, 8, 0, 2, 1, 9, 3, 7),
						   array(3, 9, 0, 6, 7, 8, 2, 4, 1, 5),
						   array(2, 8, 1, 7, 6, 9, 3, 5, 0, 4));
			break;
		}
		if($inplaceplayoffs == 1)
		{
			$numrooms = 4;
			$hasbye = 1;
			$teamorder = array(array(0, 3, 1, 2, 5, 6, 8, 9, 4, 7),
							   array(1, 3, 0, 2, 4, 6, 7, 9, 5, 8),
							   array(0, 1, 2, 3, 4, 5, 7, 8, 6, 9));
		}
		break;
	case 11:
		$numrooms = 5;
		$hasbye = 1;
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
		break;
	case 12:
		$numrooms = 6;
		$hasbye = 0;
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
		break;
	case 13:
		$numrooms = 6;
		$hasbye = 1;
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
		break;
	case 14:
		$numrooms = 7;
		$hasbye = 0;
		$teamorder = array(array(2, 13, 0, 1, 3, 12, 4, 11, 5, 10, 6, 9, 7, 8),
						   array(5, 9, 6, 8, 0, 7, 4, 10, 3, 11, 2, 12, 1, 13),
						   array(3, 10, 1, 12, 2, 11, 0, 13, 4, 9, 5, 8, 6, 7),
						   array(2, 10, 5, 7, 4, 8, 3, 9, 0, 6, 1, 11, 12, 13),
						   array(4, 7, 11, 13, 1, 10, 2, 9, 3, 8, 0, 12, 5, 6),
						   array(11, 12, 4, 6, 3, 7, 2, 8, 1, 9, 10, 13, 0, 5),
						   array(4, 5, 10, 12, 9, 13, 1, 8, 2, 7, 3, 6, 0, 11),
						   array(9, 12, 3, 5, 2, 6, 1, 7, 8, 13, 0, 4, 10, 11),
						   array(1, 6, 9, 11, 8, 12, 7, 13, 0, 10, 2, 5, 3, 4),
						   array(6, 13, 2, 4, 1, 5, 0, 3, 7, 12, 8, 11, 9, 10),
						   array(7, 11, 8, 10, 0, 9, 6, 12, 5, 13, 1, 4, 2, 3),
						   array(1, 3, 0, 2, 4, 13, 5, 12, 6, 11, 7, 10, 8, 9),
						   array(0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 1, 2));
		break;
	}
	
	for($i = 0; $i < $numrooms; $i++)
		$tableheader = $tableheader . "<th class=\"room" . ($i + $roomoffset) . "\"></th>";
	if ($hasbye == 1)
		$tableheader = $tableheader . "<th>Bye</th>";
	$tableheader = $tableheader . "</tr></thead>";
	
	$tablebody = array();
	$tphase = ($firstround > 1 ? "playoffteam" : "team");
	foreach($teamorder as $round => $roundorder)
	{
		$tablebody[$round] = "<tr><th>" . ($round + $firstround) . "</th>";
		for($j = 0; $j < $numrooms; $j++)
			$tablebody[$round] .= "<td><span class='$tphase" . ($roundorder[2*$j] + $teamoffset) . "'></span>&nbsp;<br>" .
			                          "<span class='$tphase" . ($roundorder[2*$j+1]+$teamoffset) . "'></span>&nbsp;</td>";
		if($hasbye == 1)
		{
			$tablebody[$round] .= "<td><span class='$tphase" . ($roundorder[2*$numrooms] + $teamoffset) . "'></span>&nbsp;";
			for($j = 2*$numrooms + 1; $j < sizeof($roundorder); $j++)
				$tablebody[$round] .= "<br><span class='$tphase" . ($roundorder[$j] + $teamoffset) . "'></span>&nbsp;";
			$tablebody[$round] .= "</td>";
		}
		$tablebody[$round] .= "</tr>";
	}

	return "<table>\n" . $tableheader . "\n<tbody>\n" . implode("\n", $tablebody) . "\n</tbody>\n</table>";
}
