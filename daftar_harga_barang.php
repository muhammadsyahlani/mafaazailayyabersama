<?php
	include("sess_check.php");
	
	// Deskripsi halaman
	$pagedesc = "Daftar Harga Barang";
	include("layout_top.php");
	include("dist/function/format_tanggal.php");
	include("dist/function/format_rupiah.php");
	
	// Ambil ID Supplier dari parameter GET
	$id_spl = isset($_GET['spl']) ? $_GET['spl'] : '';
	
	// Jika ID Supplier tidak ada, arahkan kembali ke halaman sebelumnya
	if (empty($id_spl)) {
	    header("Location: supplier.php");
	    exit();
	}
?>
<!-- top of file -->
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Daftar Harga Barang</h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
        
        <div class="row">
            <div class="col-lg-12"><?php include("layout_alert.php"); ?></div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="supplier.php" class="btn btn-default">Kembali</a>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="tabel-data">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">Nama Barang</th>
                                    <th width="10%">Harga</th>
                                    <th width="5%">Stok</th>
                                    <th width="10%">Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    // Query untuk mengambil daftar barang dari supplier tertentu
                                    $sql = "SELECT barangjasa.nama, barangjasa.harga, barangjasa.stok, barangjasa.satuan
                                            FROM barangjasa
                                            JOIN trxbarang ON barangjasa.id_brg = trxbarang.id_brg
                                            WHERE trxbarang.id_spl = '$id_spl'
                                            ORDER BY barangjasa.nama ASC";
                                    $ress = mysqli_query($conn, $sql);
                                    
                                    while($data = mysqli_fetch_array($ress)) {
                                        echo '<tr>';
                                        echo '<td class="text-center">'. $i .'</td>';
                                        echo '<td class="text-center">'. htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8') .'</td>';
                                        echo '<td class="text-center">'. format_rupiah($data['harga']) .'</td>';
                                        echo '<td class="text-center">'. htmlspecialchars($data['stok'], ENT_QUOTES, 'UTF-8') .'</td>';
                                        echo '<td class="text-center">'. htmlspecialchars($data['satuan'], ENT_QUOTES, 'UTF-8') .'</td>';
                                        echo '</tr>';                                                
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
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
            "processing": true
        });
        
        $('#tabel-data').parent().addClass("table-responsive");
    });
</script>
<?php
	include("layout_bottom.php");
?>
