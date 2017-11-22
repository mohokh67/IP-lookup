<?php

namespace App;

use PHPUnit\Framework\TestCase as testCase;

class CSVDatabaseTest extends TestCase
{
    public $database;

    public function setUp()
    {
        $this->database = new CSVDatabase();
    }

    public function testItShouldFindALine()
    {
        $lineNumber = 3;
        $expected = '"1.0.4.0","1.0.7.255","AU","Victoria","Melbourne"';
        $line = $this->database->find($lineNumber);
        $this->assertEquals($line, $expected);
    }
}
