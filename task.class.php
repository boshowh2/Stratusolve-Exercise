<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource,true); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
    }
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
		$newID = -1;
		try{
			$newID =  max(array_column($this->TaskDataSource, 'TaskId')) + 1; //only supported for >= php 7
		}
		catch(Exception $e){
			foreach($this->TaskDataSource as $task) {
				if($task['TaskId'] >= $newID){
					$newID = $task['TaskId'] + 1;
				}
			}
		}
		if ($newID == -1)
			return 1;
		
        return $newID; // Placeholder return for now
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
			$this->TaskId = $Id;
			$arr = $this->TaskDataSource;
			foreach($arr as $task) {
				if($task['TaskId'] == $Id){
					$this->TaskName = $task['TaskName'];
					$this->TaskDescription = $task['TaskDescription'];
				}
			}
			return $this;
        } else
            return null;
    }

    public function Save() {
        //Assignment: Code to save task here
				
		$newTaskList = [];
		$updated = false;
		
		$arr = $this->TaskDataSource;
		
		foreach($this->TaskDataSource as $key=>$existingTask){
			if($existingTask['TaskId'] == $this->TaskId)
			{
				$this->TaskDataSource[$key] = $this;
				$updated = true;
				break;
			}
		}
		
		if(!$updated)
			$this->TaskDataSource[] = $this;
				
		$fh = fopen( 'Task_Data.txt', 'w' );
		fwrite($fh, json_encode($this->TaskDataSource));
		fclose($fh);
    }
    public function Delete() {
        //Assignment: Code to delete task here
		
		foreach($this->TaskDataSource as $key=>$existingTask){
			if($existingTask['TaskId'] == $this->TaskId)
				{
					if(sizeof($this->TaskDataSource) > 1)
						unset($this->TaskDataSource[$key]);
					else
						$this->TaskDataSource = array();
					break;
				}
		}
		
		$fh = fopen( 'Task_Data.txt', 'w' );
		fwrite($fh, json_encode($this->TaskDataSource));
		fclose($fh);
    }
	
	public function getTaskName() {
		return $this->TaskName;
	}
	
	public function setTaskName($name) {
		$this->TaskName = $name;
	}
	
	public function getTaskId() {
		return $this->TaskId;
	}
	public function setTaskId($id) {
		$this->TaskId = $id;
	}
	
	public function getTaskDescription() {
		return $this->TaskDescription;
	}
	
	public function setTaskDescription($description) {
		$this->TaskDescription = $description;
	}
}
?>