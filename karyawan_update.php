<?php
	include("sess_check.php");
	
	// query database memperbarui data pada database
	if(isset($_POST['perbarui'])) {
		$id=$_POST['kas'];
		$nama=$_POST['nama'];
		$user=$_POST['user'];
		$userlama=$_POST['userlama'];
		$telp=$_POST['telp'];
		$pass=$_POST['password'];
		$cekfoto=$_FILES["foto"]["name"];
		$pass=$_POST['password'];
		$namafoto = date('mdYHis');
		
	if($user!=$userlama){
		$sqlcek = "SELECT * FROM karyawan WHERE user_karyawan='$user'";
		$ress = mysqli_query($conn, $sqlcek);
		$rows = mysqli_num_rows($ress);
		if($rows<1){
			if($cekfoto!=""){
				$foto=substr($_FILES["foto"]["name"],-5);
				$newfoto = $namafoto.$foto;				
				move_uploaded_file($_FILES["foto"]["tmp_name"],"foto/".$newfoto);
				$sql = "UPDATE karyawan SET
					nama_karyawan='". $nama ."',
					telp_karyawan='". $telp ."',
					user_karyawan='". $user ."',
					pass_karyawan='". $pass ."',
					foto_karyawan='". $newfoto ."'
					WHERE id_karyawan='". $id ."'";
				$ress = mysqli_query($conn, $sql);
				header("location: karyawan.php?act=update&msg=success");
			}else{
				$sql = "UPDATE karyawan SET
					nama_karyawan='". $nama ."',
					telp_karyawan='". $telp ."',
					user_karyawan='". $user ."',
					pass_karyawan='". $pass ."'
					WHERE id_karyawan='". $id ."'";
				$ress = mysqli_query($conn, $sql);
				header("location: karyawan.php?act=update&msg=success");
			}
		}else{
			header("location: karyawan_edit.php?kas=$id&act=add&msg=double");			
		}
	}else{
		if($cekfoto!=""){
			$foto=substr($_FILES["foto"]["name"],-5);
			$newfoto = $namafoto.$foto;				
			move_uploaded_file($_FILES["foto"]["tmp_name"],"foto/".$newfoto);
			$sql = "UPDATE karyawan SET
				nama_karyawan='". $nama ."',
				telp_karyawan='". $telp ."',
				pass_karyawan='". $pass ."',
				foto_karyawan='". $newfoto ."'
				WHERE id_karyawan='". $id ."'";
			$ress = mysqli_query($conn, $sql);
			header("location: karyawan.php?act=update&msg=success");
		}else{
			$sql = "UPDATE karyawan SET
				nama_karyawan='". $nama ."',
				telp_karyawan='". $telp ."',
				pass_karyawan='". $pass ."'
				WHERE id_karyawan='". $id ."'";
			$ress = mysqli_query($conn, $sql);
			header("location: karyawan.php?act=update&msg=success");
		}
	}
}
?>