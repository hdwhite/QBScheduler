<?php
//URLs are of the form http://hdwhite.org/qb/stats/[PAGE]/[QUERY1]/[QUERY2]
$urlarray = explode("/", $_SERVER['REQUEST_URI']);
$page = htmlentities($urlarray[3]);
$params = array_map('htmlentities', array_slice($urlarray, 4));

//At the moment all the pages use the same View and Controller, though that might change
switch($page)
{
	case "newschedule":
		if(!isset($_POST['submit']))
		{
			header("Location: http://hdwhite.org/qb/schedules");
			exit();
		}
		$model = "NewScheduleModel";
		$view = "NewScheduleView";
		$controller = "Controller";
		break;
	default:
		$model = "IndexModel";
		$view = "View";
		$controller = "Controller";
}

//Get the associated classes
//Variable names are limited to what is produced by the switch statement,
//so $_GET abuse won't happen here
require_once("model/Model.php");
require_once("view/View.php");
require_once("model/$model.php");
require_once("view/$view.php");
require_once("controller/$controller.php");

//Initialise the classes
session_start();
$model = new $model();
$controller = new $controller($model);
$view = new $view($controller, $model);

//Pass the parameters to the controller
$controller->params($params);

//Output the page
echo($view->output());
?>
