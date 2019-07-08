<?php
/**
 * This script is to be used to receive a POST with the task id and retrieve the rest of the object data
 */
require('Task.class.php');
	$postdata = json_decode($_POST['taskid']);
	$task = new Task($postdata);
	
	echo json_encode($task);
?>