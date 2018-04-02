<?php

namespace app\models\DAO;

class TeamDAO extends \app\core\DAO
{

    /**
     * @param $arguments
     * @return array
     */
    protected function objectToArray($object)
    {
        $array['team'] = [];

        if (!empty($object)) {

            /*            $teamArray = (array)$arguments[0];

                        foreach ($teamArray as $key => $value) {
                            $prop = trim(strtolower(str_replace('Team', '', $key)));
                            if ($prop == 'id') {
                                if (!is_null($value)) {
                                    $array['team'][0]['new'][$prop] = $value;
                                }
                            } elseif ($prop == 'leader' and !is_null($value)) {
                                $array['team'][0]['new'][$prop] = $value['id'];
                            } elseif ($prop == 'name') {
                                $array['team'][0]['new'][$prop] = $value;
                            }
                        }*/
            $array['team']['name'] = $object->getName();
            $array['team']['leader'] = $object->getLeader();
            $array['team']['id'] = $object->getID();
        }
        return $array;
    }

    protected function arrayToArrayOfObject($array)
    {
        $result['team'] = [];

        if ($array != null) {

            foreach ($array as $subArray) {

                //TODO: change for team object needed
                //$task = new Task();
                //if ($subArray['id'] != NULL) $task->setID($subArray['id']);
                //if ($subArray['name'] != NULL) $task->setName($subArray['name']);
                //if ($subArray['priority'] != NULL) $task->setPriority($subArray['priority']);
                //if ($subArray['description'] != NULL) $task->setDescription($subArray['description']);
                //$result['task'][] = $task;

            }

        }

        return $result;
    }
}
