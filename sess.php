<?php
session_start();
$_SESSION['idUser']=$_GET['idUser'];
$_SESSION['user']=$_GET['user'];
$_SESSION['role']=$_GET['role'];
echo $_SESSION['user'];
?> 