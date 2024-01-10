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
	<title>Halaman Admin</title>

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

    .list_data{
    	border-radius: 8px;
    	border:1px solid lightgrey;
    	padding: 20px;
    	margin-bottom : 20px
    }
  </style>
	
</head>
<body>

<div class="container">
	<div class="title-page">
    <div>
      HALAMAN ADMINISTRASI
    </div>
    <button type="button" id="btn-logout" class="button btn btn-danger">LOGOUT</button>
  </div> 

	<br/>

  <div class="mb-3">
        <label for="biaya" class="form-label">Cari Mahasiswa</label>
        <input type="text" placeholder="Masukan Nama Mahasiswa" onkeyup="showMhs(this.value)" class="form-control" required id="nama_mahasiswa" >
      </div>
      <div id="list-mahasiswa"></div>
</div>


<!-- JS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



</body>
</html>

<script type="text/javascript">

	function showMhs(str) {
		console.log(str);
		console.log('kesini');

		var formData = {
	      nama: str,
	    };

		$.ajax({
	      type: "POST",
	      url: "api/carimahasiswa",
	      data: formData,
	      dataType: "json",
	      encode: true,
	    }).done(function (data) {
	      console.log(data);
	      var html_data = '';
	      if(data.Error == 0){
	        
	        for (var count = 0; count < data.mahasiswa.length; count++) {
	        	html_data += `
	        						<div class="list_data">
	        							<a href="detail.php?id=${data.mahasiswa[count].id}">${data.mahasiswa[count].nama}</a>
	        						</div>
									
								`;
	        }

	        $('#list-mahasiswa').html(html_data);
	      }else{
	      	$('#list-mahasiswa').html(html_data);
	      }
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
                       window.location.replace('index.php')
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) 
        {alert ("Error Occured");}
                 });
        });
    });
</script>