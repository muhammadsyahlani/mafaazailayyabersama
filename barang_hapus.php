<?php
	include("sess_check.php");

	// Memastikan parameter 'brg' ada dan valid
	if(isset($_GET['brg']) && is_numeric($_GET['brg'])) {
		$id = intval($_GET['brg']);
		
		$sql = "DELETE FROM barangjasa WHERE id_brg='$id'";
		$ress = mysqli_query($conn, $sql);
		
		if($ress) {
			header("location: barang.php?act=delete&msg=success");
		} else {
			echo "Error description: " . mysqli_error($conn);
		}
	} else {
		echo "Invalid ID.";
	}
?>
