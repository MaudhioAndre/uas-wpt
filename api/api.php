<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: TOKEN, HTTP_TOKEN, HTTP_X_API_KEY, HTTP_X_CLIENT_ID, X-api-key, X-client-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: TOKEN, HTTP_TOKEN, HTTP_X_API_KEY, HTTP_X_CLIENT_ID, X-api-key, X-client-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}

ini_set('memory_limit', '-1');

require_once __DIR__ . '/sql_engine.php';

function getBlog(){
    echo getBlogSQL();
}

function getMahasiswa(){
    echo getMahasiswaSQL();
}


function cariMahasiswa(){
    if (isset($_POST['nama'])) {
        $nama = htmlspecialchars($_POST['nama']);
        echo cariMahasiswaSQL($nama);
    } else {
        $response["Error"] = 1;
        $response["Message"] = "1102|required field is missing";
        echo json_encode($response);
    }
}

function getDetailMahasiswa(){
    if (isset($_POST['idUser'])) {
        $idUser = htmlspecialchars($_POST['idUser']);
        echo getDetailMahasiswaSQL($idUser);
    } else {
        $response["Error"] = 1;
        $response["Message"] = "1102|required field is missing";
        echo json_encode($response);
    }
}

function ubahStatusPembayaran(){
    if (isset($_POST['id'])) {
        $id = htmlspecialchars($_POST['id']);
        echo ubahStatusPembayaranSQL($id);
    } else {
        $response["Error"] = 1;
        $response["Message"] = "1102|required field is missing";
        echo json_encode($response);
    }
}



function Login(){
    if (isset($_POST['username'], $_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        echo LoginSQL($username, $password);
    } else {
        $response["Error"] = 1;
        $response["Message"] = "1102|required field is missing";
        echo json_encode($response);
    }
}

function getDataPembayaran(){
    if (isset($_POST['idUser'], $_POST['tahun_ajar'], $_POST['periode'])) {
        $idUser = htmlspecialchars($_POST['idUser']);
        $tahun_ajar = htmlspecialchars($_POST['tahun_ajar']);
        $periode = htmlspecialchars($_POST['periode']);
        
        echo getDataPembayaranSQL($idUser, $tahun_ajar, $periode);
    } else {
        $response["Error"] = 1;
        $response["Message"] = "1102|required field is missing";
        echo json_encode($response);
    }
}

function setDataPembayaran(){
    if (isset($_POST['id'], $_POST['idUser'], $_POST['biaya'], $_POST['jatuh_tempo'])) {
        $id = htmlspecialchars($_POST['id']);
        $idUser = htmlspecialchars($_POST['idUser']);
        $tahun_ajar = htmlspecialchars($_POST['tahun_ajar']);
        $periode = htmlspecialchars($_POST['periode']);
        $biaya = htmlspecialchars($_POST['biaya']);
        $jatuh_tempo = htmlspecialchars($_POST['jatuh_tempo']);
        if(isset($_FILES['bukti_pembayaran'])){
            $bukti_pembayaran = $_FILES['bukti_pembayaran'];
        }else{
            $bukti_pembayaran = false;  
        }
        
        echo setDataPembayaranSQL($id, $idUser, $biaya, $tahun_ajar, $periode, $jatuh_tempo, $bukti_pembayaran);
    } else {
        $response["Error"] = 1;
        $response["Message"] = "1102|required field is missing";
        echo json_encode($response);
    }
}

function tambahBlog(){
    if (isset($_POST['judul'], $_POST['deskripsi'], $_FILES['foto'])) {
        $judul = htmlspecialchars($_POST['judul']);
        $deskripsi = htmlspecialchars($_POST['deskripsi']);
        $foto = $_FILES['foto'];
        echo tambahBlogSQL($judul, $deskripsi, $foto);
    } else {
        $response["Error"] = 1;
        $response["Message"] = "1102|required field is missing";
        echo json_encode($response);
    }
}

?>