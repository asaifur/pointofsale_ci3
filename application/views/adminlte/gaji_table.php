<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Fee Bulanan Staff</h3>
        <div class="card-tools">
            <button type="button" id="btn-export" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i> Download Excel
            </button>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Harga / Job</th>
                    <th>Total Jobdesk (QC=1 / Proses P3H)</th>
                    <th>Total Jobdesk (QC=2 / Draft)</th>
                    <th>Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Cek apakah data tidak kosong
                // Catatan: Gunakan variabel $results atau $result tergantung apa yang dikirim dari controller
                $data_loop = isset($results) ? $results : (isset($result) ? $result : []);

                if (!empty($data_loop)):
                    foreach ($data_loop as $row):
                        // 1. Tentukan Harga per status QC
                        $hargaQC1 = 12000;
                        $hargaQC2 = 7000;

                        // 2. Ambil data jumlah job dari object database
                        $jml_qc1 = isset($row->total_qc1) ? $row->total_qc1 : 0;
                        $jml_qc2 = isset($row->total_qc2) ? $row->total_qc2 : 0;

                        // 3. Kalkulasi Gaji
                        $gajiQC1 = $hargaQC1 * $jml_qc1;
                        $gajiQC2 = $hargaQC2 * $jml_qc2;
                        $totalGaji = $gajiQC1 + $gajiQC2;
                ?>
                        <tr>
                            <td>
                                <img src="<?= base_url('assets/dist/img/avatar.png') ?>" class="img-circle img-size-32 mr-2">
                                <?= $row->username ?>
                            </td>

                            <td>
                                <span class="d-block text-success" style="font-size: 14px;">
                                    QC=1: Rp <?= number_format($hargaQC1, 0, ',', '.') ?>
                                </span>
                                <span class="d-block text-warning" style="font-size: 14px;">
                                    QC=2: Rp <?= number_format($hargaQC2, 0, ',', '.') ?>
                                </span>
                            </td>

                            <td>
                                <small class="text-success mr-1">
                                    <i class="fas fa-check-circle"></i>
                                </small>
                                <?= $jml_qc1 ?> Job
                                <br>
                                <small class="text-muted">(Rp <?= number_format($gajiQC1, 0, ',', '.') ?>)</small>
                            </td>

                            <td>
                                <small class="text-warning mr-1">
                                    <i class="fas fa-file-alt"></i>
                                </small>
                                <?= $jml_qc2 ?> Job
                                <br>
                                <small class="text-muted">(Rp <?= number_format($gajiQC2, 0, ',', '.') ?>)</small>
                            </td>

                            <td>
                                <strong class="text-primary">
                                    Rp <?= number_format($totalGaji, 0, ',', '.') ?>
                                </strong>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <em>Tidak ada data gaji untuk rentang tanggal ini.</em>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#btn-export").click(function() {
            $("#tabel-gaji").table2excel({
                exclude: ".noExl", // Jika ada kolom yang tidak ingin diikutkan, beri class ini
                name: "Data Gaji Staff",
                filename: "Laporan_Gaji_Staff_" + new Date().getTime() + ".xls",
                fileext: ".xls",
                preserveColors: true
            });
        });
    });
</script>