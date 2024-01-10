<?php
// Start the session
session_start();

// if(isset($_SESSION['role'])){
// 	echo $_SESSION['role'];
// }else{
// 	echo 'Tidak Ada';
// }


if(isset($_SESSION['role'])){
	if ($_SESSION['role'] == 'Mahasiswa') {
		header('Location: mahasiswa.php');
	} else if($_SESSION['role'] == 'Admin'){
		header('Location: admin.php');
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- BOOTSTRAP -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  	<!-- JQUERY -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<title>Login Page</title>
</head>
<body>
<br/>
<div class="container">
  
	<form>
  <div class="mb-3">
    <label for="usename" class="form-label">Username</label>
    <input type="text" placeholder="Masukan Username" class="form-control" id="username" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="passowrd"  class="form-label">Password</label>
    <input type="password" placeholder="Masukan Password" class="form-control" id="password">
  </div>
  
  <button type="submit" class="btn btn-primary">Login</button>
</form>

</div>

<!-- JS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<script type="text/javascript">
	
	$(document).ready(function () {
  $("form").submit(function (event) {
    var formData = {
      username: $("#username").val(),
      password: $("#password").val(),
    };

    $.ajax({
      type: "POST",
      url: "api/login",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
      // console.log(data.mahasiswa[0].nama);
      // console.log(data.mahasiswa[0].role);
      if(data.Error == 0){
      	$.ajax({
        type : 'GET',
        url : 'sess.php',
        data: {
            idUser : data.mahasiswa[0].id,
            user : data.mahasiswa[0].nama,
            role : data.mahasiswa[0].role,

              },
        success : function(d){
                       alert('Login Berhasil');
                       if(data.mahasiswa[0].role == 'Mahasiswa'){
                       	window.location.replace('mahasiswa.php');
                       }else{
                       	window.location.replace('admin.php');
                       }
                       
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) 
        {alert ("Error Occured");}
                 });
      }else{
      	alert('Login Gagal, Username atau Password Salah');
      }
    });

    event.preventDefault();
  });
});
</script>

</body>
</html>

