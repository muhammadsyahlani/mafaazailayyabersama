<?php
	include("sess_check.php");
	
	// Deskripsi halaman
	$pagedesc = "Laporan Barang Masuk";
	include("layout_top.php");
	include("dist/function/format_tanggal.php");
	include("dist/function/format_rupiah.php");
?>
<!-- top of file -->
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Laporan Data Barang Masuk</h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
        
        <div class="row">
            <div class="col-lg-12"><?php include("layout_alert.php"); ?></div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="get" name="laporan" onSubmit="return valid();"> 
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label>Tanggal Awal</label>
                                    <input type="date" class="form-control" name="awal" placeholder="From Date(dd/mm/yyyy)" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="akhir" placeholder="To Date(dd/mm/yyyy)" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>&nbsp;</label><br/>
                                    <input type="submit" name="submit" value="Lihat Laporan" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                    if(isset($_GET['submit'])){
                        $no=0;
                        $mulai = $_GET['awal'];
                        $selesai = $_GET['akhir'];
                        $sql = "SELECT trxbarang.*, supplier.*, barangjasa.* FROM trxbarang
                                JOIN supplier ON trxbarang.id_spl = supplier.id_spl
                                JOIN barangjasa ON trxbarang.id_brg = barangjasa.id_brg
                                WHERE trxbarang.tgl_trxbrg BETWEEN '$mulai' AND '$selesai'
                                ORDER BY trxbarang.id_trxbrg DESC";
                        $ress = mysqli_query($conn, $sql);
                        $total_harga = 0; // Inisialisasi total harga
                ?>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <a href="laporan_brg_cetak.php?awal=<?php echo $mulai;?>&akhir=<?php echo $selesai;?>" target="_blank" class="btn btn-warning">Cetak</a>
                            <button id="export-excel" class="btn btn-success">Unduh Excel</button>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="tabel-data">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">Tgl Trx</th>
                                    <th width="10%">Supplier</th>
                                    <th width="10%">Barang</th>
                                    <th width="10%">Keterangan</th>
                                    <th width="5%">Jumlah</th>
                                    <th width="10%">Harga</th>
                                    <th width="10%">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    while($data = mysqli_fetch_array($ress)) {
                                        $harga = $data['harga'];
                                        $jml_brg = $data['jml_brg'];
                                        $total_barang = $harga * $jml_brg;
                                        $total_harga += $total_barang; // Akumulasi total harga
                                        echo '<tr>';
                                        echo '<td class="text-center">'. $i .'</td>';
                                        echo '<td class="text-center">'. format_tanggal($data['tgl_trxbrg']) .'</td>';
                                        echo '<td class="text-center">'. $data['nama_spl'] .'</td>';
                                        echo '<td class="text-center">'. $data['nama'] .'</td>';
                                        echo '<td class="text-center">'. htmlspecialchars($data['keterangan'], ENT_QUOTES, 'UTF-8') .'</td>'; // Keterangan barang
                                        echo '<td class="text-center">'. $jml_brg .'</td>';
                                        echo '<td class="text-center">'. format_rupiah($harga) .'</td>';
                                        echo '<td class="text-center">'. format_rupiah($total_barang) .'</td>';
                                        echo '</tr>';                                                
                                        $i++;
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-right"><strong>Total Keseluruhan:</strong></td>
                                    <td class="text-center"><strong><?php echo format_rupiah($total_harga); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="modal fade bs-example-modal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <p>One fine body…</p>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div><!-- /.panel -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        <?php }?>
        </div><!-- /.container-fluid -->
    </div><!-- /#page-wrapper -->

<!-- bottom of file -->
<script src="libs/jquery/dist/jquery.min.js"></script>
<script src="libs/xlsx/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tabel-data').DataTable({
			"responsive": true,
			"processing": true,
			"columnDefs": [
				{ "orderable": false, "targets": [7] }
			]
		});
		
		$('#tabel-data').parent().addClass("table-responsive");

        // Export to Excel
        $('#export-excel').click(function() {
            var wb = XLSX.utils.table_to_book(document.getElementById('tabel-data'), {sheet: "Sheet1"});
            XLSX.writeFile(wb, 'Laporan_Data_Barang_Masuk.xlsx');
        });
	});
</script>
<?php
	include("layout_bottom.php");
?>
