<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Yudisium <?= $nama ?></title>
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
        <img src="<?=$kop_surat?>" alt="kop" style="width: 100%;">
        <p style="text-align: center;text-decoration:underline;font-weight:bold;">Tanda Terima Yudisium</p>
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
                <td>Fakultas Industry Technology Faculty</td>
            </tr>
        </table>
        <p style="text-align: justify;">Mahasiswa ini telah diterima dalam Yudisium Fakultas Industry pada tanggal: <?= $tanggal ?>.</p>
        <p style="text-align: right;">Dekan Fakultas Industry</p>
        <br>
        <br>
        <br>
        <p style="text-align: right;">Mr. Facultyhead, S.T., M.T</p>
        <p style="text-align: right;">NIP. 123456789012</p>
    </main>
</body>
</html>