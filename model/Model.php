<?php
//Abstract Model class
abstract class Model
{
	protected $templatedb, $counterdb, $bracketdb, $scheduledb, $teamdb, $mysqli, $title, $headertext;

	//All models have to be initialised
	abstract protected function __construct();

	//Initialises the MySQL connection
	public function init()
	{
		require_once("dbnames.inc");
		require_once($_dbconfig);
		$this->templatedb = $_templatedb;
		$this->counterdb = $_counterdb;
		$this->bracketdb = $_bracketdb;
		$this->scheduledb = $_scheduledb;
		$this->teamdb = $_teamdb;
		$this->mysqli = $mysqli;
	}

	protected function getschedulelist()
	{
		$schedulequery = $this->mysqli->query("SELECT * FROM $this->templatedb " .
			"ORDER BY teams ASC, games ASC, rounds ASC") or die($this->mysqli->error);
		$schedulelist = array();
		while($sdetail = $schedulequery->fetch_assoc())
			$schedulelist[$sdetail['teams']][$sdetail['url']] = array(
				"description" => $sdetail['description'] . " (" . $sdetail['rounds'] . " rounds" .
				($sdetail['games'] == $sdetail['rounds'] ? "" : ", " . $sdetail['games'] . " games minimum") .")",
				"rounds" => $sdetail['rounds'],
				"brackets" => $sdetail['brackets'],
				"playoffbrackets" => $sdetail['playoffbrackets']);
		return $schedulelist;
	}

	//Used so the Controller can know what Model we're using
	abstract protected function gettype();

	//Almost invariably, the Controller will call this function
	//Used to store necessary values from the URL
	abstract protected function setparams($params);

	public function gethash($snumber)
	{
		$hashstr = "Recombobulator" . $snumber;
		return(substr(md5($hashstr), $number % 25, 6));
	}
}
?>
