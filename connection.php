<?php

  //koneksi ke databse
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "kampusku";
  $link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

  //periksa koneksi
  if(!$link){
    die("koneksi tidak berhasil");
  }

 ?>
