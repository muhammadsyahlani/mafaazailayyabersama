<?php
	include("sess_check.php");
	
	// Ambil data barang berdasarkan ID
	if(isset($_GET['brg']) && is_numeric($_GET['brg'])) {
		$id_brg = intval($_GET['brg']);
		$sql = "SELECT * FROM barangjasa WHERE id_brg='$id_brg'";
		$ress = mysqli_query($conn, $sql);
		
		if($ress) {
			$data = mysqli_fetch_array($ress);
		} else {
			echo "Error description: " . mysqli_error($conn);
			exit();
		}
	} else {
		echo "Invalid ID.";
		exit();
	}

	// Ambil data supplier untuk dropdown
	$supplier_sql = "SELECT * FROM supplier ORDER BY nama_spl ASC";
	$supplier_ress = mysqli_query($conn, $supplier_sql);

	// Deskripsi halaman
	$pagedesc = "Data Barang";
	$menuparent = "barang";
	include("layout_top.php");
?>
<!-- top of file -->
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Data Barang</h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-lg-12"><?php include("layout_alert.php"); ?></div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <form class="form-horizontal" action="barang_update.php" method="POST" enctype="multipart/form-data">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3>Edit Data</h3></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Nama</label>
                                <div class="col-sm-4">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                    <input type="hidden" name="id" class="form-control" value="<?php echo htmlspecialchars($data['id_brg'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Harga</label>
                                <div class="col-sm-4">
                                    <input type="number" name="harga" min="0" class="form-control" placeholder="Harga" value="<?php echo htmlspecialchars($data['harga'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Satuan</label>
                                <div class="col-sm-4">
                                    <input type="text" name="satuan" class="form-control" placeholder="Satuan" value="<?php echo htmlspecialchars($data['satuan'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Keterangan</label>
                                <div class="col-sm-4">
                                    <textarea name="keterangan" class="form-control" placeholder="Keterangan" rows="3" required><?php echo htmlspecialchars($data['keterangan'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Supplier</label>
                                <div class="col-sm-4">
                                    <select name="id_spl" class="form-control" required>
                                        <?php while($supplier = mysqli_fetch_array($supplier_ress)): ?>
                                            <option value="<?php echo htmlspecialchars($supplier['id_spl'], ENT_QUOTES, 'UTF-8'); ?>"
                                                <?php echo ($supplier['id_spl'] == $data['id_spl']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($supplier['nama_spl'], ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" name="perbarui" class="btn btn-success">Update</button>
                        </div>
                    </div><!-- /.panel -->
                </form>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->
<!-- bottom of file -->
<?php
	include("layout_bottom.php");
?>
