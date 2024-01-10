<?php
header("Access-Control-Allow-Headers: token, Access-Control-Allow-Headers, api-key, client-id, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization, Access-Control-Allow-Methods, Access-Control-Allow-Origin");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header("Access-Control-Allow-Headers: token, Access-Control-Allow-Headers, api-key, client-id, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization, Access-Control-Allow-Methods, Access-Control-Allow-Origin");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("HTTP/1.1 200 OK");
    die();
}

require_once __DIR__ . '/core/flight/Flight.php';
require_once __DIR__ . '/api.php';
// ini_set('memory_limit', '-1');

Flight::route('GET /getblog', 'getBlog');
Flight::route('POST /tambahblog', 'tambahBlog');

Flight::route('GET /getmahasiswa', 'getMahasiswa');
Flight::route('POST /carimahasiswa', 'cariMahasiswa');
Flight::route('POST /getdetailmahasiswa', 'getDetailMahasiswa');
Flight::route('POST /getdatapembayaran', 'getDataPembayaran');
Flight::route('POST /setdatapembayaran', 'setDataPembayaran');
Flight::route('POST /ubahstatuspembayaran', 'ubahStatusPembayaran');
Flight::route('POST /login', 'Login');

Flight::start();
?>
