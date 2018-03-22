<?php

class Team extends Entity {

    private $teamName;
    private $teamMember = array();
    private $teamLeader;
    private $teamTask = array();


    public function __construct($idMember)
    {
        $this->teamMember[0] = new Member($idMember);
    }


    public function set_tName($new_teamName) {                              //save in database
		$this->teamName = $new_teamName;
	}
	public function get_tName() {                                           // from database
		return $this->teamName;
	}	

	public function set_tMember($new_IdMember) {
        //$new_IdMember  must be tested before , if exists in teamMember throw exception and propose another teamMemeber)
        array_push($this->teamMember,$new_IdMember);            //save in database
	}

	public function get_tMember() {
		//or get from database
        return $this->teamMember;
	}	
	
	
	public function set_tLeader($new_teamLeader) {
		$this->teamLeader = $new_teamLeader;
	}
	public function get_tLeader() {
		return $this->teamLeader;
	}

	public function set_tTask($new_teamTask){
        array_push($this->teamTask, $new_teamTask);           //save in database	}
    }
        public function get_tTask() {
		return $this->teamTask; // or get from database
	}

    public function entityToArray() {
        return get_object_vars($this);
    }

}