<?php

namespace Viettqt\JetDB;

use PDO;
use stdClass;

class Builder
{
    use Process;

    protected $CONFIG;
    protected $TABLE;
    protected array $PARAMS = [];
    protected string $ACTION = 'select';
    protected array $SOURCE_VALUE = [];

    protected string $PRIMARY_KEY = 'id';
    protected bool $TIMESTAMPS = false;
    protected string $CREATED_AT = 'created_at';
    protected string $UPDATED_AT = 'updated_at';


    public function setTable($name): void
    {
        $this->TABLE = $name;
    }

    public function setConfig($config): void
    {
        $this->CONFIG = $config;
    }

    public function setAction($action): static
    {
        $this->ACTION = $action;
        return $this;
    }

    public function getAction(): string
    {
        return $this->ACTION;
    }

    public function setPrimaryKey(string $value): void
    {
        $this->PRIMARY_KEY = $value;
    }

    public function setTimestampsStatus(bool $value, $set_created_at_name = false, $set_updated_at_name = false): void
    {
        $this->TIMESTAMPS = $value;

        if ($set_created_at_name) {
            $this->CREATED_AT = $set_created_at_name;
        }

        if ($set_updated_at_name) {
            $this->UPDATED_AT = $set_updated_at_name;
        }
    }

    protected function execute($query, $params = [], $return = false)
    {
        $this->CONFIG->connect();
        $this->PARAMS = $params;

        if ($this->PARAMS == null) {
            $stmt = $this->CONFIG->pdo()->query($query);
        } else {
            $stmt = $this->CONFIG->pdo()->prepare($query);
            $stmt->execute($this->PARAMS);
        }

        if ($return) {
            $result = $stmt->fetchAll($this->CONFIG->getFetch());
        } else {
            $result = $stmt->rowCount();
        }


        return $result;
    }

    public function setTimestamps(array &$values, $just_update = false): void
    {
        if ($this->TIMESTAMPS) {
            $now = date('Y-m-d H:i:s');
            if (!$just_update) {
                $values[$this->CREATED_AT] = $now;
            }
            $values[$this->UPDATED_AT] = $now;
        }
    }

    public function insert(array $values, $get_last_insert_id = false)
    {
        $this->setAction('insert');
        $query = $this->makeInsertQueryString($values);
        $result = $this->execute($query, $this->PARAMS);

        if (!$get_last_insert_id) {
            return $result;
        } else {
            return $this->CONFIG->pdo()->lastInsertId();
        }
    }

    protected function makeInsertQueryString(array $values): string
    {
        $param_name = [];
        $param_value_name_list = [];

        $this->setTimestamps($values);

        foreach ($values as $name => $value) {
            $param_name[] = $this->fix_column_name($name)['name'];
            $param_value_name_list[] = $this->add_to_param_auto_name($value);
        }

        return "INSERT INTO `$this->TABLE` (" . implode(',', $param_name) . ") VALUES (" . implode(',', $param_value_name_list) . ")";
    }

    public function truncate()
    {
        return $this->execute("TRUNCATE `$this->TABLE`");
    }
}