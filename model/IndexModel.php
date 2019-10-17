<?php
//The Model used for the index page. It's mostly static, so not much needs to be done
class IndexModel extends Model
{
	//Initialises
	public function __construct()
	{
		$this->init();
		$this->title = "Quizbowl schedule generator";
		$this->headertext = "Quizbowl Schedule Generator";
	}
	public function gettype()
	{
		return "index";
	}
	//The index page doesn't care about any additional parameters, so this
	//function can be left blank
	public function setparams($params)
	{
	}
	//Retreives necessary data about the Index page
	public function getdata()
	{
		$schedulelist = $this->getschedulelist();
		return array("title" => $this->title, "headertext" => $this->headertext, "schedulelist" => $schedulelist);
	}
}
?>
