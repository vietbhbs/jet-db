<?php

namespace Viettqt\JetDB;

class Raw
{

    protected array $PARAMS = [];
    protected $QUERY;

    public function setRawData($query, array $values): void
    {
        $this->QUERY = $query;
        $this->PARAMS = $values;
    }

    public function getRawQuery()
    {
        return $this->QUERY;
    }

    public function getRawValues(): array
    {
        return $this->PARAMS;
    }
}