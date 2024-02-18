@extends('admin.layouts.template')
@section('title', 'Admin | Log Error')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Log Error</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Log Error
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
                                                <th>Nama User</th>
                                                <th>Error Date</th>
                                                <th>Modules</th>
                                                <th>Controller</th>
                                                <th>function</th>
                                                <th>error line</th>
                                                <th>error message</th>
                                                <th>status</th>
                                                <th>param</th>
                                                <th>create date</th>
                                                <th>update by</th>
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
        function dataTable(id) {
            var url = "{{ route('admin.error-application.data') }}";
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
                        data: 'error_id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "align-middle"
                    },
                    {
                        data: 'nama_user',
                        name: 'nama_user',
                        className: "align-middle"
                    },
                    {
                        data: 'error_date',
                        name: 'error_date',
                        className: "align-middle"
                    },
                    {
                        data: 'modules',
                        name: 'modules',
                        className: "align-middle"
                    },
                    {
                        data: 'controller',
                        name: 'controller',
                        className: "align-middle",
                    },
                    {
                        data: 'function',
                        name: 'function',
                        className: "align-middle",
                    },
                    {
                        data: 'error_line',
                        name: 'error_line',
                        className: "align-middle",
                    },
                    {
                        data: 'error_message',
                        name: 'error_message',
                        className: "align-middle",
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: "align-middle",
                    },
                    {
                        data: 'param',
                        name: 'param',
                        className: "align-middle",
                    },
                    {
                        data: 'create_date',
                        name: 'create_date',
                        className: "align-middle",
                    },
                    {
                        data: 'update_by',
                        name: 'update_by',
                        className: "align-middle",
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
    </script>
@endpush
