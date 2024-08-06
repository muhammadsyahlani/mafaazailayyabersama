<?php
	include("sess_check.php");
	
	if(isset($_POST['perbarui'])) {
		$nama = $_POST['nama'];
		$harga = $_POST['harga'];
		$keterangan = $_POST['keterangan'];
		$satuan = $_POST['satuan'];
		$id_spl = $_POST['id_spl']; // Ambil nilai id_spl dari form
		$brg = $_POST['id'];
		
		$sql = "UPDATE barangjasa SET
				nama='". mysqli_real_escape_string($conn, $nama) ."',
				harga='". mysqli_real_escape_string($conn, $harga) ."',
				keterangan='". mysqli_real_escape_string($conn, $keterangan) ."',
				satuan='". mysqli_real_escape_string($conn, $satuan) ."',
				id_spl='". mysqli_real_escape_string($conn, $id_spl) ."' 
				WHERE id_brg='". mysqli_real_escape_string($conn, $brg) ."'";
		$ress = mysqli_query($conn, $sql);
		if ($ress) {
			header("location: barang.php?act=update&msg=success");
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	}
?>
