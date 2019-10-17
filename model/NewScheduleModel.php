<?php
class NewScheduleModel extends Model
{
	public function __construct()
	{
		$this->init();
		$this->headertext = "Quizbowl Schedule Generator";
	}
	public function gettype()
	{
		return "newschedule";
	}
	//The index page doesn't care about any additional parameters, so this
	//function can be left blank
	public function setparams($params)
	{
	}
	//Retreives necessary data about the Index page
	public function getdata()
	{
		if($_POST['snumber'] == 0)
		{
			$this->mysqli->query("UPDATE $this->counterdb SET num=num+1");
			$snumber = $this->mysqli->query("SELECT * FROM $this->counterdb")
				->fetch_assoc()['num'];
		}
		else
			$snumber = $_POST['snumber'];

		$numteams = $_POST['numTeams'];
		$url = $_POST[$numteams . "teamschedules"];
		$formatinfo = $this->mysqli->query("SELECT * FROM $this->templatedb " .
			"WHERE url='$url' LIMIT 0,1")->fetch_assoc();
		$numrounds = $formatinfo['rounds'];
		$tourneyname = $_POST['name'];
		$teamlist = array();
		$bracketlist = array();
		for($i = 0; $i < $formatinfo['brackets']; $i++)
		{
			$teamlist[$i] = array_map('trim', array_filter(explode("\n", $_POST["teams$i"])));
			$bracketlist[$i] = trim($_POST["bracket$i"]);
		}
		$roomlist = array_map('trim', array_filter(explode("\n", $_POST['rooms'])));
		$pbracketlist = array_map('trim', array_filter(explode("\n", $_POST['pbrackets'])));
		$this->title = "$numrounds-round schedule for $numteams teams";
		$schedulecss = true;
		$schedulelist = $this->getschedulelist();

		return array("title" => $this->title,
		             "headertext" => $this->headertext,
					 "url" => $url,
					 "schedulecss" => $schedulecss,
					 "schedulelist" => $schedulelist,
					 "tourneyname" => $tourneyname,
					 "teamlist" => $teamlist,
					 "roomlist" => $roomlist,
					 "bracketlist" => $bracketlist,
					 "pbracketlist" => $pbracketlist,
					 "snumber" => $snumber);
	}
}
?>
