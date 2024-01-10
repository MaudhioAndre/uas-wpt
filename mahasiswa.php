<?php
// Start the session
session_start();

// if(isset($_SESSION['role'])){
//   echo $_SESSION['role'];
// }else{
//   echo 'Tidak Ada';
// }

if(isset($_SESSION['role'])){
	if($_SESSION['role'] == 'Admin'){
		header('Location: index.php');
	}
}else{
	header('Location: index.php');
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Halaman Pembayaran</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  <!-- JQUERY -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <style type="text/css">
    .title-page{
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="title-page">
    <div>
      HALAMAN PEMBAYARAN - <?php echo $_SESSION['user']; ?>
    </div>
    <button type="button" id="btn-logout" class="button btn btn-danger">LOGOUT</button>
  </div>  

  <form id="form_tahun_ajar">
    <div class="row g-3 align-items-center">
  <div class="col-auto">
    <input type="hidden" id="idUser" value="<?php echo $_SESSION['idUser']; ?>">
    <input type="hidden" id="idChecked" value="0">
    <label for="inputPassword6" class="col-form-label">Tahun Ajar</label>
  </div>
  <div class="col-auto">
    <select required id="tahun_ajar" class="form-select" aria-label="Default select example">
      <option selected value="">Pilih tahun ajar</option>
      <option value="2023/2024">2023/2024</option>
      <option value="2024/2025">2024/2025</option>
      <option value="2025/2026">2025/2026</option>
    </select>
  </div>
</div>
<br/>
<div class="row g-3 align-items-center">
  <div class="col-auto">
    <label for="inputPassword6" class="col-form-label">Periode</label>
  </div>
  <div class="col-auto">
    <select required id="periode" class="form-select" aria-label="Default select example">
  <option selected value="">Pilih periode</option>
  <option value="Ganjil">Ganjil</option>
  <option value="Genap">Genap</option>
</select>
  </div>
</div>
<button type="submit" class="btn btn-primary">CEK</button>
</form>

</div>
<br/>
  <div class="container">
    <form id="form_pembayaran">
      <div class="mb-3">
        <label for="biaya" class="form-label">Biaya</label>
        <input type="number" placeholder="Masukan Biaya" class="form-control" required id="biaya" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
        <input type="date" required class="form-control" id="jatuh_tempo" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
        <input type="file" class="form-control" id="bukti_pembayaran" aria-describedby="emailHelp">
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>

<!-- JS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function () {

      $("#btn-logout").click(function (e) { 
      	console.log('logout1');
        $.ajax({
        type : 'GET',
        url : 'delsess.php',
        data: {},
        success : function(data){
                       console.log('logout2');
                       window.location.replace('index.php')
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) 
        {alert ("Error Occured");}
                 });
        });


  $("#form_tahun_ajar").submit(function (event) {
    console.log("form_tahun_ajar");
    var formData = {
      tahun_ajar: $("#tahun_ajar").val(),
      periode: $("#periode").val(),
      idUser: $("#idUser").val(),
    };

    $.ajax({
      type: "POST",
      url: "api/getdatapembayaran",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
      if(data.Error == 0){
        alert("Data Ditemukan, silahkan mengisi data");
        $('#biaya').val(data.pembayaran[0].biaya); 
        $('#jatuh_tempo').val(data.pembayaran[0].jatuh_tempo); 
        $('#idChecked').val(data.pembayaran[0].id); 
      }else{
        alert("Data Tidak Ditemukan, silahkan mengisi data");
        $('#idChecked').val('1'); 
      }
      
    });

    event.preventDefault();
  });

  $("#form_pembayaran").submit(function (event) {
    event.preventDefault();

    if($("#idChecked").val() == '0'){
      alert("Silahkan cek data terlebih dahulu");
      return null
    }

    var file_data = $('#bukti_pembayaran').prop('files')[0]; 

      var id = $("#idChecked").val();
      if(id == '1'){
        id = Math.floor((Math.random() * 9999999) + 1000000);
      }
      
      var form_data = new FormData();                  
      form_data.append('id', id);
      form_data.append('idUser', $("#idUser").val());
      form_data.append('biaya', $("#biaya").val());
      form_data.append('tahun_ajar', $("#tahun_ajar").val());
      form_data.append('periode', $("#periode").val());
      form_data.append('jatuh_tempo', $("#jatuh_tempo").val());
      form_data.append('bukti_pembayaran', file_data);

    $.ajax({
      type: "POST",
      url: "api/setdatapembayaran",
      data: form_data,
      dataType: "json",
      encode: true,
      cache: false,
      contentType: false,
      processData: false,
    }).done(function (data) {
      console.log(data);
      if(data.Error == 0){
        alert("Berhasil Menyimpan Data");
        window.location.replace('mahasiswa.php');

      }
    });

    
  });

    });

</script>