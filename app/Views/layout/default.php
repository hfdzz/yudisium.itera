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

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>>
    <!-- DataTables -->
    <link rel="stylesheet" href=<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>>
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
    <script defer src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script defer src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- DataTables  & Plugins -->
    <script defer src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/pdfmake.min.js" integrity="sha512-w61kvDEdEhJPJLSAJpuL+RWp1+zTBUUpgPaP+6pcqCk78wQkOaExjnGWrVbovojeisWGQS7XZKz+gr3L+GPYLg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/vfs_fonts.min.js" integrity="sha512-EFlschXPq/G5zunGPRSYqazR1CMKj0cQc8v6eMrQwybxgIbhsfoO5NAMQX3xFDQIbFlViv53o7Hy+yCWw6iZxA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
    <script defer src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script defer src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script defer src="<?= base_url('assets/js/script.js') ?>"></script>
    <!-- Page specific script -->
    <script>
    
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "responsive": false,
            // "lengthChange": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "columnDefs": [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0,
                }
            ],
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ]
        });

        $('#filterStatus').on('click', (e) => {
            e.stopPropagation();
        });

        $('#filterStatus').on('change', function(e) {
            let val = $(this).val();
            console.log(val);
            table.column(5).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        table
        .on('order.dt search.dt', function () {
            let i = 1;
            table
                .cells(null, 0, { search: 'applied', order: 'applied' })
                .every(function (cell) {
                    this.data(i++);
                });
        })
        .draw();
    });
    
    </script>

    <?= $this->renderSection('scripts') ?>
    
</body>
</html>