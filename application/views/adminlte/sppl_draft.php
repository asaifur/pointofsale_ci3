<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SPPL - <?= $no_sppl ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        .section {
            margin-top: 20px;
            font-weight: bold;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .content-table th,
        .content-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .field-label {
            width: 200px;
            vertical-align: top;
        }

        .separator {
            width: 10px;
            vertical-align: top;
        }

        .point-list {
            margin-left: 20px;
            text-align: justify;
        }

        .footer {
            margin-top: 50px;
            float: right;
            text-align: center;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>

<body>

    <div class="header">
        SURAT PERNYATAAN KESANGGUPAN PENGELOLAAN DAN PEMANTAUAN LINGKUNGAN HIDUP (SPPL)
    </div>

    <p>Kami yang bertanda tangan di bawah ini: </p>

    <table>
        <tr>
            <td class="field-label">Nama Pelaku Usaha </td>
            <td class="separator">:</td>
            <td><strong><?= $namaPU ?></strong> </td>
        </tr>
        <tr>
            <td class="field-label">Nomor Induk Berusaha (NIB) </td>
            <td class="separator">:</td>
            <td><?= $noNIB ?> </td>
        </tr>
        <tr>
            <td class="field-label">Alamat</td>
            <td class="separator">:</td>
            <td><?= $alamat ?> </td>
        </tr>
        <tr>
            <td class="field-label">No. Telepon </td>
            <td class="separator">:</td>
            <td><?= $noTelepon ?> </td>
        </tr>
        <tr>
            <td class="field-label">Email </td>
            <td class="separator">:</td>
            <td> <?= $email ?> </td>
        </tr>
    </table>

    <p>Dengan rincian kegiatan usaha, jenis Dokumen Lingkungan Hidup, Persetujuan Teknis dan Data Persetujuan Lingkungan
        sebagai berikut: </p>

    <div class="section">I. JENIS DOKUMEN LINGKUNGAN HIDUP </div>
    <table class="content-table">
        <thead>
            <tr>
                <th>Kode KBLI </th>
                <th>Judul KBLI </th>
                <th>Nomor Kegiatan Usaha (NKU) </th>
                <th>Lokasi Kegiatan Usaha </th>
                <th>Jenis Dokumen Lingkungan </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $kode_kbli ?></td>
                <td><?= $judul_kbli ?> </td>
                <td><?= $nomorNKU ?> </td>
                <td><?= $alamat ?> </td>
                <td>SPPL </td>
            </tr>
        </tbody>
    </table>

    <div class="section">II. PERSETUJUAN TEKNIS </div>
    <p>Tidak ada Data Teknis </p>

    <div class="section">III. DATA PERSETUJUAN LINGKUNGAN </div>
    <p>Dalam Proses </p>

    <div class="section">Menyatakan kesanggupan: </div>
    <div class="point-list">
        <ol>
            <li>Mematuhi dan melaksanakan kegiatan usaha pada lokasi yang sesuai dengan peruntukan dalam rencana tata
                ruang</li>
            <li>Mematuhi dan melaksanakan kegiatan usaha sesuai dengan ketentuan peraturan perundang-undangan di
                bidang perlindungan dan pengelolaan lingkungan hidup</li>
            <li>Mematuhi ketentuan persyaratan pemenuhan parameter baku mutu lingkungan sesuai dengan kegiatan
                usaha yang dilakukan serta limbah yang dihasilkan</li>
            <li>Mematuhi ketentuan dan menyediakan fasilitas penyimpanan limbah sementara dan sampah domestik
                sesuai dengan kegiatan usaha serta limbah dan sampah yang dihasilkan</li>
            <li>Mematuhi ketentuan dan menyediakan fasilitas pengelolaan limbah cair untuk kegiatan usaha yang
                dilakukan sesuai dengan jumlah limbah yang dihasilkan dan jumlah tenaga kerjanya; </li>
            <li>Bersedia untuk menyediakan fasilitas pengelolaan air limbah sesuai ketentuan yang berlaku dalam hal
                pelaku usaha berencana melakukan pembuangan air limbah ke badan air atau ke perairan laut</li>
            <li> Bersedia untuk melakukan pengelolaan emisi dalam hal usaha menghasilkan emisi sesuai ketentuan yang
                berlaku;</li>
            <li>Bersedia untuk memenuhi pengaturan dan pengelolaan dampak kegiatan usaha terhadap aspek transportasi
            </li>
            <li>Bersedia dilakukan pemeriksaan/pengawasan terhadap kegiatan usaha yang dilakukan untuk memastikan
                pemenuhan persyaratan lingkungan sesuai ketentuan peraturan perundang-undangan di bidang perlindungan
                dan pengelolaan lingkungan hidup;</li>
            <li>Bersedia memproses Persetujuan Lingkungan sesuai dengan Dokumen Lingkungan Hidup yang tertera
                dalam SPPL ini</li>
            <li>Bersedia memproses Persetujuan Teknis yang diwajibkan dalam SPPL ini; dan 12. Bersedia untuk :
                <ul>
                    <li>
                        mendapatkan teguran tertulis
                    </li>
                    <li>
                        diberhentikan kegiatan usahanya
                    </li>
                    <li>dikenai denda administrati
                    </li>
                    <li>dicabut perizinan berusahanya; dan/atau
                    </li>
                    <li>
                        dikenai sanksi-sanksi lain sesuai ketentuan peraturan perundang-undangan yang berlaku apabila
                        melanggar atau tidak memenuhi ketentuan persyaratan yang telah ditetapkan sebagaimana butir 1
                        sampai
                        11
                    </li>
                </ul>
            </li>
        </ol>
    </div>

    <p>Demikian pernyataan ini dibuat dengan sebenar-benarnya dengan data dukung berupa data kegiatan usaha yang telah
        kami isikan/unggah dalam sistem OSS. Apabila di kemudian hari didapati terdapat kekeliruan ataupun
        ketidakakuratan
        dalam pernyataan ini, maka kami bersedia menerima konsekuensi sesuai dengan ketentuan peraturan
        perundangundangan</p>

    <div class="footer">
        <?= $kota ?>, <?= date('d F Y', strtotime($created_date)) ?> <br>

        <?php
        $path = FCPATH . 'assets/uploads/ttd/' . $source_ttd;

        // Cek apakah file benar-benar ada di folder
        if (file_exists($path) && !empty($source_ttd)) {
            // Mengubah gambar menjadi format Base64
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>
            <img src="<?= $base64 ?>" width="100px" height="100px" />
        <?php } else { ?>
            <br><br><br><br>
            <p style="color: red; font-size: 8px;">(Tanda Tangan Tidak Ditemukan)</p>
        <?php } ?>

        <br>
        <strong><?= $namaPU ?></strong>
    </div>

    <div class="clearfix"></div>
    <p style="font-size: 10px; margin-top: 30px;">
        Terbit/Diperbarui: <?= date('d-m-Y H:i', strtotime($created_date)) ?> <br>
        Surat ini tersimpan secara elektronik di dalam sistem OSS.
    </p>

</body>

</html>