<?php
	include("sess_check.php");
	
	// Deskripsi halaman
	$pagedesc = "Data Barang";
	include("layout_top.php");
	include("dist/function/format_tanggal.php");
	include("dist/function/format_rupiah.php");

	// Ambil data supplier untuk dropdown filter
	$supplier_sql = "SELECT * FROM supplier ORDER BY nama_spl ASC";
	$supplier_ress = mysqli_query($conn, $supplier_sql);
	
	$selected_supplier = isset($_GET['supplier']) ? intval($_GET['supplier']) : 0;

	// Filter query berdasarkan supplier
	$supplier_filter = ($selected_supplier > 0) ? "AND id_spl='$selected_supplier'" : '';
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="barang_tambah.php" class="btn btn-success">Tambah</a>
                    </div>
                    <div class="panel-body">
                        <!-- Form filter -->
                        <form class="form-inline" method="GET" action="">
                            <div class="form-group">
                                <label for="supplier">Supplier: </label>
                                <select name="supplier" id="supplier" class="form-control" onchange="this.form.submit()">
                                    <option value="0">Semua Supplier</option>
                                    <?php while($supplier = mysqli_fetch_array($supplier_ress)): ?>
                                        <option value="<?php echo htmlspecialchars($supplier['id_spl'], ENT_QUOTES, 'UTF-8'); ?>"
                                            <?php echo ($selected_supplier == $supplier['id_spl']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($supplier['nama_spl'], ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </form>
                        
                        <table class="table table-striped table-bordered table-hover" id="tabel-data">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">Nama</th>
                                    <th width="10%">Harga</th>
                                    <th width="10%">Satuan</th>
                                    <th width="10%">Keterangan</th>
                                    <th width="10%">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    $sql = "SELECT * FROM barangjasa WHERE jenis='barang' $supplier_filter ORDER BY nama ASC";
                                    $ress = mysqli_query($conn, $sql);
                                    while($data = mysqli_fetch_array($ress)) {
                                        $harga = (float)$data['harga'];
                                        $stok = (int)$data['stok'];
                                        $total_barang = $harga * $stok;
                                        echo '<tr>';
                                        echo '<td class="text-center">'. $i .'</td>';
                                        echo '<td class="text-center">'. htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8') .'</td>';
                                        echo '<td class="text-center">'. format_rupiah($harga) .'</td>';
                                        echo '<td class="text-center">'. htmlspecialchars($data['satuan'], ENT_QUOTES, 'UTF-8') .'</td>';
                                        echo '<td class="text-center">'. htmlspecialchars($data['keterangan'], ENT_QUOTES, 'UTF-8') .'</td>';
                                        echo '<td class="text-center">
                                                <a href="barang_edit.php?brg='. htmlspecialchars($data['id_brg'], ENT_QUOTES, 'UTF-8') .'" class="btn btn-warning btn-xs">Edit</a>';
                                        ?>
                                        <a href="barang_hapus.php?brg=<?php echo htmlspecialchars($data['id_brg'], ENT_QUOTES, 'UTF-8');?>" onclick="return confirm('Apakah anda yakin akan menghapus <?php echo htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');?>?');" class="btn btn-danger btn-xs">Hapus</a></td>
                                        <?php
                                        echo '</td>';
                                        echo '</tr>';                                                
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a href="barang_stok.php" target="_blank" class="btn btn-warning">Cetak</a>
                        </div>
                    </div><!-- /.panel -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /#page-wrapper -->
<!-- bottom of file -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#tabel-data').DataTable({
            "responsive": true,
            "processing": true,
            "columnDefs": [
                { "orderable": false, "targets": [5] } // Target diubah sesuai dengan kolom yang ada
            ]
        });
        
        $('#tabel-data').parent().addClass("table-responsive");
    });
</script>
<script>
    var app = {
        code: '0'
    };
    
    $('[data-load-code]').on('click',function(e) {
        e.preventDefault();
        var $this = $(this);
        var code = $this.data('load-code');
        if(code) {
            $($this.data('remote-target')).load('karyawan_detail.php?code='+code);
            app.code = code;
        }
    });        
</script>
<?php
	include("layout_bottom.php");
?>
