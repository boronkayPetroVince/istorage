<?php
use App\Kernel;

//try{
//    $dbh = new pdo( 'mysql:host=130.61.174.6:3306;dbname=istorage',
//        'effi',
//        '123',
//        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//    die(json_encode(array('outcome' => true)));
//}
//catch(PDOException $ex){
//    die(json_encode(array('outcome' => false, 'message' => $ex->getMessage())));
//}
//return;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

$_SERVER['APP_ENV']='dev';
$_SERVER['DATABASE_URL']='mysql://effi:123@130.61.174.6:3306/istorage?serverVersion=5.7';


return function (array $context) {

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
