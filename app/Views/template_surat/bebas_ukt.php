<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Bebas UKT <?= $nama ?></title>
    <style>
        html{
            margin: 0;
            padding: 0;
        }
        
        body{
            margin: 0;
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
            margin: 0 0 0 2em;
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
            <div style="text-align: center;text-decoration:underline;font-weight:bold;margin-top:1rem">SURAT KETERANGAN</div>
            <div style="text-align: center;margin-top:0.5rem">Nomor: <?= $nomor_surat?></div>
        </div>
        <main>
            <!-- <br> -->
            <p style="text-align: justify;">Yang bertandatangan di bawah ini :</p>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>M.Nanda Idrika</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>19940328 201903 1 020</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Bendahara Penerimaan</td>
                </tr>
            </table>

            <p style="text-align: justify;">Menerangkan dengan benar, bahwa :</p>

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
    
            <p style="text-align: justify;">Telah membayarkan UKT Sampai dengan Semester Akhir dan dinyatakan “LUNAS”.</p>
            <p style="text-align: justify;">Demikian surat keterangan ini dikeluarkan untuk dipergunakan sebagaimana mestinya.</p>
            <br>
    
            <div style="float: right;">
                <div style="text-align: left;">Lampung Selatan, <?= $tanggal ?></div>
                <div style="text-align: left;margin-top:1rem">Bendahara Penerimaan</div>
                <br>
                <br>
                <br>
                <div style="text-align: left;">M.Nanda Idrika</div>
                <div style="text-align: left;margin-top:0.5rem">NIP. 19940328 201903 1 020</div>
            </div>
        </main>
    </div>
</body>
</html>