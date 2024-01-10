<?php

session_start();

// if(isset($_SESSION['role'])){
//   echo $_SESSION['role'];
// }else{
//   echo 'Tidak Ada';
// }

if(isset($_SESSION['role'])){
	if($_SESSION['role'] == 'Mahasiswa'){
		header('Location: mahasiswa.php');
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
	<title>Halaman Detail</title>

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

    .list_pembayaran{
    	border-radius: 8px;
    	border:1px solid lightgrey;
    	padding: 10px;
    	margin-bottom : 20px
    }
  </style>
	
</head>
<body>

<div class="container">
	<div class="title-page">
    <div>
      <!-- DETAIL - <div id="nm_mahasiswa"></div> -->
      DETAIL
    </div>
    <button type="button" id="btn-logout" class="button btn btn-danger">LOGOUT</button>
  </div> 
  <a href="admin.php">KEMBALI</a>

	<br/>

  <div class="mb-3">
      <div id="list-pembayaran"></div>
</div>


<!-- JS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



</body>
</html>

<script type="text/javascript">

	$(document).ready(function () {
		const searchParams = new URLSearchParams(window.location.search);
		const id = searchParams.get('id');
		console.log('ini '+id);

      getDetailMahasiswa(id);
	});

	function getDetailMahasiswa(idUser) {
		console.log(idUser);
		console.log('kesini');

		var formData = {
	      idUser: idUser,
	    };

		$.ajax({
	      type: "POST",
	      url: "api/getdetailmahasiswa",
	      data: formData,
	      dataType: "json",
	      encode: true,
	    }).done(function (data) {
	      console.log(data);
	      var html_data = '';
	      if(data.Error == 0){
	        
	      	$('#list-mahasiswa').html(data.mahasiswa[0].nama);

	        for (var count = 0; count < data.mahasiswa.length; count++) {
	        	var status = data.mahasiswa[count].status_pembayaran;
	        	html_data += `
	        						<div class="list_pembayaran">
	        						<div>Nama : ${data.mahasiswa[count].nama}</div>
	        						<div>Biaya : ${data.mahasiswa[count].biaya}</div>
	        						<div>Tahun Ajar : ${data.mahasiswa[count].tahun_ajar}</div>
	        						<div>Periode : ${data.mahasiswa[count].periode}</div>
	        						<div>Tanggal Pembayaran : ${data.mahasiswa[count].tanggal_pembayaran}</div>
	        						<div>Status : <b>${data.mahasiswa[count].status_pembayaran}</b></div>
	        						<div>
	        							<a target="blank" href="${data.mahasiswa[count].bukti_pembayaran}">Lihat Bukti Pembayaran</a>
	        							</div>
	        						
								`;

								if(status == 'Menunggu konfirmasi'){
									html_data += `<button onclick="konfirmasi_data(${data.mahasiswa[count].id})" class="btn btn-primary">KONFIRMASI</button>
	        						</div>`;
								}else{
										html_data += `</div>`;
								}
	        }

	        $('#list-pembayaran').html(html_data);
	      }else{
	      	$('#list-pembayaran').html(html_data);
	      }
	    });
	}

	function konfirmasi_data(id) {
	  console.log("id : "+id);

			var formData = {
	      id: id,
	    };

	  	$.ajax({
	      type: "POST",
	      url: "api/ubahstatuspembayaran",
	      data: formData,
	      dataType: "json",
	      encode: true,
	    }).done(function (data) {
	      console.log(data);
	      alert("Berhasil Mengubah Data");
        window.location.replace('detail.php');
	     });
	}

	$(document).ready(function () {
      $("#btn-logout").click(function (e) { 
      	console.log('logout1');
        $.ajax({
        type : 'GET',
        url : 'delsess.php',
        data: {},
        success : function(data){
                       console.log('logout2');
                       window.location.replace('admin.php')
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) 
        {alert ("Error Occured");}
                 });
        });


    });
</script>