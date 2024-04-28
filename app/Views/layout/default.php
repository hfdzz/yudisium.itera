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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>>
    <!-- DataTables -->
    <link rel="stylesheet" href=<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>>
    <!-- Theme style -->
    <link rel="stylesheet" href=<?= base_url('assets/dist/css/adminlte.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/css/style.css') ?>>

    <?= $this->renderSection('head') ?>

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
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Top Bar -->
        <?= $this->include('layout/top_bar') ?>

        <!-- Side Bar -->
        <?= $this->include('layout/side_bar/side_bar') ?>

        <!-- Main Content -->
        <!-- Flash Messages -->
        <?= $this->include('layout/flash_message') ?>

        <!-- Content -->
        <?= $this->renderSection('content') ?>

        <!-- Footer -->
        <?= $this->include('layout/footer') ?>
    </div>

    <!-- SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/pdfmake/pdfmake.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/pdfmake/vfs_fonts.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
    <!-- Page specific script -->
    <script>
    
    $(document).ready(function() {
    var table = $('#example1').DataTable({
        "responsive": false,
        "lengthChange": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[4, 'asc']],
        "columnDefs": [
        { "targets": [4], "orderable": false }
        ]
    });

    $('#filterStatus').on('change', function() {
        var val = $(this).val();
        table.column(5).search(val ? '^' + val + '$' : '', true, false).draw();
    });
    table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    </script>

    <?= $this->renderSection('scripts') ?>
    
</body>
</html>