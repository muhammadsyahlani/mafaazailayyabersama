<?php
	// memulai session
	session_start();
	// membaca nilai variabel session 
	$chk_sess = $_SESSION['karyawan'];
	// memanggil file koneksi
	include("dist/config/koneksi.php");
	include("dist/config/library.php");
	// mengambil data pengguna dari tabel pengguna
	$sql_sess = "SELECT * FROM karyawan WHERE id_karyawan='". $chk_sess ."'";
	$ress_sess = mysqli_query($conn, $sql_sess);
	$row_sess = mysqli_fetch_array($ress_sess);
	// menyimpan id_pengguna yang sedang login
	$sess_karyawanid = $row_sess['id_karyawan'];
	$sess_karyawanuser = $row_sess['user_karyawan'];
	$sess_karyawanname = $row_sess['nama_karyawan'];
	$sess_karyawanfoto = $row_sess['foto_karyawan'];
	// mengarahkan ke halaman login.php apabila session belum terdaftar
	if(! isset($chk_sess)) {
		header("location: ../login.php?login=false");
	}
?>