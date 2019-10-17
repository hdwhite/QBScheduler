<?php
//The View class used for all the pages (so far)
class NewScheduleView extends View
{
	//Creates the page to be echoed by the main page
	public function output()
	{
		//Gets the necessary data and turns them into variables
		extract($this->model->getdata());

		ob_start();
		include("content/header.php");
		include("content/schedule.php");
		include("content/footer.php");
		$filestring = ob_get_contents();
		ob_end_clean();
		$pagehash = $this->model->gethash($snumber);

		//Creates an output buffer to prevent anything from being printed quite yet
		ob_start();

		//All pages have very similar headers and footers, and an associated main
		//content section
		include("content/formheader.php");
		include("content/" . $this->model->gettype() . "body.php");
		include("content/footer.php");

		//Stores the buffer as a string and clears it
		$outstring = ob_get_contents();
		ob_end_clean();

		if(!is_numeric($snumber)) die();
		if(!is_dir($snumber)) mkdir("$snumber");
		$handle = fopen("$snumber/index.html", 'w');
		fwrite($handle, $filestring);
		fclose($handle);
		return $outstring;
	}
}
?>
