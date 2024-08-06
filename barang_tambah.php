<?php
	include("sess_check.php");
	
	// deskripsi halaman
	$pagedesc = "Data Barang";
	$menuparent = "barang";
	include("layout_top.php");

	// Mendapatkan daftar supplier dari database
	$suppliers = [];
	$sql_suppliers = "SELECT id_spl, nama_spl FROM supplier ORDER BY nama_spl ASC";
	$result_suppliers = mysqli_query($conn, $sql_suppliers);

	if ($result_suppliers) {
		while ($row = mysqli_fetch_assoc($result_suppliers)) {
			$suppliers[] = $row;
		}
	} else {
		echo "<script>alert('Gagal mendapatkan data supplier!');window.location='barang.php'</script>";
	}
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
						<form class="form-horizontal" action="barang_insert.php" method="POST" enctype="multipart/form-data">
							<div class="panel panel-default">
								<div class="panel-heading"><h3>Tambah Data</h3></div>
								<div class="panel-body">
									<div class="form-group">
										<label class="control-label col-sm-3">Nama Barang</label>
										<div class="col-sm-4">
											<input type="text" name="nama" class="form-control" placeholder="Nama" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">Harga</label>
										<div class="col-sm-4">
											<input type="number" name="harga" min="0" class="form-control" placeholder="Harga" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">Satuan</label>
										<div class="col-sm-4">
											<input type="text" name="satuan" class="form-control" placeholder="Satuan" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">Keterangan</label>
										<div class="col-sm-4">
											<textarea name="keterangan" class="form-control" placeholder="Keterangan" rows="3" required></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">Supplier</label>
										<div class="col-sm-4">
											<select name="id_spl" class="form-control" required>
												<option value="">Pilih Supplier</option>
												<?php foreach($suppliers as $supplier) { ?>
													<option value="<?php echo htmlspecialchars($supplier['id_spl'], ENT_QUOTES, 'UTF-8'); ?>">
														<?php echo htmlspecialchars($supplier['nama_spl'], ENT_QUOTES, 'UTF-8'); ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<button type="submit" name="simpan" class="btn btn-success">Simpan</button>
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
