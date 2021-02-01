<?php
  //periksaa apakah user sudah login, cek kehadiran session name
  //jika tidak ada, redirect ke login.php
  session_start();
  if(!isset($_SESSION["nama"])){
    header("Location: login.php");
  }

  //buka koneksi dengan mysql
  include("connection.php");

  //ambil pesan jika ada
  if(isset($_GET["pesan"])){
    $pesan = $_GET["pesan"];
  }

  //cek apakah form telah di submit
  //berasal dari form pencarian, siapkan query
  if(isset($_GET["submit"])){
    //ambil nilai nama
    $nama = htmlentities(strip_tags(trim($_GET["nama"])));

    //filter untuk $nama untuk mencegah sql injection
    $nama = mysqli_real_escape_string($link,$nama);

    //buat query pencarian
    $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%nama%'";
    $query .="ORDER BY name ASC";

    //buat pesan
    $pesan = "Hasil pencarian untuk nama <b>\"$nama\" </b>:";
  }else {
    //bukan dari form pencarian
    //siapkan query untuk menampilkan seluruh data dari table mahasiswa
    $query ="SELECT * FROM mahasiswa ORDER BY nama ASC";
  }
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>SISTEM INFORMASI MAHASISWA</title>
     <link rel="stylesheet" href="style.css">
     <link rel="icon" href="icon1.PNG" type="image/png">
   </head>
   <body>
     <div class="container">
       <div class="header">
         <h1 id="logo">Sistem Informasi <span>Kampus</span></h1>
         <p id="tanggal"><?php echo date("d M Y");?></p>
       </div>
     </div>
     <hr>
     <nav>
       <ul>
         <li><a href="tampil_mahasiswa.php">Tampil</a></li>
         <li><a href="tambah_mahasiswa.php">Tambah</a></li>
         <li><a href="edit_mahasiswa.php">Edit</a></li>
         <li><a href="hapus_mahasiswa.php">Hapus</a></li>
         <li><a href="logout.php">Logout</a></li>
       </ul>
     </nav>
     <form id="search" action="tampil_mahasiswa.php" method="get">
       <p>
         <label for="nim">Nama : </label>
         <input type="text" name="nama" id="nama" placeholder="search...">
         <input type="submit" name="submit" value="search">
       </p>
     </form>
     <h2>Data Mahasiswa</h2>
     <?php
      // tampilkan pesan jika ada
      if(isset($pesan)){
        echo "<div class=\"pesan\">$pesan</div>";
      }
      ?>
      <table border="1">
        <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Tempat Lahir</th>
          <th>Tanggal Lahir</th>
          <th>Fakultas</th>
          <th>Jurusan</th>
          <th>IPK</th>
        </tr>
        <?php
          //jalankan query
          $result = mysqli_query($link, $query);
          if(!$result){
            die("query error: ".mysqli_errno($link)."_".mysqli_erorr($link));
          }

          //buat perulangan untuk element table dari data mahasiswa
          while($data = mysqli_fetch_assoc($result)){
            //konversi date mysql (yyyy-mm-dd) menjadi dd-mm-yyyy
            $tanggal_php = strtotime($data["tanggal_lahir"]);
            $tanggal = date("d - m - Y", $tanggal_php);

            echo"<tr>";
              echo "<td>$data[nim]</td>";
              echo "<td>$data[nama]</td>";
              echo "<td>$data[tempat_lahir]</td>";
              echo "<td>$tanggal</td>";
              echo "<td>$data[fakultas]</td>";
              echo "<td>$data[jurusan]</td>";
              echo "<td>$data[ipk]</td>";
            echo"</tr>";
          }

          //bebaskan memory
          mysqli_free_result($result);

          //tutup koneksi dengan database mysql
          mysqli_close($link);
         ?>
      </table>
      <div id="footer">
        Copyright © <?php echo date("Y");?> Dunia Ilkom
      </div>
   </body>
 </html>
