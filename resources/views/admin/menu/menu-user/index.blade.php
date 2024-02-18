@extends('admin.layouts.template')
@section('title', 'Admin | Data Akses Menu')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Data Akses Menu {{ $menu->menu_name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Data Akses Menu {{ $menu->menu_name }}
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
                                                <th>User</th>
                                                <th>create date</th>
                                                <th>update by</th>
                                                <th>Update date</th>
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
                            <input type="hidden" name="menu_id" value="{{ $menu->menu_id }}">
                            <div class="form-group">
                                <label>Nama User</label>
                                <select name="id_user" class="form-control select2bs4">
                                    <option value="">Pilih...</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id_user }}">{{ $item->nama_user }} - {{ $item->email }}
                                        </option>
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

        });
    </script>

    <script>
        $('#modal_add').on('shown.bs.modal', function() {

            $('#menu_name').focus();
        })

        $('#form_add').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = "{{ route('admin.menu.akses-menu-user.add') }}";
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
    </script>

    <script>
        function deleteData(event) {
            event.preventDefault();
            var no_setting = event.target.querySelector('input[name="no_setting"]').value;
            var nama_user = event.target.querySelector('input[name="nama_user"]').value;
            var menu_name = event.target.querySelector('input[name="menu_name"]').value;
            var menu_id = event.target.querySelector('input[name="menu_id"]').value;
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
                    var url = "{{ route('admin.menu.akses-menu-user.delete') }}";
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
            var url = "{{ route('admin.menu.akses-menu-user.data') }}";
            var menu_id = "{{ $menu->menu_id }}";
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
                    data: {
                        menu_id: menu_id,
                    },
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
                        data: 'no_setting',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "align-middle"
                    },
                    {
                        data: 'user',
                        name: 'user',
                        className: "align-middle"
                    },
                    {
                        data: 'create_date',
                        name: 'create_date',
                        className: "align-middle"
                    },
                    {
                        data: 'update_by',
                        name: 'update_by',
                        className: "align-middle",
                    },
                    {
                        data: 'update_date',
                        name: 'update_date',
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
