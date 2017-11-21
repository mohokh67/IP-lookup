<?php

namespace App;

class CSVDatabase
{
    private $CSVFile = __DIR__ . '/../db/db.csv';
    private $connection;

    public function find($ID)
    {
        $this->connect();
        $this->connection->seek($ID);
        return trim($this->connection->current());
    }

    private function connect()
    {
        $this->connection = new \SplFileObject($this->CSVFile);
    }

}
