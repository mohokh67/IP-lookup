<?php

namespace App;

use App\Http\Controllers\IPController;
use App\Http\Controllers\Utility;
use PHPUnit\Framework\TestCase as testCase;

class IPControllerTest extends TestCase
{
    public $IPController;

    public function setUp()
    {
        $utility = new Utility();
        $database = new CSVDatabase();
        $this->IPController = new IPController($utility, $database);
    }


    public function testItShouldTakeAnIP()
    {
        $inputIP = '127.0.0.1';
        $this->IPController->setIP($inputIP);
        $IP = $this->IPController->getIP();
        $this->assertEquals($inputIP, $IP);
    }

    public function testItShouldValidateIPV4()
    {
        $inputIP = '127.0.0.1';
        $this->IPController->setIP($inputIP);
        $result = $this->IPController->validate($inputIP);
        $this->assertTrue($result);
    }

    public function testItShouldValidateIPV6()
    {
        //$inputIP = '2001:0000:3238:DFE1:0063:0000:0000:FEFB';
        $inputIP = '2001:0000:3238:DFE1:63::FEFB';
        $this->IPController->setIP($inputIP);
        $result = $this->IPController->validate($inputIP);
        $this->assertTrue($result);
    }
}
