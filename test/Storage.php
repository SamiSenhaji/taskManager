<?php
define('__ROOT__', dirname(dirname(__FILE__)));

require_once __ROOT__ . '/application/models/Entity/Task.php';
require_once __ROOT__ . '/application/models/DAO/TaskDAO.php';
require_once __ROOT__ . '/application/models/DAO/MemberDAO.php';
require_once __ROOT__ . '/application/models/Entity/Member.php';


// Phil, test sauvegarde generique.

/*
$taskDAO = new TaskDAO('mysql');
*/

$taskDAO = new TaskDAO('mysql');

$task = new Task();
$task->setName('Test');
$task->setDay('monday');

$taskRead = new Task();
$taskRead->setId(6);
$taskRead->setName('rdgdgdgtfhfthdt');

//$taskDAO->create($task);

$taskDAO->update($taskRead);

//$task0 = new Task('');
//$task0->setName('testAlbin');
//$task0->setPriority(1);
//
//$result = $taskDAO->create($task0, "monday");

// Albin - delete

/*
$task = new Task('testAlbin');
$task->setPriority(1);

$result = $taskDAO->create($task, "monday");

$task = new Task('testAlbin');
$task->setPriority(1);

$result = $taskDAO->delete($task, "monday");

echo PHP_EOL . $result . PHP_EOL;
*/

/*
$storage = new StorageMysql();

$task0 = new Task();
$task0->setName('test0');
$task0->setPriority(0);
$task1 = new Task();
$task1->setName('test1');
$task1->setPriority(1);
$day0 = new Day('monday');
$day1 = new Day('sunday');
$day0->addTask($task0);
$day0->addTask($task1);
$day1->addTask($task0);
$day1->addTask($task1);
$week = new Week();
$week->setDay($day0);

// Create test
$validTableCreate = [];
$daysArray = $week->getDays();
foreach ($daysArray as $dayKey => $dayObject) {
    $tasksObject = $dayObject->getTasks();

    foreach ($tasksObject as $taskKey => $taskValue) {
        $taskArray = (array)$taskValue;

        foreach ($taskArray as $key => $value) {
            $validTableCreate['tasks'][$taskKey][str_replace('Task', '', $key)] = $value;
        }
        $validTableCreate['tasks'][$taskKey]['day'] = $dayKey + 1;

    }

}


//print_r($storage->create($validTableCreate));

// Read test
$validTableRead['tasks'][0]['day'] = '1';
//print_r($storage->read($validTableRead));

// Delete test
$validTableDelete['tasks'][0]['day'] = '1';
//print_r($storage->delete($validTableDelete));

// Update test

$validTableUpdate['tasks'][0]['get']['name'] = "Test999";
$validTableUpdate['tasks'][0]['set']['day'] = "2";
//print_r($storage->update($validTableUpdate));


$route = new Route();
$route->routeQuery();



if (!empty($_GET['page']) AND is_file(''))
*/

?>
