<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: HTTP_X_API_KEY, HTTP_X_CLIENT_ID, X-api-key, X-client-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: HTTP_X_API_KEY, HTTP_X_CLIENT_ID, X-api-key, X-client-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}

date_default_timezone_set('Asia/Jakarta');
require_once __DIR__ . '/core/core.php';

function getBlogSQL(){
    $sql = "SELECT * FROM blog ORDER BY createdAt DESC";
    return coreReturnJSON('blog', $sql, null , false);
    
    // $response['Error'] = 0;
    // $response['Message'] = 'Berhasil Mendapatkan Token';
    // $response['Token'] = PATH_FRONTEND;
    // return json_encode($response);
}

function getMahasiswaSQL(){
    $sql = "SELECT * FROM user WHERE role='Mahasiswa'";
    return coreReturnJSON('mahasiswa', $sql, null , false);
}

function cariMahasiswaSQL($nama){
    $sql = "SELECT * FROM user 
    WHERE nama LIKE '%".$nama."%' AND role='Mahasiswa'";
    return coreReturnJSON('mahasiswa', $sql, null, false);
}

function getDetailMahasiswaSQL($idUser){
    $sql = "SELECT * FROM `user` u 
    INNER JOIN pembayaran p ON u.id=p.idUser AND u.id=:idUser AND u.role='Mahasiswa';";
    return coreReturnJSON('mahasiswa', $sql, array(":idUser" => $idUser) , false);
}

function LoginSQL($username, $password){
    $sql = "SELECT * FROM user WHERE username=:username AND password=:password";
    return coreReturnJSON('mahasiswa', $sql, array(":username" => $username, 
        ":password" => $password) , false);
}

function getDataPembayaranSQL($idUser, $tahun_ajar, $periode){
    $sql = "SELECT * FROM pembayaran WHERE idUser=:idUser AND tahun_ajar=:tahun_ajar AND periode=:periode";
    return coreReturnJSON('pembayaran', $sql, array(":idUser" => $idUser, 
        ":tahun_ajar" => $tahun_ajar, ":periode"=> $periode) , false);
}

function setDataPembayaranSQL($id, $idUser, $biaya, $tahun_ajar, $periode, $jatuh_tempo, $bukti_pembayaran){
    if($bukti_pembayaran != FALSE){

        $uploadedFoto = uploadFileSQL2($bukti_pembayaran);
        $tanggal_pembayaran = date('Y-m-d H:i');
        $status_pembayaran = 'Menunggu konfirmasi';
    }else{
        $uploadedFoto = NULL;
        $tanggal_pembayaran = NULL;
        $status_pembayaran = "Belum Bayar";
    }

    $sql = "INSERT INTO `pembayaran`(`id`,`idUser`,`biaya`,`tahun_ajar`,`periode`,`jatuh_tempo`,`tanggal_pembayaran`,`bukti_pembayaran`,`status_pembayaran`) 
                    VALUES (:id, :idUser, :biaya, :tahun_ajar, :periode, :jatuh_tempo, :tanggal_pembayaran, :bukti_pembayaran, :status_pembayaran)
                    ON DUPLICATE KEY 
                    UPDATE `bukti_pembayaran`= :bukti_pembayaran2, `tanggal_pembayaran`= :tanggal_pembayaran2, `status_pembayaran`= :status_pembayaran2";

    // $sql = "INSERT INTO `pembayaran`(`id`,`idUser`,`biaya`,`tahun_ajar`,`periode`,`jatuh_tempo`,`tanggal_pembayaran`,`bukti_pembayaran`,`status_pembayaran`) 
    //                 VALUES (:id, :idUser, :biaya, :tahun_ajar, :periode, :jatuh_tempo, :tanggal_pembayaran, :bukti_pembayaran, :status_pembayaran)";
    
    // $result = coreNoReturn($sql, array(":id" => $id, ":idUser" => (int)$idUser, ":biaya" => (int)$biaya, ":tahun_ajar" => $tahun_ajar, ":periode" => $periode, ":jatuh_tempo" => $jatuh_tempo, ":tanggal_pembayaran" => $tanggal_pembayaran, ":bukti_pembayaran" => $uploadedFoto, ":status_pembayaran" => $status_pembayaran));        


    $result = coreNoReturn($sql, array(":id" => $id, ":idUser" => (int)$idUser, ":biaya" => (int)$biaya, ":tahun_ajar" => $tahun_ajar, ":periode" => $periode, ":jatuh_tempo" => $jatuh_tempo, ":tanggal_pembayaran" => $tanggal_pembayaran, ":bukti_pembayaran" => $uploadedFoto, ":status_pembayaran" => $status_pembayaran, ":bukti_pembayaran2" => $uploadedFoto, ":tanggal_pembayaran2" => $tanggal_pembayaran, ":status_pembayaran2" => $status_pembayaran));        
        
                
    if ($result['success'] == 1) {
        $response['Error'] = 0;
        $response['Message'] = "Berhasil Menambahkan Data!";
        return json_encode($response);
    } else {
        $response['Error'] = 1;
        $response['Message'] = "Gagal Menambahkan Data!";
        return json_encode($response);
    }
}

