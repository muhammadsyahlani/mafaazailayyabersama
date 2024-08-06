<?php
include("sess_check.php");

$id = $sess_admid;
$user=$_POST['user'];
$nama=$_POST['nama'];
$telp=$_POST['telp'];
$foto=substr($_FILES["foto"]["name"],-5);
$fotoname = date('mdYHis');
$newfoto = $fotoname.$foto;
$pass = "password";

$sqlcek = "SELECT * FROM karyawan WHERE user_karyawan='$user'";
$resscek = mysqli_query($conn, $sqlcek);
$rowscek = mysqli_num_rows($resscek);
if($rowscek<1){
	$sql="INSERT INTO karyawan(nama_karyawan,telp_karyawan,user_karyawan,pass_karyawan,foto_karyawan,id_adm)
		  VALUES('$nama','$telp','$user','$pass','$newfoto','$id')";
	$ress = mysqli_query($conn, $sql);
	if($ress){
		move_uploaded_file($_FILES["foto"]["tmp_name"],"foto/".$newfoto);
		echo "<script>alert('Tambah karyawan Berhasil!');</script>";
		echo "<script type='text/javascript'> document.location = 'karyawan.php'; </script>";
	}else{
	//	echo("Error description: " . mysqli_error($conn));
		echo "<script>alert('Ops, terjadi kesalahan. Silahkan coba lagi.');</script>";
		echo "<script type='text/javascript'> document.location = 'karyawan_tambah.php'; </script>";
	}
}else{
	header("location: karyawan_tambah.php?act=add&msg=double");	
}
?>