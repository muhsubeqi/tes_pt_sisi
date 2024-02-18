@extends('admin.layouts.template')
@section('title', 'Admin | Data Menu')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Data Menu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Data Menu
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
                                    Untuk setting akses user, bisa klik tombol <b>KLIK</b> lalu pilih akses user
                                </li>
                                <li>
                                    Jika sudah di setting akses user, maka menu akan tampil sesuai akses user, dan tidak
                                    bisa diakses meskipun dengan menulis urlnya
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
                                                <th>Level</th>
                                                <th>Menu Name</th>
                                                <th>Menu Link</th>
                                                <th>Menu Icon</th>
                                                <th>Parent</th>
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
                                <label>Level Menu</label>
                                <select name="id_level" class="form-control select2bs4">
                                    <option value="">Pilih...</option>
                                    @foreach ($level as $item)
                                        <option value="{{ $item->id_level }}">{{ $item->level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Menu</label>
                                <input type="text" name="menu_name" id="menu_name" class="form-control"
                                    placeholder="Masukkan Nama Menu">
                            </div>
                            <div class="form-group">
                                <label>Link Menu</label>
                                <input type="text" name="menu_link" id="menu_link" class="form-control"
                                    placeholder="Masukkan Link Menu" readonly>
                            </div>
                            <div class="form-group">
                                <label>Icon Menu</label>
                                <input type="text" name="menu_icon" class="form-control"
                                    placeholder="Masukkan Icon Menu">
                                <small>contoh : fas fa-icon</small>
                            </div>
                            <div class="form-group">
                                <label>Parent</label>
                                <select name="parent_id" class="form-control select2bs4">
                                    <option value="">Pilih</option>
                                    @foreach ($menu as $item)
                                        <option value="{{ $item->menu_id }}">{{ $item->menu_name }}</option>
                                    @endforeach
                                </select>
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
                            <input type="hidden" name="menu_id_edit" id="menu_id_edit">
                            <div class="form-group">
                                <label>Level Menu</label>
                                <select name="id_level_edit" id="id_level_edit" class="form-control select2bs4">
                                    <option value="">Pilih...</option>
                                    @foreach ($level as $item)
                                        <option value="{{ $item->id_level }}">{{ $item->level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Menu</label>
                                <input type="text" name="menu_name_edit" id="menu_name_edit" class="form-control"
                                    placeholder="Masukkan Nama Menu">
                            </div>
                            <div class="form-group">
                                <label>Link Menu</label>
                                <input type="text" name="menu_link_edit" id="menu_link_edit" class="form-control"
                                    placeholder="Masukkan Link Menu" readonly>
                            </div>
                            <div class="form-group">
                                <label>Icon Menu</label>
                                <input type="text" name="menu_icon_edit" id="menu_icon_edit" class="form-control"
                                    placeholder="Masukkan Icon Menu">
                                <small>contoh : fas fa-icon</small>
                            </div>
                            <div class="form-group">
                                <label>Parent</label>
                                <select name="parent_id_edit" id="parent_id_edit" class="form-control select2bs4">
                                    <option value="">Pilih</option>
                                    @foreach ($menu as $item)
                                        <option value="{{ $item->menu_id }}">{{ $item->menu_name }}</option>
                                    @endforeach
                                </select>
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

            // Generate Slug
            $("#menu_name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#menu_link").val(Text);
            });

            // Generate Slug Edit
            $("#menu_name_edit").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#menu_link_edit").val(Text);
            });

            $("#form_add").validate({
                rules: {
                    id_level: {
                        required: true
                    },
                    menu_name: {
                        required: true
                    },
                    menu_icon: {
                        required: true
                    },
                },
                messages: {
                    id_level: {
                        required: "Pilih Level Menu"
                    },
                    menu_name: {
                        required: "Nama Menu Wajib Diisi"
                    },
                    menu_icon: {
                        required: "Icon Menu Wajib Diisi"
                    },
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

            $('#menu_name').focus();
        })

        $('#form_add').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = "{{ route('admin.menu.add') }}";
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
            var menu_id = button.data('menu_id');
            var id_level = button.data('id_level');
            var menu_name = button.data('menu_name');
            var menu_link = button.data('menu_link');
            var menu_icon = button.data('menu_icon');
            var parent_id = button.data('parent_id');

            var modal = $(this);
            modal.find('#title_edit').text("Edit");
            modal.find('#menu_id_edit').val(menu_id);
            modal.find('#id_level_edit').val(id_level).change();
            modal.find('#menu_name_edit').val(menu_name);
            modal.find('#menu_link_edit').val(menu_link);
            modal.find('#menu_icon_edit').val(menu_icon);
            modal.find('#parent_id_edit').val(parent_id).change();
        })

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            var url = "{{ route('admin.menu.edit') }}";
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
            var menu_id = event.target.querySelector('input[name="menu_id"]').value;
            var menu_name = event.target.querySelector('input[name="menu_name"]').value;
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
                    var url = "{{ route('admin.menu.delete') }}";
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
            var url = "{{ route('admin.menu.data') }}";
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
                        data: 'menu_id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "align-middle"
                    },
                    {
                        data: 'level',
                        name: 'level',
                        className: "align-middle"
                    },
                    {
                        data: 'menu_name',
                        name: 'menu_name',
                        className: "align-middle"
                    },
                    {
                        data: 'menu_link',
                        name: 'menu_link',
                        className: "align-middle"
                    },
                    {
                        data: 'menu_icon',
                        name: 'menu_icon',
                        className: "align-middle",
                    },
                    {
                        data: 'parent_id',
                        name: 'parent_id',
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
