<?php
// $this var
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div style="min-height: 100vh;">
        <nav style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; width: 100%; overflow:hidden">
            <?= $this->include('Layout/top_bar') ?>
        </nav>
        <main style="margin-top: 90px;">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>