<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
	$postdata = json_decode($_POST['taskid']);
	$task = new Task($postdata);
	
	echo json_encode($task);
?>