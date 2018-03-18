<?php

class TeamController{
    /**
     * Show information for one team
     */

    public function __construct()
    {
        $perms = [
            'index' => ['public' => false, 'connect' => true],
            'save' => ['public' => false, 'connect' => true],
            'showAction' => ['public' => false, 'connect' => true]
        ];
        $this->setPermissions($perms);
    }

    public function showAction(){
    }
    public function save($teamName, $teamID, $teamMember, $teamLeader, $teamTask) {
        $storageFactory = new StorageFactory();
        $team = new team($storageFactory->getStorage());
        $team->setFirstName($teamName);
        $team->setLastName($teamID);
        $team->setTeamMember($teamMember);
        $team->setTeamLeader($teamLeader);
        $team->setPassword($teamTask);
        /*
        $teamService = new TeamService();
        $teamService->save($team);
        */
        $vue = new UserView();
        if($team->save()){
            $vue->displayTeam($team);
        } else {
            $vue->displayError($team->getErrors());
        }
    }
/**
    public function listAction(){
    }
    public function addAction(){
    }
    public function editAction(){
    }
 */
}