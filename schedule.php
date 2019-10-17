<?php
$dbname = "quizbowl";
$dbuser = "quizbowl";
include("../../../protected/dbconfigi.inc");
session_start();
if($_SERVER['HTTP_REFERER'] == "http://hdwhite.org/login.php")
	echo("<script>window.opener.location.reload(true);\nwindow.close();</script>");
if($_POST['submit'] == "Generate")
	$_SESSION['post'] = $_POST;
else
	$_POST = $_SESSION['post'];
if(!isset($_POST['submit'])) exit;
$schedulelist = $mysqli->query("SELECT * FROM schedules ORDER BY teams ASC, games ASC, rounds ASC");
$_POST = array_map('htmlentities', $_POST);
$teamlist = array_map('trim', array_filter(explode("\n", $_POST['teams'])));
$bracketlist = array_map('trim', array_filter(explode("\n", $_POST['brackets'])));
$roomlist = array_map('trim', array_filter(explode("\n", $_POST['rooms'])));
$tourneyname = $_POST['name'];
$url = $_POST['format'];
$finfo = $mysqli->query("SELECT * FROM schedules WHERE url='$url' LIMIT 0,1")->fetch_assoc();
$teams = $finfo['teams'];
$games = $finfo['games'];
$rounds = $finfo['rounds'];
?>
<html>
	<head>
		<style type="text/css">
			@import url("../../harry.css");
			@import url("schedules.css");
		</style>
		<title><?php echo("$rounds-round schedule for $teams teams"); ?></title>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h2>Quizbowl Schedule Generator</h2>
				<?php include("../header.php"); ?>
			</div>
			<div id="content">
				<div class="entry" style="text-align: center">
					<?php include("$url.php"); ?>
				</div>
				<div class="entry">
					<h4>Edit schedule</h4>
					<form action="schedule.php" method="post">
						<select name="format">
							<?php
								while($sdetail = $schedulelist->fetch_assoc())
								{
									$surl = $sdetail['url'];
									$sname = $sdetail['teams'] . " teams, " . $sdetail['games'] . " games, " . $sdetail['rounds'] . " rounds.";
									echo("<option value='$surl'>$sname</option>");
								}
							?>
						</select><br>
						Tournament name: <input type="text" name="name" id="name" value="<?php echo($tourneyname); ?>"><br>
						Team names:<br>
						<textarea name="teams" id="teams" cols="50" rows="15"><?php echo($_POST['teams']); ?></textarea><br>
						Room numbers:<br>
						<textarea name="rooms" id="rooms" cols="50" rows="8"><?php echo($_POST['rooms']); ?></textarea><br>
						Bracket names:<br>
						<textarea name="brackets" id="brackets" cols="50" rows="5"><?php echo($_POST['brackets']); ?></textarea><br>
						<input type="submit" name="submit" value="Generate">
					</form>
				</div>
				<div class="entry">
					<h4>Save schedule</h4>
					<?php if(isset($_SESSION['loggedin'])) { ?>
					<p>Once you are satisfied with your schedule, you may save it. It will generate an HTML file with your schedule that you can print out or view online. In the future, you will be able to edit your saved schedules and enter in playoff seeds.</p>
					<form action="generate.php" method="post">
						<input type="hidden" name="post" value="<?php echo(http_build_query($_POST)); ?>">
						<input type="submit" name="submit" value="Save schedule">
					</form>
					<?php } else { ?>
					<p>In order to save your schedule, you must be <a href="../../login.php" target="_blank">logged in</a>. This allows you to update the schedule as needed and prevents abuse.</p>
					<?php } ?>
				</div>
			</div>
			<?php include("../../footer.php"); ?>
		</div>
	</body>
</html>
