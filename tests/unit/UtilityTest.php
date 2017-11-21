<?php

namespace App;

use App\Http\Controllers\Utility;
use PHPUnit_Framework_TestCase as testCase;

class UtilityTest extends TestCase
{
    public $utility;

    public function setUp()
    {
        $this->utility = new Utility();
    }

    public function testItShouldParseALine()
    {
        $line = '"5.57.56.0","5.57.63.255","GB","Greater London","Camden Town"';
        $result = $this->utility->parseLine($line);
        $this->assertEquals('5.57.56.0', $result[0]);
        $this->assertEquals('5.57.63.255', $result[1]);
    }

    public function testItShouldGetTotalLine()
    {
        $filename = __DIR__ . '/text.txt';
        $totalLines = $this->utility->getFileTotalLine($filename);
        $this->assertEquals(3, $totalLines);
    }

    public function testItShouldConvertStringToJSON()
    {
        $input = '"5.57.56.0","5.57.63.255","GB","Greater London","Camden Town"';
        $ip = "5.57.58.101";
        $expected = '{"city":"Greater London","region":"GB","ip":"5.57.58.101","rangeStart":"5.57.56.0","rangeEnd":"5.57.63.255"}';
        $result = $this->utility->formatJSON($input, $ip);
        $this->assertEquals($expected, $result);
    }

}
