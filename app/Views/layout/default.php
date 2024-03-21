<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <!-- jQuery library -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- Popper JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->
    <!-- Latest compiled JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .errors {
            color: red;
            background-color: #fff5f5;
            display: inline-block;
            padding: 10px;
            border-radius: 5px;
        }
        .kint-rich {
            z-index: 999999 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
        }
    </style>
</head>
<body>
    <div>
        <!-- Top Bar -->
        <nav style="position: fixed; top: 0; left: 0; right: 0; z-index: 2000; width: 100%;">
            <?= $this->include('Layout/top_bar') ?>
        </nav>

        <!-- Side Bar -->
        <aside style="position: fixed; top: 0; left: 0; bottom: 0; z-index: 1000; width: 250px; overflow-y: auto; background-color: #a5a5c5; margin-top: 90px;">
            <?= $this->include('Layout/side_bar/side_bar') ?>
        </aside>

        <!-- Main Content -->
        <div style="margin-top: 90px; margin-left: 250px;">
            <!-- Flash Messages -->
            <?= $this->include('Layout/flash_message') ?>

            <!-- Content -->
            <main>
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
</body>
</html>