@extends('admin.layouts.template')
@section('title', 'Admin | Data User')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Data User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Data User
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-info"></i> Informasi</h5>
                            <ol>
                                <li>
                                    Password default user <b>123456</b> setelah menambahkan user
                                </li>
                                <li>
                                    Untuk mengganti password user, bisa klik tombol <b>KLIK</b> lalu pilih edit
                                </li>
                            </ol>
                        </div>
                        <div class="card" id="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">
                                    <i class="fas fa-plus-circle mx-2"></i>Tambah Data</button>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" id="card_refresh">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="card_body">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered table-stripedtable-hover w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>No HP</th>
                                                <th>WA</th>
                                                <th>PIN</th>
                                                <th>Status</th>
                                                <th>Create By</th>
                                                <th>Update By</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        {{-- Modal Tambah --}}
        <form action="" id="form_add" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama_user" class="form-control" placeholder="Masukkan Nama"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan Username"
                                    required>
                                <small>Mohon mengisi username tanpa spasi</small>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan Email"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>NO HP</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="Masukkan Nomor Hp">
                            </div>
                            <div class="form-group">
                                <label>WA</label>
                                <input type="text" name="wa" class="form-control" placeholder="Masukkan Nomor WA">
                            </div>
                            <div class="form-group">
                                <label>PIN</label>
                                <input type="text" name="pin" class="form-control" placeholder="Masukkan PIN">
                            </div>
                            <div class="form-group">
                                <label>Upload Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal Edit --}}
        <form action="#" method="POST" enctype="multipart/form-data" id="form_edit">
            @csrf
            <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title_edit">Edit </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_user_edit" id="id_user_edit">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama_user_edit" id="nama_user_edit" class="form-control"
                                    placeholder="Masukkan Nama" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username_edit" id="username_edit" class="form-control"
                                    placeholder="Masukkan Username" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email_edit" id="email_edit" class="form-control"
                                    placeholder="Masukkan Email" required>
                            </div>
                            <div class="form-group">
                                <label>NO HP</label>
                                <input type="text" name="no_hp_edit" id="no_hp_edit" class="form-control"
                                    placeholder="Masukkan Nomor Hp">
                            </div>
                            <div class="form-group">
                                <label>WA</label>
                                <input type="text" name="wa_edit" id="wa_edit" class="form-control"
                                    placeholder="Masukkan Nomor WA">
                            </div>
                            <div class="form-group">
                                <label>PIN</label>
                                <input type="text" name="pin_edit" id="pin_edit" class="form-control"
                                    placeholder="Masukkan PIN">
                            </div>
                            <div class="form-group">
                                <label>Ubah Password</label>
                                <input type="password" name="password_edit" class="form-control"
                                    placeholder="Masukkan Password">
                                <small>*Kosongkan jika tidak ingin merubah password</small>
                            </div>
                            <div class="form-group">
                                <label>Upload Foto</label>
                                <input type="hidden" name="fotolama_edit" id="fotolama_edit">
                                <input type="file" name="foto_edit" id="foto_edit" class="form-control"
                                    accept="image/*">
                                <small>*Kosongkan jika tidak ingin merubah foto</small>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            // data table and card refresh
            var table1 = dataTable('#table1');

            $('#card_refresh').click(function(e) {
                table1.ajax.reload();
            });

            $("#form_add").validate({
                rules: {
                    foto: {
                        extension: "jpg|jpeg|png",
                    },
                    email: {
                        email: true,
                        required: true
                    }
                },
                messages: {
                    nama_user: {
                        required: "Nama Wajib Diisi"
                    },
                    username: {
                        required: "Username Wajib Diisi"
                    },
                    email: {
                        required: "Email Wajib Diisi",
                        email: "Mohon mengisi email dengan benar"
                    },
                    foto: {
                        extension: "Format file harus JPG, JPEG, or PNG.",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('pl-2 invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });

        });
    </script>

    <script>
        $('#modal_add').on('shown.bs.modal', function() {

            $('#nama_user').focus();
        })

        $('#form_add').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = "{{ route('admin.data-user.add') }}";
            var fd = new FormData($(this)[0]);

            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#form_submit').attr('disabled', true);
                },
                success: function(response) {
                    console.log(response);
                    $('#modal_add').modal('toggle');
                    $('#form_submit').attr('disabled', false);
                    swalToast(response.message, response.data);
                    cardRefresh();
                    if (response.message == 500) {
                        errorApplication(response.modules, response.controller, response.function,
                            response.error_line, response.error_message);
                    }
                }
            });
        });

        $('#modal_edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id_user = button.data('id_user');
            var nama_user = button.data('nama_user');
            var username = button.data('username');
            var email = button.data('email');
            var no_hp = button.data('no_hp');
            var wa = button.data('wa');
            var pin = button.data('pin');
            var foto = button.data('foto');


            var modal = $(this);
            modal.find('#title_edit').text("Edit");
            modal.find('#id_user_edit').val(id_user);
            modal.find('#nama_user_edit').val(nama_user);
            modal.find('#username_edit').val(username);
            modal.find('#email_edit').val(email);
            modal.find('#no_hp_edit').val(no_hp);
            modal.find('#wa_edit').val(wa);
            modal.find('#pin_edit').val(pin);
            modal.find('#fotolama_edit').val(foto);
        })

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            var url = "{{ route('admin.data-user.edit') }}";
            var fd = new FormData($('#form_edit')[0]);

            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#form_submit_edit').attr('disabled', true);
                },
                success: function(response) {
                    console.log(response);
                    $('#modal_edit').modal('toggle');
                    $('#foto_edit').val('');
                    $('#form_submit_edit').prop("disabled", false);
                    swalToast(response.message, response.data);
                    cardRefresh();
                    if (response.message == 500) {
                        errorApplication(response.modules, response.controller, response.function,
                            response.error_line, response.error_message);
                    }
                }
            });
        });
    </script>

    <script>
        function deleteData(event) {
            event.preventDefault();
            var id_user = event.target.querySelector('input[name="id_user"]').value;
            var nama_user = event.target.querySelector('input[name="nama_user"]').value;
            Swal.fire({
                title: 'Yakin Ingin menghapus ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.data-user.delete') }}";
                    var fd = new FormData($(event.target)[0]);

                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            swalToast(response.message, response.data);
                            cardRefresh();
                            if (response.message == 500) {
                                errorApplication(response.modules, response.controller, response
                                    .function,
                                    response.error_line, response.error_message);
                            }
                        }
                    });
                }
            })
        }

        function dataTable(id) {
            var url = "{{ route('admin.data-user.data') }}";
            var datatable = $(id).DataTable({
                responsive: true,
                autoWidth: true,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    beforeSend: function() {
                        $('.overlay').remove();
                        var div = '<div class="overlay">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('#card').append(div);
                    },
                    complete: function() {
                        $('.overlay').remove();
                    },
                },
                deferRender: true,
                columns: [{
                        data: 'id_user',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "align-middle"
                    },
                    {
                        data: 'foto',
                        name: 'foto',
                        className: "align-middle"
                    },
                    {
                        data: 'nama_user',
                        name: 'nama_user',
                        className: "align-middle"
                    },
                    {
                        data: 'username',
                        name: 'username',
                        className: "align-middle"
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: "align-middle",
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                        className: "align-middle",
                    },
                    {
                        data: 'wa',
                        name: 'wa',
                        className: "align-middle",
                    },
                    {
                        data: 'pin',
                        name: 'pin',
                        className: "align-middle",
                    },
                    {
                        data: 'status_user',
                        name: 'status_user',
                        className: "align-middle",
                    },
                    {
                        data: 'create_by',
                        name: 'create_by',
                        className: "align-middle",
                    },
                    {
                        data: 'update_by',
                        name: 'update_by',
                        className: "align-middle",
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "align-middle",
                        'searchable': false,
                    },
                ]
            })
            datatable.buttons().container().appendTo(id + '_wrapper .col-md-6:eq(0)');
            return datatable;
        }

        function cardRefresh() {
            var cardRefresh = document.querySelector('#card_refresh');
            cardRefresh.click();
        }

        function swalToast(message, data) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            if (message == 200) {
                Toast.fire({
                    icon: 'success',
                    title: data
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data
                });
            }
        }

        function errorApplication(modules, controller, func, error_line, error_message) {
            $.ajax({
                type: "get",
                url: "{{ route('admin.error-application.add') }}",
                data: {
                    modules: modules,
                    controller: controller,
                    function: func,
                    error_line: error_line,
                    error_message: error_message,
                },
                success: function(response) {
                    console.log("Error successfully logged:", response);
                },
            });
        }
    </script>
@endpush
