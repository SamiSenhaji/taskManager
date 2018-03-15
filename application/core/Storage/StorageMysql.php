<?php

require_once 'application/core/Storage/Storage.php';

class StorageMysql extends Storage
{
    protected $type = 'mysql';

    function __construct()
    {
        $config = parse_ini_file('application/core/config.ini');
        try {
            $this->connection = new PDO(
                $this->type .
                ":host=" . $config['mysqlHost'] .
                ";port=" . $config['mysqlPort'] .
                ";dbname=" . $config['mysqlDb'],
                $config['mysqlUser'],
                $config['mysqlPassword']
            );
            $this->connection->errorInfo();
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
            die();
        }
    }

    function __destruct()
    {
        $connection = null;
    }

    public function create(array $data)
    {
        $sql = "";
        foreach ($data as $table => $array) {

            $field = "";
            $value = "";

            foreach ($array as $arrayKey => $arrayValue) {
                if (!is_array($arrayValue)) {
                    $field .= "`" . $arrayKey . "`, ";
                    if (!empty($arrayValue)) {
                        $value .= "'" . $arrayValue . "', ";
                    } else {
                        $value .= "NULL, ";
                    }
                } else {
                    //TODO: ajout gestion tableau
                    /*
                    switch (strtolower($table)) {
                        case "member":
                            echo "member";
                            break;
                        case "task":
                            echo "task";
                            break;
                        default:
                            echo "Default";
                    }
                    */
                }

            }
            $field = trim($field, ", ");
            $value = trim($value, ", ");

            $sql .= "INSERT INTO tbl_" . $table . " (" . $field . ") VALUES (" . $value . ");";

        }

        $request = $this->query($sql);

        if ($request->errorInfo()[0] != "00000") {
            var_dump($request->errorInfo());
            return false;
        }

        return true;
    }

    public function read(array $data)
    {
        $sql = "";

        foreach ($data as $table => $array) {

            if (!empty($array)) {

                $value = "";

                foreach ($array as $arrayKey => $arrayValue) {
                    if (!is_array($arrayValue)) {
                        if (!empty($arrayValue)) {
                            $value .= $arrayKey . " = '" . $arrayValue . "' AND ";
                        }
                    } else {
                        //TODO: ajout gestion tableau status & subtask
                    }
                }
                $value = trim($value, "AND ");

                $sql .= "SELECT * FROM tbl_" . $table . " WHERE " . $value . ";";

            } else {

                $sql .= "SELECT * FROM tbl_" . $table . ";";

            }

        }

        $request = $this->query($sql);

        if ($request->errorInfo()[0] != "00000") {
            var_dump($request->errorInfo());
            return false;
        }

        $result = $request->fetch(PDO::FETCH_ASSOC);
        // remove reserved id for database
        unset($result['id' . ucfirst($table)]);

        return $result;
    }

    public function update(array $data)
    {
        $sql = "";

        foreach ($data as $table => $array) {

            $id = "";
            $value = "";

            foreach ($array as $arrayKey => $arrayValue) {
                if (!is_array($arrayValue)) {
                    if (!empty($arrayValue)) {
                        if ($arrayKey == 'id') {
                            $id .= "`id` = '" . $arrayValue . "'";
                        } else {
                            $value .= "`" . $arrayKey . "` = '" . $arrayValue . "', ";
                        }
                    }
                } else {
                    //TODO: ajout gestion tableau status & subtask
                }
            }
            $value = trim($value, ", ");

            $sql .= "UPDATE tbl_" . $table . " SET " . $value . " WHERE " . $id . ";";

        }

        $request = $this->query($sql);

        if ($request->errorInfo()[0] != "00000") {
            var_dump($request->errorInfo());
            return false;
        }

        return true;
    }

    public function delete(array $data)
    {
        $sql = "";

        foreach ($data as $table => $array) {
            $value = "";

            foreach ($array as $arrayKey => $arrayValue) {

                // si la valeur n'est pas un tableau
                if (!is_array($arrayValue)) {

                    // si la valeur n'est pas vide , on l'ajoute à $value
                    if (!empty($arrayValue)) {
                        $value .= $arrayKey . " = '" . $arrayValue . "' AND ";
                    }
                } else {
                    //TODO: ajout gestion tableau status & subtask
                }
            }
            $value = trim($value, "AND ");

            $sql .= "DELETE FROM tbl_" . $table . " WHERE " . $value . ";";

        }

        $request = $this->query($sql);

        if ($request->errorInfo()[0] != "00000") {
            var_dump($request->errorInfo());
            return false;
        }

        return true;
    }

    public function query($sql)
    {
        try {
            $request = $this->connection->prepare($sql);
            $request->execute();
            return $request;
        } catch (PDOException $e) {
            echo "Error !: " . $e->getMessage() . PHP_EOL;
        }
    }

}