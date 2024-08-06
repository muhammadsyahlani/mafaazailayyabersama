<?php
	include("sess_check.php");

	if(isset($_POST['simpan'])) {
		$nama = mysqli_real_escape_string($conn, $_POST['nama']);
		$harga = mysqli_real_escape_string($conn, $_POST['harga']);
		$satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
		$keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
		$id_spl = mysqli_real_escape_string($conn, $_POST['id_spl']);
		
		$sql = "INSERT INTO barangjasa (nama, harga, satuan, keterangan, id_spl, jenis) VALUES ('$nama', '$harga', '$satuan', '$keterangan', '$id_spl', 'barang')";
		$ress = mysqli_query($conn, $sql);

		if($ress) {
			echo "<script>alert('Tambah data berhasil!');window.location='barang.php'</script>";
		} else {
			echo "<script>alert('Tambah data gagal!');window.location='barang_tambah.php'</script>";
		}
	}
?>
