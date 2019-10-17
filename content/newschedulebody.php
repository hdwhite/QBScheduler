<div id="content">
	<div class="entry">
		<h4>Permanent link to this schedule: <a href="http://hdwhite.org/qb/schedules/<?=$snumber ?>">http://hdwhite.org/qb/schedules/<?=$snumber ?></a></h4>
		<p>You may continue to make edits to this schedule as desired while on this page. The above link will be adjusted accordingly while you are on this page. If you wish to continue to make edits to this page after you leave it, please save <a href="http://hdwhite.org/qb/schedules/editschedule/<?=$snumber ?>/<?=$pagehash ?>">this link</a>.</p>
	</div>
	<div class="entry" style="text-align: center">
		<?php include_once("content/phrases.php");
		      include("content/templates/$url.php"); ?>
	</div>
	<?php include("content/scheduleform.php"); ?>
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
