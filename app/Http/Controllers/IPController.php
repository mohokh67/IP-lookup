<?php

namespace App\Http\Controllers;


/**
 * Class IPController
 * @package App\Http\Controllers
 */
class IPController
{
    private $ip;
    private $utility;
    private $database;

    /**
     * IPController constructor.
     * @param $utility
     * @param $database
     */
    public function __construct(Utility $utility, \App\CSVDatabase $database)
    {
        $this->utility = $utility;
        $this->database = $database;
    }

    public function getIP()
    {
        return $this->ip;
    }

    public function setIP($ip)
    {
        $this->ip = $ip;
    }

    public function v6ToNum($ip)
    {
        $binaryNum = '';
        foreach (unpack('C*', inet_pton($ip)) as $byte) {
            $binaryNum .= str_pad(decbin($byte), 8, "0", STR_PAD_LEFT);
        }
        $binToInt = base_convert(ltrim($binaryNum, '0'), 2, 10);

        return $binToInt;
    }

    /**
     * Check if the ip is valid
     */
    public function validate()
    {
        return @inet_pton($this->ip) !== false;
    }

    /**
     * @param $begin : lowest index in array or chunk
     * @param $end : biggest or highest index in array or chunk
     * @return int : -1: not found, >=0 means founded index
     */
    public function find($begin, $end)
    {
        $end = $end - 1;
        $steps = 0; // if we are keen to find out in how many steps we found the result
        $foundIndex = -1;

        while ($begin <= $end) {
            $middle = (int)(($end - $begin) / 2) + $begin;

            $IPs = $this->utility->parseLine($this->database->find($middle));

            $compare = $this->inRange($IPs[0], $IPs[1]);

            if ($compare < 0) {
                $begin = $middle + 1;
            } elseif ($compare > 0) {
                $end = $middle - 1;
            } else {
                // found it
                $foundIndex = $middle;
                break;
            }
            $steps++;
        }
        return $foundIndex;
    }

    /**
     * whether if the given IP is in rage
     * @param string $lowRange low range IP
     * @param string $upperRange upper range IP
     * @return bool
     */
    public function inRange($lowRange, $upperRange)
    {
        $ipVersion = $this->whichIP();

        if($ipVersion == 1) {
            //ipv4
            $needle = ip2long($this->ip);
            $low = ip2long($lowRange);
            $upper = ip2long($upperRange);
        } elseif ($ipVersion == 2){
            //ipv6
            $needle = $this->v6ToNum($this->ip);
            $low =  $this->v6ToNum($lowRange);
            $upper =  $this->v6ToNum($upperRange);
        }

        if ($needle < $low) {
            return 1;
        } elseif ($needle > $upper) {
            return -1;
        } else {
            return 0;
        }
    }

    /**
     *  Whether if the IP is version 6 or not
     *  An IPv6 address can have two formats:
     *  https://www.ibm.com/support/knowledgecenter/STCMML8/com.ibm.storage.ts3500.doc/opg_3584_IPv4_IPv6_addresses.html
     *  Normal - Pure IPv6 format
     *  2001 : db8: 3333 : 4444 : 5555 : 6666 : 7777 : 8888
     *  Dual - IPv6 plus IPv4 formats
     *  2001 : db8: 3333 : 4444 : 5555 : 6666 : 1 . 2 . 3 . 4
     * @return boolean
     */
    public function isIPv6($ip) {
        if(strpos($ip, ":") !== false && strpos($ip, ".") === false) {
            return true; //Pure format
        }
        elseif(strpos($ip, ":") !== false && strpos($ip, ".") !== false){
            return true; //dual format
        }
        else{
            return false;
        }
    }


    /**
     * Whether if the ip is v4 or v6
     * @return int
     * 0: not valid
     * 1: v4
     * 2: v6
     */
    public function whichIP()
    {
        $result = 0;
        if($this->validate()) {
            if (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $result = 1;
            } elseif (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $result = 2;
            }
        }
        return $result;
    }
}
