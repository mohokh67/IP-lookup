<?php
ini_set('max_execution_time', 200);
//$start = microtime(true);
require __DIR__.'/bootstrap/autoload.php';

use App\Http\Controllers\Utility;
use App\Http\Controllers\IPController;
use App\CSVDatabase;

$utility = new Utility();
$database = new CSVDatabase();
$IPController = new IPController($utility, $database);
$ipc = new IPController($utility, $database);

$validateIP = false;
if(isset($_GET['ip'])){
    $ip = $_GET['ip'];
    $IPController->setIP($ip);
    $validateIP = $IPController->validate();

    if(!$validateIP) {
        http_response_code(400);
        include_once ('400.php');
        die();
    }
}

if($validateIP) {

    //$DBRecordCount = $utility->getFileTotalLine(CSV_FILE); // 13 580 079
    $DBRecordCount = $end = 13580079;
    $begin = 0;
    $lineNumber = $IPController->find($begin, $end);
    if($lineNumber >=0 ) {
        $line = $database->find($lineNumber);
        echo '<pre>';
        echo ($utility->formatJSON($line, $ip));
        echo '</pre>';
    } else {
        echo 'NOT FOUND';
    }

}


?>

<form>
    <input placeholder="Enter the IP address" name="ip">
    <button>Search</button>
</form>

<?php
//echo '<hr>';
//echo '<pre>Page generated in ' . round((microtime(true) - $start), 4) . ' seconds.</pre>';

