<?php

require_once realpath('application/models/Storage/Storage.php');

class StorageMysql extends Storage
{
    protected $type = 'mysql';

    public function __construct()
    {
        $config = parse_ini_file(realpath('application/core/config.ini'));
        try {
            $this->connection = new PDO($this->type . ":host=" . $config['mysqlHost'] . ";port=" . $config['mysqlPort'] . ";dbname=" . $config['mysqlDb'], $config['mysqlUser'], $config['mysqlPassword']);
            $this->connection->errorInfo();
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
            die();
        }
    }

    public function create(array $data)
    {
        $sql = "";
        foreach ($data as $table => $array) {

            foreach ($array as $arrayValue) {
                $field = "";
                $value = "";

                foreach ($arrayValue as $listKey => $listValue) {
                    $field .= "`" . trim(strtolower($listKey)) . "`, ";
                    if (!empty(trim($listValue))) {
                        $value .= "'" . trim(strtolower($listValue)) . "', ";
                    } else {
                        $value .= "'NULL', ";
                    }
                }
                $field = trim($field, ", ");
                $value = trim($value, ", ");

                $sql .= "INSERT INTO tbl_" . $table . " (" . $field . ") VALUES (" . $value . ");";

            }

        }

        try {
            $request = $this->connection->prepare($sql);
            $request->execute();
            return $request->errorInfo();
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
        }
    }

    public function createTask($day, $task)
    {
        try {
            $sql = "
            INSERT INTO tbl_task 
            (
                Id,
                Name,
                Priority,
                Day
            )
            VALUES
            (
                NULL, " .
                "'" . $task->getName() . "'," .
                "'" . $task->getPriority() . "',
                (SELECT Id FROM tbl_day WHERE Name='" . $day->getName() . "')
            )";
            $this->connection->query($sql);
            $this->connection->errorInfo();
            return true;
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    public function readTask($day)
    {
        try {
            $sql = "
                SELECT Name, Priority
                FROM tbl_task
                WHERE Day = (SELECT Id FROM tbl_day WHERE Name='" . $day->getName() . "')
            ";
            $data = $this->connection->query($sql);
            $this->connection->errorInfo();

            $day = new Day($day->getName());
            foreach ($data as $value) {
                $task = new Task($value['Name']);
                $task->setPriority($value['Priority']);
                $day->addTask($task);
            }

            return $day;
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    public function updateTask($day, $newTask, $oldTask)
    {
        try {
            $sql = "
                UPDATE tbl_task 
                SET
                    Name = '" . $newTask->getName() . "',
                    Priority = '" . $newTask->getPriority() . "'
                WHERE Name = '" . $oldTask->getName() . "' AND Day = (SELECT Id FROM tbl_day WHERE Name='" . $day->getName() . "')
            ";
            $this->connection->query($sql);
            $this->connection->errorInfo();
            return true;
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    public function deleteTask($day, $task)
    {
        try {
            $sql = "DELETE 
                FROM tbl_task 
                WHERE Name = '" . $task->getName() . "' AND Day = (SELECT Id FROM tbl_day WHERE Name='" . $day->getName() . "')
            ";
            $this->connection->query($sql);
            $this->connection->errorInfo();
            return true;
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    public function showTables()
    {
        foreach ($this->connection->query('SHOW TABLES') as $row) {
            print_r($row);
        }
    }

    public function load()
    {
        $week = new Week();

        $sql = "
          SELECT tbl_day.Name as day, tbl_task.Name as task, tbl_task.Priority as priority 
          FROM tbl_task 
          INNER JOIN tbl_day on tbl_task.Day = tbl_day.Id
        ";
        $data = $this->connection->query($sql);

        foreach ($data as $value) {
            $dataAssoc[$value['day']][] = array($value['task'], $value['priority']);
        }

        foreach ($dataAssoc as $day => $value) {
            $day = new Day($day);
            foreach ($value as $taskValue) {
                $task = new Task($taskValue[0]);
                $task->setPriority($taskValue[1]);
                $day->addTask($task);
            }
            $week->setDay($day);
        }

        return $week;
    }

    public function save($week)
    {
        try {
            $sql = "TRUNCATE TABLE tbl_task";
            $this->connection->query($sql);
            $this->connection->errorInfo();

            foreach ($week->getDays() as $day) {
                foreach ($day->getTasks() as $task) {
                    $this->createTask($day, $task);
                }
            }

            return true;
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    public function closeconnection()
    {
        $connection = null;
    }
}