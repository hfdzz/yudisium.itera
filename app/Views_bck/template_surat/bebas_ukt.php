<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat UKT Perpustakaan <?= $nama ?></title>
    <style>
        html{
            margin: 0;
            padding: 0;
        }
        
        body{
            margin: 10mm 6mm;
            padding: 0;
        }
        .header {
            margin: 0;
            padding: 0;
            text-align: center;
        }
        main {
            margin: 0 10mm;
            padding: 0;
            text-align: justify;
        }
        table {
            margin: 0 10mm;
            padding: 0;
        }
        /* indent for middle columnd */
        td:nth-child(2) {
            padding-left: 2em;
            padding-right: 1em;
        }
    </style>
</head>
<body>
    <!-- kop -->
    <div class="header">
        <img src="kop.png" alt="kop" style="width: 100%;">
        <p style="text-align: center;text-decoration:underline;font-weight:bold;">SURAT KETERANGAN BEBAS UKT</p>
        <p style="text-align: center;">Nomor: <?= $nomor_surat?></p>
    </div>
    <main>
        <p style="text-align: justify;">Dengan ini kami menyatakan bahwa :</p>
        <table>
            <tr>
                <td>Nama Mahasiswa</td>
                <td>:</td>
                <td><?= $nama ?></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td><?= $nim ?></td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td><?= $program_studi ?></td>
            </tr>
            <tr>
                <td>Fakultas</td>
                <td>:</td>
                <td>Fakultas Industry</td>
            </tr>
        </table>
        <p style="text-align: justify;">Mahasiswa ini telah menyelesaikan semua administrasi maupun peminjaman buku yang ada di Perpustakaan Institut Teknologi dan dinyatakan bebas dari tanggungan perpustakaan.
        <p style="text-align: justify;">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
        <p style="text-align: right;">Lampung Selatan, <?= $tanggal ?></p>
        <p style="text-align: right; font-weight:bold;">Mengetahui,</p>
        <p style="text-align: right;">Kepala Keuangan</p>
        <br>
        <br>
        <br>
        <p style="text-align: right;">John Doe Keuangan, S.T., M.T</p>
        <p style="text-align: right;">NIP. 123456789012</p>
    </main>
</body>
</html>