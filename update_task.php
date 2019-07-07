<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');
// Assignment: Implement this script
	$taskid = $_POST['taskid'];
	$action = $_POST['action'];
	
	$param = $_POST;
	$tasks = file_get_contents('Task_Data.txt');
        if (strlen($tasks) > 0)
            $tasks = json_decode($tasks); 
        else
            $tasks = array(); 

	$task = "";
	$succeeded = false;
	if($action == "update") {
		// Check if task name was specified
		if(!$_POST['name'] or $_POST['name'] == "") {
			$response = array("result"=>$succeeded, "message"=>"Please provide a name for the task");
			
			echo json_encode($response);
		}
		else
		{
			if($taskid > 0)
				$task = new Task($taskid);
			else
				$task = new Task();
			
			if($_POST['name'] or $_POST['name'] != "")
				$task->setTaskName($_POST['name']);
			
			$task->setTaskDescription($_POST['description']);
		
		
			$task->Save();
		
			$succeeded = true;
		}
	}
	else if ($action == "delete") {
		$task = new Task($taskid);
		$task = $task->Delete();
		$succeeded = true;
	}
	else {
		$response = array("result"=>$succeeded, "message"=>"The specified action is not supported: ".$action);
			
		echo json_encode($response);
	}
	
	if($succeeded == true)
	{
		$response = array("result"=>$succeeded);
		
		echo json_encode($response);
	}
?>