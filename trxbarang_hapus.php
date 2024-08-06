<?php
	include("sess_check.php");

	// Ambil ID transaksi dari parameter GET
	$id = $_GET['trx'];	
	$newstok = 0;

	// Ambil data transaksi berdasarkan ID
	$sql_trx = "SELECT * FROM trxbarang WHERE id_trxbrg='$id'";
	$ress_trx = mysqli_query($conn, $sql_trx);
	$trx = mysqli_fetch_array($ress_trx);
	$jumlah = $trx['jml_brg'];
	$br = $trx['id_brg'];

	// Ambil data barang berdasarkan ID
	$sql_brg = "SELECT * FROM barangjasa WHERE id_brg='$br'";
	$ress_brg = mysqli_query($conn, $sql_brg);
	$db = mysqli_fetch_array($ress_brg);
	$stok = $db['stok'];

	// Hitung stok baru
	if ($stok >= $jumlah) {
		$newstok = $stok - $jumlah;
	} else {
		$newstok = 0;
	}

	// Update stok barang
	$sqlbr = "UPDATE barangjasa SET
			  stok='" . $newstok . "'
			  WHERE id_brg='" . $br . "'";
	$ressbr = mysqli_query($conn, $sqlbr);

	// Hapus data transaksi
	$sql = "DELETE FROM trxbarang WHERE id_trxbrg='" . $id . "'";
	$ress = mysqli_query($conn, $sql);

	// Arahkan pengguna ke halaman transaksi barang dengan pesan sukses
	header("location: trxbarang.php?act=delete&msg=success");
?>
