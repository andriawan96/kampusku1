<?php

  //ambil pesan jika ada
  if(isset($_GET["pesan"])){
    $pesan = $_GET["pesan"];
  }

  //cek apakah form telah di submit
  if(isset($_POST["submit"])){
    //form telah di submit

    //ambil nilai form
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));

    //variabel penampung pesan error
    $pesan_error="";

    //cek apakah "username" sudah diiisi atau tidak
    if(empty($username)){
      $pesan_error .="Username belum di isi <br>";
    }
    //cek apakah password sudah di isi
    if(empty($password)){
      $pesan_error .="Password belum di isi <br>";
    }

    //include file connection.php
    include('connection.php');

    //filter dengan mysqli_real_escape_string
    $username = mysqli_real_escape_string($link,$username);
    $password = mysqli_real_escape_string($link,$password);

    //generate hasing
    $password_sha1 = sha1($password);

    //cek apakah username dan password ada di table admin
    $query = "SELECT * FROM admin WHERE username = '$username'
             AND password = '$password_sha1'";
    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result)  == 0 ){
      //data tidak ditemukan, buat pesan error
      $pesan_error .= "Username dan/atau Password tidak sesuai";
    }

    //bebaskan memory
    mysqli_free_result($result);

    //tutup koneksi dengan database mysql
    mysqli_close($link);

// jika lolos validasi set session
if($pesan_error == ""){
  session_start();
  $_SESSION["nama"] = $username;
  header("Location: tampil_mahasiswa.php");
}
}else{
  $pesan_error ="";
  $username = "";
  $password = "";
}
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>SISTEM INFORMASI MAHASISWA</title>
     <link rel="icon" href="icon1.PNG" type="image/png">
     <style media="screen">

     </style>
   </head>
   <body>
     <div class="container">
       <h1>Selamat Datang</h1>
       <h3>Sistem Informasi Kampusku</h3>
       <?php
          //tampilkan pesn jika ada
          if(isset($pesan)){
            echo "<div class=\"pesan\">$pesan</div>";
          }

          //tampilkan error jika ada
          if($pesan_error !==""){
            echo "<div class=\"error\">$pesan_error</div>";
          }
        ?>

     </div>
   </body>
 </html>