function ubahStatusPembayaranSQL($id){

    
    $sql = "UPDATE pembayaran SET status_pembayaran='Terkonfirmasi' WHERE id=:id";
    
    $result = coreNoReturn($sql, array(":id" => $id));        
                
    if ($result['success'] == 1) {
        $response['Error'] = 0;
        $response['Message'] = "Berhasil Mengubah Data!";
        return json_encode($response);
    } else {
        $response['Error'] = 1;
        $response['Message'] = "Gagal Mengubah Data!";
        return json_encode($response);
    }
}


function tambahBlogSQL($judul, $deskripsi, $foto){

    // $upload = json_decode(uploadFileSQL2($file), true);
    $uploadedFoto = uploadFileSQL2($foto);
    // $type = $upload['type'];
    
    $sql = "INSERT INTO blog(judul, deskripsi, foto) VALUES(:judul, :deskripsi, :foto)";
    
    $result = coreNoReturn($sql, array(":judul" => $judul, ":deskripsi" => $deskripsi, 
                ":foto" => $uploadedFoto));        
                
    if ($result['success'] == 1) {
        $response['Error'] = 0;
        $response['Message'] = "Berhasil Menambahkan Data!";
        return json_encode($response);
    } else {
        $response['Error'] = 1;
        $response['Message'] = "Gagal Menambahkan Data!";
        return json_encode($response);
    }
}

function hilangSimbol($name){
    return str_replace(['!','@','#','$','%','^','&','*',' ', "'"],"",$name);
}

function uploadFileSQL2($file){

    $valid_ext = array('png','jpeg','jpg');
    $random = substr(str_shuffle("0123456789"), 0, 6);
    $loc = "assets/file/".date("Y/m/d")."/";
    if (!file_exists($loc)) {
        mkdir($loc, 0777, true);
    }

    $filename = $file['name'];    
    $filename = hilangSimbol($filename);
    // file extension
    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
    $path = $loc.$random.$filename;

    if(in_array($file_extension, $valid_ext)){  
        $moveFile = compressImage($file['tmp_name'], $path, 50);
    }else{
        $moveFile = move_uploaded_file($file['tmp_name'], $path);
    }
    
    if($moveFile){
        return WEB_SERVER . DIR_API . '/' . $path;
    }
       
}

function compressImage($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    return imagejpeg($image, $destination, $quality);
}

function uploadFileSQL($file){
    $loc = "assets/file/".date("Y/m/d")."/";
    if (!file_exists($loc)) {
        mkdir($loc, 0777, true);
    }

    $path = $file['name'];
    // $path = $_FILES['file']['name'];
    $type = pathinfo($path, PATHINFO_EXTENSION);
    
    $random = substr(str_shuffle("0123456789"), 0, 6);
    $fbName = $random . "-" .$file['name']; 
    $url =  __DIR__ ."/".$loc.$fbName; 

    if($type == 'jpg' || $type == 'png' || $type == 'jpeg'){
        $moveFile = compress_image($file['tmp_name'], $url, 50);
    }else{
        $moveFile = move_uploaded_file($file['tmp_name'], $loc.$fbName);
    }
    
    if ($moveFile) {
        $hasil = $loc.$fbName;
        $res["Error"] = 0;
        $res["Message"] = "Berhasil upload file!";
        $res["hasil"] = $loc.$fbName;
        $res["type"] = $type;
        echo json_encode($res);
    } else {
        $res["Error"] = 1;
        $res["Message"] = "Gagal upload file!";
        echo json_encode($res);
    }
}

?>