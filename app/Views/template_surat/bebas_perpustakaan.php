<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Bebas Perpustakaan <?= $nama ?></title>
    <style>
        html{
            margin: 0;
            padding: 0;
        }
        
        body{
            margin: 1em 0;
            padding: 0;
        }

        #body{
            /* margin: 10mm 20mm; */
            padding: 0;
        }

        .header {
            margin: 0;
            padding: 0;
            text-align: center;
        }
        main {
            margin: 0 3em;
            padding: 0;
            text-align: justify;
        }
        table {
            margin: 0;
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
    <div id="body">
        <!-- kop -->
        <div class="header">
            <img src="<?= $kop_src ?>" alt="kop" style="width: 100%;">
            <div style="text-align: center;text-decoration:underline;font-weight:bold;margin-top:1rem">SURAT KETERANGAN BEBAS PERPUSTAKAAN</div>
            <div style="text-align: center;text-decoration:underline;margin-top:0.5rem">Nomor: <?= $nomor_surat?></div>
        </div>
        <main>
            <br>
            <br>
            <p style="text-align: justify;">Kepala UPA Perpustakaan Institut Teknologi Sumatera menyatakan bahwa :</p>
            <table>
                <tr>
                    <td>Nama</td>
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
            </table>
    
            <p style="text-align: justify;">tidak memiliki pinjaman koleksi dan tangguangan lainnya di UPA Perpustakaan Institut Teknologi Sumatera. Demikian surat ini dibuat untuk digunakan sebagai syarat Yudisium/Wisuda</p>
            <br>
    
            <div style="float: right;">
                <div style="text-align: left;">Lampung Selatan, <?= $tanggal ?></div>
                <div style="text-align: left;margin-top:1rem">Kepala UPA Perpustakaan ITERA</div>
                <br>
                <br>
                <br>
                <div style="text-align: left;text-decoration:underline;font-weight:bold;">M.Alvien Ghifari, S.Si.,M.Sc.</div>
                <div style="text-align: left;margin-top:0.5rem">NIP. 199511082022031010</div>
            </div>
        </main>
    </div>
</body>
</html>