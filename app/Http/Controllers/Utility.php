<?php

namespace App\Http\Controllers;

class Utility
{
    /**
     * @param $filename
     * @return int
     */
    public function getFileTotalLine($filename)
    {
        $lineCount = 0;
        $fileHandler = fopen($filename, 'rb');
        while (fgets($fileHandler) !== false) {
            $lineCount++;
        }
        fclose($fileHandler);
        return $lineCount;
    }

    /**
     * @param $line
     * @return array
     */
    public function parseLine($line)
    {
        $result = [];
        $thisLine = explode(',', $line);

        $result[] = trim($thisLine[0], '"');
        $result[] = trim($thisLine[1], '"');

        return $result;
    }

    /**
     * @param $line
     * @param $ip
     * @return string
     */
    public function formatJSON($line, $ip){
        $items = explode(',', $line);
        $items = array_map(function($item){
            return trim($item, '"');
        }, $items);
        $response = array(
            'city'          => $items[3],
            'region'        => $items[2],
            'ip'            => $ip,
            'rangeStart'    => $items[0],
            'rangeEnd'      => $items[1]
        );
        return json_encode($response,JSON_PRETTY_PRINT);
    }
}
