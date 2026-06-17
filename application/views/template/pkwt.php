<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pegawai Kontrak Waktu Tertentu - PT HENDEVANE INDONESIA</title>
    <style>
        /* Pengaturan Kertas A4 */
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            color: #000;
        }

        /* Container utama untuk handle pindah halaman */
        .page-container {
            padding: 20px;
        }

        /* Class untuk Memaksa Halaman Baru */
        .page-break {
            /* Memaksa elemen ini pindah ke halaman baru saat di-print */
            break-before: page;
            margin-top: 50px;
        }

        /* Style Kop Surat */
        .kop-container {
            display: flex;
            align-items: center;
            border-bottom: 4px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo-box {
            flex: 1;
            text-align: left;
        }

        .logo-box img {
            max-height: 80px;
        }

        .alamat-kop {
            flex: 3;
            text-align: center;
            padding-right: 50px;
        }

        .nama-pt {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        .detail-alamat {
            font-size: 10pt;
            margin: 0;
        }

        /* Judul & Konten */
        .header-surat {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        .header-title {
            text-decoration: underline;
            font-size: 14pt;
        }

        .nomor-surat {
            margin-bottom: 25px;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
            text-align: center;
            text-transform: uppercase;
        }

        .content-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .content-table td {
            vertical-align: top;
            padding: 2px;
        }

        .label {
            width: 160px;
        }

        .separator {
            width: 15px;
            text-align: center;
        }

        .signature-table {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }

        .signature-box {
            height: 20px;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="kop-container">
        <div class="logo-box">
            <div class="logo-box">
                <?php
                // Gunakan path lokal file di server Anda
                $path = FCPATH . 'assets/uploads/logo.jpg';
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    echo '<img src="' . $base64 . '" style="max-height: 80px;">';
                } else {
                    // Fallback jika file tidak ada, pakai base_url biasa untuk cek manual
                    echo '<img src="' . base_url('assets/uploads/logo.jpg') . '" style="max-height: 80px;">';
                }
                ?>
            </div>
        </div>
        <div class="alamat-kop">
            <p class="nama-pt">PT HENDEVANE INDONESIA</p>
            <p class="detail-alamat">Hybrid Office Depok</p>
            <p class="detail-alamat">Jalan Raya Tapos No. 57 Tapos, Kota Depok</p>
        </div>
    </div>
    <div class="header" style="text-align: center;">SURAT PEGAWAI KONTRAK WAKTU TERTENTU </div>
    <div class="sub-header" style="text-align: center;">(PKWT) </div>
    <div class="nomor-surat" style="text-align: center;">Nomor: <?= $kontrak['id_users']; ?>/HTP-DOK/SK/PKWT/2026 </div>

    <p style="text-align: justify;">Pada hari ini 02-02-2026, Senin , tanggal dua bulan Februari tahun Dua Ribu Dua Puluh Enam,
        bertempat di Depok, telah
        disepakati Pegawai Kontrak Waktu Tertentu oleh dan di antara pihak-pihak di bawah ini: </p>

    <table class="content-table">
        <tr>
            <td class="label">Nama Perusahaan</td>
            <td class="separator">:</td>
            <td><strong>PT HENDEVANE INDONESIA</strong> </td>
        </tr>
        <tr>
            <td class="label">NPWP</td>
            <td class="separator">:</td>
            <td>62.120.399.1-412.000 </td>
        </tr>
        <tr>
            <td class="label">Direktur Operasional</td>
            <td class="separator">:</td>
            <td>Ahmad Saifur Rohman </td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="separator">:</td>
            <td>Hybrid Office Depok, Jalan Raya Tapos No. 57, Tapos, Kota Depok</td>
        </tr>
        <tr>
            <td colspan="3"> yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong></td>
        </tr>
    </table>

    <table class="content-table">
        <tr>
            <td class="label text-capitalize">2. Nama Lengkap</td>
            <td class="separator">:</td>
            <td class="text-capitalize">
                <?= $kontrak['username'] ?>
            </td>
        </tr>
        <tr>
            <td class="label">No. KTP</td>
            <td class="separator">:</td>
            <td><?= $kontrak['nik'] ?></td>
        </tr>
        <tr>
            <td class="label">NPWP</td>
            <td class="separator">:</td>
            <td>
                <?= $kontrak['npwp']; ?>
            </td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="separator">:</td>
            <td>
                <?= $kontrak['alamat'] ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">Yang selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.
            </td>
        </tr>
    </table>

    <p>Para Pihak sepakat untuk mengikatkan diri dalam Pegawai Kontrak Waktu Tertentu (PKWT) dengan
        ketentuan sebagai berikut: </p>

    <div class="section-title">PASAL 1: JANGKA WAKTU </div>
    <p>PIHAK PERTAMA mempekerjakan PIHAK KEDUA sebagai <strong>Staff Admin Entry P3H</strong> terhitung
        sejak tanggal <strong> 02 Februari 2026</strong> sampai dengan tanggal <strong>31 Juli 2026</strong>. </p>

    <div class="section-title">PASAL 2: WAKTU KERJA DAN OPERASIONAL SUBMIT </div>
    <ol>
        <li>Hari Kerja: Senin s/d Sabtu. </li>
        <li>Jam Operasional Submit: Pukul 07.00 WIB s/d 23.59 WIB. </li>
        <li>PIHAK KEDUA wajib memastikan seluruh data Pelaku Usaha (PU) yang dikerjakan telah di-submit ke
            dalam sistem sebelum batas waktu harian (cut-off) pukul 23.59 WIB. </li>
    </ol>

    <div class="section-title">PASAL 3: SKEMA KOMPENSASI (FEE), BONUS dan Punishment </div>
    <p>Pembayaran imbalan kerja kepada PIHAK KEDUA diatur berdasarkan skema performa sebagai berikut: </p>
    <ul class="bonus-list">
        <li>Fee Dasar (1-11 PU Submit): Rp 12.000,- per PU. </li>
        <li>Bonus Tahap 1 (12-14 PU Submit): Rp 30.000,- </li>
        <li>Bonus Tahap 2 (15-17 PU Submit) Diubah Ke : Rp 60.000,- </li>
        <li> Kesalahan penginputan dibebankan kepada penginput senilai Rp 200.000,-/PU</li>
    </ul>

    <div class="section-title">PASAL 4: KEWAJIBAN DAN KERAHASIAAN </div>
    <ol>
        <li>PIHAK KEDUA wajib melaksanakan proses entri data dengan teliti, akurat, dan jujur sesuai standar
            PT Hendevane Indonesia. </li>
        <li>PIHAK KEDUA wajib menjaga kerahasiaan data Pelaku Usaha serta data internal perusahaan.</li>
        <li>Pelanggaran terhadap kerahasiaan data dapat dikenakan sanksi sesuai hukum yang berlaku di
            Indonesia. </li>
        <li>Jika Secara Sengaja ataupun tidak sengaja mengisi data, membagikan data kepada Pihak ketiga dan melakukan kesalahan dalam pengentrian data maka pihak kedua wajib membayar kerugian sebesar Rp 200.000/kesalahan Input dan dipotong dalam gaji yang diberikan, dan dibuktikan dengan scrennshoot pada kerjaan masing-masing data entri</li>
    </ol>

    <div class="section-title">PASAL 5: TATA CARA PEMBAYARAN (TRANSFER) </div>
    <ol>
        <li>Pembayaran Fee Entry Data dan Bonus sebagaimana diatur pada Pasal 3 akan dilakukan oleh PIHAK PERTAMA
            melalui transfer bank <strong class="text-uppercase">
                <?= $kontrak['bank']; ?> </strong>
            atas nama <strong class="text-capitalize"> <?= $kontrak['username'] ?> dengan Nomor
                <?= $kontrak['noRek'] ?></strong>
        </li>
        <li>Pembayaran diberikan kepada PIHAK KEDUA setiap tanggal 1 atau tanggal 2 pada awal bulan berjalan (bulan
            berikutnya setelah periode kerja selesai).</li>
    </ol>
    <br>
    <div class="section-title">PASAL 6: PENUTUP </div>
    <p>Demikian Surat Pegawai Kontrak ini dibuat dalam rangkap 2 (dua) yang masing-masing memiliki kekuatan
        hukum yang sama dan ditandatangani oleh kedua belah pihak secara sadar. </p>
    <br>
    <br>
    <p style="text-align: right;">Depok, 31 Januari 2026 </p>

    <table class="signature-table">
        <tr>
            <td>
                <strong>PIHAK PERTAMA</strong> <br>
                PT HENDEVANE INDONESIA <div class="signature-box"></div>
                <?php
                // Gunakan path lokal file di server Anda
                $path = FCPATH . 'assets/uploads/tandatangan1.jpg';
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    echo '<img src="' . $base64 . '" style="max-height: 150px;">';
                } else {
                    // Fallback jika file tidak ada, pakai base_url biasa untuk cek manual
                    echo '<img src="' . base_url('assets/uploads/tandatangan1.jpg') . '" style="max-height: 150px;">';
                }
                ?>
                <br>
                ( Ahmad Saifur Rohman ) <br>
                <em>Direktur Operasional</em>
            </td>
            <td>
                <strong>PIHAK KEDUA</strong>
                <div class="signature-box"></div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                ( <?= $kontrak['username'] ?> ) <br>

                <em>Staff Admin Entry</em>
            </td>
        </tr>
    </table>

</body>

</html>