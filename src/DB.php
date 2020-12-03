<?php

namespace App;

use PDO;
use PDOException;

class DB extends \PDO
{
    static $instance;
    protected array $config;

    static function singleton()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $config = $this->loadConf();
        //Determinar entorno
        $strdbconf = 'dbconf_' . $this->env();
        $dbconf = (array) $config->$strdbconf;

        $dsn = $dbconf['driver'] . ':host=' . $dbconf['dbhost'] . ';dbname=' . $dbconf['dbname'];
        $usr = $dbconf['dbuser'];
        $pwd = $dbconf['dbpass'];
        parent::__construct($dsn, $usr, $pwd);
    }

    private function loadConf()
    {
        $file = "config.json";
        $jsonStr = file_get_contents($file);
        $arrayJson = json_decode($jsonStr);
        return $arrayJson;
    }
    private function env()
    {
        $ipAddress = gethostbyname($_SERVER['SERVER_NAME']);
        if ($ipAddress == '127.0.0.1') {
            return 'dev';
        } else {
            return 'pro';
        }
    }
    //Funciones DB
    // funció d'inserció de registres en taula
    function insert($table, array $data): bool
    {
        if (is_array($data)) {
            $columns = '';
            $bindv = '';
            $values = null;
            foreach ($data as $column => $value) {
                $columns .= '`' . $column . '`,';
                $bindv .= '?,';
                $values[] = $value;
            }
            $columns = substr($columns, 0, -1);
            $bindv = substr($bindv, 0, -1);

            $sql = "INSERT INTO {$table}({$columns}) VALUES ({$bindv})";

            try {
                $stmt = self::$instance->prepare($sql);

                $stmt->execute($values);
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }

            return true;
        }
        return false;
    }

    // funció de selecció de  tots els registres
    // pots indicar quins camps vols mostrar
    function selectAll($table, array $fields = null): array
    {
        if (is_array($fields)) {
            $columns = implode(',', $fields);
        } else {
            $columns = "*";
        }

        $sql = "SELECT {$columns} FROM {$table}";

        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    // select with where
    function selectAllWhere($table, array $fields = null, array $conditions): array
    {
        if (is_array($fields)) {
            $columns = implode(',', $fields);
        } else {
            $columns = "*";
        }
        $cond = "{$conditions[0]}='{$conditions[1]}'";

        $sql = "SELECT {$columns} FROM {$table} WHERE {$cond}";

        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    // select amb join sense condició
    function selectAllWithJoin($table1, $table2, array $fields = null, string $join1, string $join2): array
    {
        if (is_array($fields)) {
            $columns = implode(',', $fields);
        } else {
            $columns = "*";
        }

        $inners = "{$table1}.{$join1} = {$table2}.{$join2}";

        $sql = "SELECT {$columns} FROM {$table1} INNER JOIN {$table2} ON {$inners}";

        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    // select amb join amb només una condició
    function selectWhereWithJoin($table1, $table2, array $fields = null, string $join1, string $join2, array $conditions): array
    {
        if (is_array($fields)) {
            $columns = implode(',', $fields);
        } else {
            $columns = "*";
        }

        $inners = "{$table1}.{$join1} = {$table2}.{$join2}";
        $cond = "{$conditions[0]}='{$conditions[1]}'";

        $sql = "SELECT {$columns} FROM {$table1} INNER JOIN {$table2} ON {$inners} WHERE {$cond} ";

        $stmt = self::$instance->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    // funcion de borrar con condición
    function delete($table, array $conditions): bool
    {
        if (is_array($conditions)) {
            $cond = 'WHERE ';
            foreach ($conditions as $column => $value) {
                $cond .= "{$column} = '{$value}' AND ";
            }
            $cond = substr($cond, 0, -5);
        } else {
            $cond = '';
        }

        $sql = "DELETE FROM {$table} {$cond}";
        try {
            $stmt = self::$instance->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
        return true;
    }
    // funció d'actualització de registres en una taula
    function update($table, array $set, array $conditions): bool
    {

        if (is_array($conditions) && is_array($set)) {
            //set
            $update = '';
            foreach ($set as $column => $value) {
                $update .= "{$column} = '{$value}',";
            }
            $update = substr($update, 0, -1);
            //Where
            $cond = '';
            foreach ($conditions as $column => $value) {
                $cond .= "{$column} = '{$value}' AND ";
            }
            $cond = substr($cond, 0, -5);

            $sql = "UPDATE {$table} SET {$update} WHERE {$cond}";
            try {
                $stmt = self::$instance->prepare($sql);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }

            return true;
        }
        return false;
    }
}
