<?php

/** @var \CodeIgniter\View\View $this */
?>

<?= $this->extend('layout/default') ?>

<?= $this->section('head') ?>
    <title>Admin Dashboard &mdash; SIYUDIS</title>

    <style>
        .user-management.active button {
            cursor: default !important;
            /* shadow or light on below inside the box */
            box-shadow: inset 0 0 0.4rem 0.4rem rgba(255, 155, 155, 0.25) !important;
        }

        .dt-row-form {
            width: 100%;
            border: none;
            background-color: transparent;
            border-bottom: 1px solid #d2d6de;
            border-left: 1px solid #d2d6de;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h3 class="mb-2">User Management</h3>

            <!-- User Managenet Box -->
            <div class="row">
                <div class="col-lg-3 col-6 user-management" id="user-management-mahasiswa">
                    <div class="small-box bg-gray">
                        <div class="inner p-12">
                            <h5>
                                Mahasiswa
                            </h5>
                            <p><?= $count_user_mahasiswa ?></p>
                        </div>
                        <button type="button" class="btn btn-block small-box-footer" data-group="user_mahasiswa">Select</button>
                    </div>
                </div>

                <div class="col-lg-3 col-6 user-management" id="user-management-fakultas">
                    <div class="small-box bg-gray">
                        <div class="inner p-12">
                            <h5>
                                Fakultas
                            </h5>
                            <p><?= $count_user_fakultas ?></p>
                        </div>
                        <button type="button" class="btn btn-block small-box-footer" data-group="user_fakultas">Select</button>
                    </div>
                </div>

                <div class="col-lg-3 col-6 user-management" id="user-management-upt-perpustakaan">
                    <div class="small-box bg-gray">
                        <div class="inner p-12">
                            <h5>
                                UPT Perpustakaan
                            </h5>
                            <p><?= $count_user_upt_perpustakaan ?></p>
                        </div>
                        <button type="button" class="btn btn-block small-box-footer" data-group="user_upt_perpustakaan">Select</button>
                    </div>
                </div>

                <div class="col-lg-3 col-6 user-management" id="user-management-keuangan">
                    <div class="small-box bg-gray">
                        <div class="inner p-12">
                            <h5>
                                Keuangan
                            </h5>

                            <p><?= $count_user_keuangan ?></p>
                        </div>
                        <button type="button" class="btn btn-block small-box-footer" data-group="user_keuangan">Select</button>
                    </div>
                </div>
            </div>

            <!-- User Management Table -->
            <div class="row">
                <div class="col-lg-12 col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                User Management
                                <span class="text-muted ml-1" id="user-management-group-title">Mahasiswa</span>
                            </h3>
                        </div>
                        
                        <div class="card-body">
                            <!-- create new user -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#create-user-modal">
                                Create New User
                            </button>
                            <!-- reload table -->
                            <button type="button" class="btn btn-secondary mb-3" onclick="$('#user-management-table').DataTable().ajax.reload(null, false)">
                                Reload Table
                            </button>

                            <table id="user-management-table" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Program Studi</th>
                                        <th>NIP</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>

            



            <div class="row">
                <div class="col-lg-12 col-12">
                    <br>
                    <div class="card card-warning card-outline p-3">
                        <div class="inner">
                            <i class="fas fa-info-circle"></i>
                            <span class="card-info">Informasi Pendaftaran Yudisium</span>
                            <p class="text-justify px-3">
                                1. Periode pendaftaran yudisium FTI dilakukan setiap bulan dan biasanya dilakukan pada akhir bulan. <br>
                                2. Mahasiswa diharuskan untuk mendaftarkan akun dan mengumpulkan berkas pendaftaran yudisium dengan mengajukan berkas terlebih dahulu lewat menu pengajuan berkas. <br>
                                3. Setelah mengajukan berkas, mahasiswa harus melengkapi seluruh berkas pendaftaran dan dapat melihat status dari pendaftaran pada menu cek status. <br>
                                4. Apabila pendaftaran sudah divalidasi, silahkan unduh tanda terima dan join di grup whatsapp yang tersedia sesuai dengan program studi. <br>
                                5. Apabila terdapat hal yang tidak dimengerti silahkan tanyakan pada Admin Fakultas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<footer class="main-footer fixed-bottom">
    <strong>Copyright &copy; 2024 <a href="#">SIYUDIS</a>.</strong> All rights reserved.
</footer>

<!-- Create User Modal -->
<div class="modal fade" id="create-user-modal" tabindex="-1" aria-labelledby="create-user-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-user-modal-label">Create New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="create-user-form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" placeholder="Enter NIM">
                    </div>
                    <div class="form-group">
                        <label for="program-studi">Program Studi</label>
                        <select class="form-control" id="program-studi" name="program_studi">
                            <option value="">Select Program Studi</option>
                            <option value="Teknik Geofisika">Teknik Geofisika</option>
                            <option value="Teknik Geologi">Teknik Geologi</option>
                            <option value="Teknik Industri">Teknik Industri</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                            <option value="Teknik Pertambangan">Teknik Pertambangan</option>
                            <option value="Rekayasa Minyak dan Gas">Rekayasa Minyak dan Gas</option>
                            <option value="Teknik Material">Teknik Material</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Sistem Energi">Teknik Sistem Energi</option>
                            <option value="Teknik Biomedis">Teknik Biomedis</option>
                            <option value="Teknik Fisika">Teknik Fisika</option>
                            <option value="Rekayasa Instrumentasi dan Automasi">Rekayasa Instrumentasi dan Automasi</option>
                            <option value="Teknik Telekomunikasi">Teknik Telekomunikasi</option>
                            <option value="Rekayasa Keolahragaan">Rekayasa Keolahragaan</option>
                            <option value="Teknik Kimia">Teknik Kimia</option>
                            <option value="Teknik Biosistem">Teknik Biosistem</option>
                            <option value="Teknologi Industri Pertanian">Teknologi Industri Pertanian</option>
                            <option value="Teknologi Pangan">Teknologi Pangan</option>
                            <option value="Rekayasa Kehutanan">Rekayasa Kehutanan</option>
                            <option value="Rekayasa Kosmetik">Rekayasa Kosmetik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control" id="nip" placeholder="Enter NIP">
                    </div>
                    <div class="form-group">
                        <label for="group">Group</label>
                        <select class="form-control" id="group" required>
                            <option value="user_mahasiswa">Mahasiswa</option>
                            <option value="user_fakultas">Fakultas</option>
                            <option value="user_upt_perpustakaan">UPT Perpustakaan</option>
                            <option value="user_keuangan">Keuangan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" placeholder="Password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- clear form btn -->
                <button type="button" class="btn btn-warning" onclick="$('#create-user-form').trigger('reset')">Clear Form</button>
                <!-- close -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- submit -->
                <button type="button" class="btn btn-primary">Create User</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

$(document).ready( function () {
    const table = $('#user-management-table').DataTable({
        ajax: {
            url: '<?= site_url('admin/user-management') ?>',
            data: function (d) {
                d.group = $('.user-management .active button').data('group');
            },
            type: 'GET',
            dataSrc: ''
        },
        columns: [
            { 
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'username',
                render: function (data, type) {
                    if (type === 'display') {
                        return `<input type="text" class="form-control dt-row-form username" value="${data}">`;
                    }
                    return data;
                }
            },
            { 
                data: 'nim' ,
                render: function (data, type) {
                    if (type === 'display') {
                        return `<input type="text" class="form-control dt-row-form nim" value="${data || ''}">`;
                    }
                    return data;
                }
            },
            { 
                data: 'program_studi' ,
                render: function (data, type) {
                    if (type === 'display') {
                        return `<input type="text" class="form-control dt-row-form program_studi" value="${data || ''}">`;
                    }
                    return data;
                }
            },
            { 
                data: 'nip',
                render: function (data, type,) {
                    if (type === 'display') {
                        return `<input type="text" class="form-control dt-row-form nip" value="${data || ''}">`;
                    }
                    return data;
                }
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    return `
                        <input type="hidden" value="${data.id}" class="dt-row-form id">
                        <button type="button" class="btn btn-sm text-muted" data-toggle="tooltip" title="Revert Change"
                            disabled>
                            <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" class="btn btn-sm text-muted" data-toggle="tooltip" title="Save Change"
                            disabled>
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="btn btn-sm text-danger" data-toggle="tooltip" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],

    });

    // initial row form value
    const initialRowFormValue = {};

    // dt-row-form on change enable revert and save button and save initial value
    $('#user-management-table').on('keydown', '.dt-row-form', function () {
        const index = $(this).closest('tr').index();
        // check if initial value is not set
        if (!initialRowFormValue[index]) {
            // save all row form initial value
            initialRowFormValue[index] = $(this).closest('tr').find('.dt-row-form').map(function () {
                return $(this).val();
            }).get();
        }
        $(this).closest('tr').find('button').removeAttr('disabled');
        $(this).closest('tr').find('button[title!="Delete"]').removeClass('text-muted');
        $(this).closest('tr').find('button[title="Revert Change"]').addClass('text-warning');
        $(this).closest('tr').find('button[title="Save Change"]').addClass('text-success');
    });

    // revert change
    $('#user-management-table').on('click', 'button[title="Revert Change"]', function () {
        const index = $(this).closest('tr').index();
        $(this).closest('tr').find('.dt-row-form').each(function (i) {
            $(this).val(initialRowFormValue[index][i]);
        });
        $(this).closest('tr').find('button[title!="Delete"]').attr('disabled', true);
        $(this).closest('tr').find('button[title!="Delete"]').addClass('text-muted');

        // remove initial value
        delete initialRowFormValue[index];
    });

    // save change
    $('#user-management-table').on('click', 'button[title="Save Change"]', function () {
        // hide checklist icon and show loading (change icon <i> in innerHTML to spinner)
        const iconElement = $(this).children('i');
        iconElement.removeClass('fas fa-check').addClass('spinner-border spinner-border-sm');

        const index = $(this).closest('tr').index();
        const formData = {
            // empty string to null
            id: $(this).closest('tr').find('.id').val(),
            username: $(this).closest('tr').find('.username').val().trim(),
            nim: $(this).closest('tr').find('.nim').val().trim(),
            program_studi: $(this).closest('tr').find('.program_studi').val().trim(),
            nip: $(this).closest('tr').find('.nip').val().trim(),
        };

        $.ajax({
            url: '<?= site_url('admin/user-management') ?>/' + formData.id,
            type: 'PUT',
            data: formData,
            success: function (response) {
                alert('User Updated');
                console.log(response);
                table.ajax.reload(null, false);
                // remove initial value
                delete initialRowFormValue[index];
            },
            error: function (error) {
                console.log(error);
                alert('Failed to update user:\n' + Object.values(error.responseJSON.messages).join('\n'));
            },
            complete: function () {
                // show button and hide loading
                iconElement.removeClass('spinner-border spinner-border-sm').addClass('fas fa-check');
            }
        });
    });


    // Create User
    $('#create-user-modal .modal-footer button.btn-primary').on('click', function () {
        // Check required field with reportValidity
        const formValidation = $('#create-user-form input[required]').get().every((input) => input.reportValidity());

        if (!formValidation) {
            return;
        }

        // hide button and show loading
        $(this).hide();
        $(this).parent().append('<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');

        // get form data
        const formData = {
            username: $('#create-user-modal #username').val(),
            nim: $('#create-user-modal #nim').val(),
            program_studi: $('#create-user-modal #program-studi').val(),
            nip: $('#create-user-modal #nip').val(),
            group: $('#create-user-modal #group').val(),
            email: $('#create-user-modal #email').val(),
            password: $('#create-user-modal #password').val(),
        };

        // send ajax request to create user
        $.ajax({
            url: '<?= site_url('admin/user-management') ?>',
            type: 'POST',
            data: formData,
            success: function (response) {
                // show success message
                alert('User Created');
                // hide modal
                $('#create-user-modal').modal('hide');
                // reload table
                table.ajax.reload(null, false);
                // reset form
                $('#create-user-form').trigger('reset');
            },
            error: function (error) {
                // show error message (array of messages to string)
                alert('Failed to create user:\n' + Object.values(error.responseJSON.messages).join('\n'));
                console.log(error);
            },
            complete: function () {
                // show button and hide loading
                $('#create-user-modal .modal-footer button.btn-primary').show();
                $('#create-user-modal .modal-footer .spinner-border').remove();
            }
        });
    });

    // Delete User
    $('#user-management-table').on('click', 'button[title="Delete"]', function () {
        if (confirm('Are you sure you want to delete this user?')) {
            const id = $(this).closest('tr').find('.id').val();
            $.ajax({
                url: '<?= site_url('admin/user-management') ?>/' + id,
                type: 'DELETE',
                success: function (response) {
                    alert('User Deleted');
                    table.ajax.reload(null, false);
                    // remove initial value
                    delete initialRowFormValue[id];
                },
                error: function (error) {
                    alert('Failed to delete user:\n' + Object.values(error.responseJSON.messages).join('\n'));
                    console.log(error);
                }
            });
        }
    });

    // User Management Filter User Group Button
    $(document).on('click', '.user-management button', (element)=> {
        element = element.target;
        // Change all button text to Select
        $('.user-management button').text('Select');
        // Reset all bg color to gray
        $('.user-management .small-box').removeClass('bg-success');
        $('.user-management .small-box').addClass('bg-gray');

        if ($(element).parent().hasClass('active')) {
            // remove active class from clicked user-management
            $(element).parent().removeClass('active');
            // change title
            $('#user-management-group-title').text('');
        } else {
            // remove active class from all user-management
            $('.user-management .active').removeClass('active');
            // add active class to clicked user-management
            $(element).parent().addClass('active');
            // change bg color
            $(element).parent().removeClass('bg-gray');
            $(element).parent().addClass('bg-success');
            // change title
            $('#user-management-group-title').text($(element).data('group').replace(/_/g, ' '));
            // Change button text
            $(element).text('Clear');
        }
        // reload table
        table.ajax.reload();
    } );

});

</script>
<?= $this->endSection() ?>