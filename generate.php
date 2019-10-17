<?php
include("../../../protected/dbconfigi.inc");
session_start();
if($_SERVER['HTTP_REFERER'] == "http://hdwhite.org/login.php")
	echo("<script>window.opener.location.reload(true);\nwindow.close();</script>");
parse_str($_POST['post'], $postdata);
if($postdata['submit'] == "Save schedule")
	$_SESSION['post'] = $postdata;
else
	$postdata = $_SESSION['post'];
if(!isset($postdata['submit'])) exit;
$postdata = array_map('htmlentities', $postdata);
$schedulelist = $mysqli->query("SELECT * FROM schedules ORDER BY teams ASC, games ASC, rounds ASC");
$teamlist = array_map('trim', array_filter(explode("\n", $postdata['teams'])));
$bracketlist = array_map('trim', array_filter(explode("\n", $postdata['brackets'])));
$roomlist = array_map('trim', array_filter(explode("\n", $postdata['rooms'])));
$tourneyname = $postdata['name'];
$url = $postdata['format'];
$finfo = $mysqli->query("SELECT * FROM schedules WHERE url='$url' LIMIT 0,1")->fetch_assoc();
$teams = $finfo['teams'];
$games = $finfo['games'];
$rounds = $finfo['rounds'];
$pagestr = "<?php\n";
$pagestr .= "\$url = \"$url\";\n";
$pagestr .= "\$tourneyname = \"$tourneyname\";\n";
$pagestr .= "\$teamlist = array(\"" . implode($teamlist, "\", \"") . "\");\n";
$pagestr .= "\$bracketlist = array(\"" . implode($bracketlist, "\", \"") . "\");\n";
$pagestr .= "\$roomlist = array(\"" . implode($roomlist, "\", \"") . "\");\n";
$pagestr .= "\$teams = \"$teams\";\n";
$pagestr .= "\$games = \"$games\";\n";
$pagestr .= "\$rounds = \"$rounds\";\n";
$pagestr .= "include(\"template.php\");";
$pagestr .= "?>\n";
echo $pagestr;
file_put_contents("vtsi.php", $pagestr);
?>
