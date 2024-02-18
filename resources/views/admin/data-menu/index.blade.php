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
                        <h1>{{ $menu->menu_name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">{{ $menu->menu_name }}
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
                        <h2>SELAMAT ANDA BISA MENGAKSES MENU INI</h2>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        {{-- Modal Tambah Kategori --}}
        {{-- <form action="#" id="form_add" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="modal fade" id="modal_add">
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
                                <input type="hidden" name="sub_kategori_id" value="{{ $subKategori->id }}">
                            </div>
                            <div class="form-group">
                                <label for="sub_sub_kategori">Nama Sub Sub Kategori</label>
                                <input type="input" name="sub_sub_kategori" class="form-control" id="sub_sub_kategori"
                                    placeholder="Masukkan Nama Kategori" value="{{ old('sub_sub_kategori') }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Dokumen</label>
                                <input type="text" name="nama" class="form-control" id="nama"
                                    placeholder="Masukkan Nama Dokumen">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Upload File</label>
                                <div id="container-dropzone">
                                    <div class="needsclick dropzone" id="image-dropzone">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="form_submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> --}}

        {{-- Modal Edit --}}
        {{-- <form action="" method="POST" enctype="multipart/form-data" id="form_edit">
            @csrf
            <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title_edit">Edit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_edit" name="id_edit">
                            <div class="form-group">
                                <label for="sub_sub_kategori_edit">Nama Sub Sub Kategori</label>
                                <input type="input" name="sub_sub_kategori_edit" class="form-control"
                                    id="sub_sub_kategori_edit" placeholder="Masukkan Nama Kategori"
                                    value="{{ old('sub_sub_kategori') }}">
                            </div>
                            <div class="form-group">
                                <label for="nama_edit">Nama Dokumen</label>
                                <input type="text" name="nama_edit" class="form-control" id="nama_edit"
                                    placeholder="Masukkan Nama Dokumen">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="keterangan_edit" rows="3" placeholder="Masukkan Keterangan"
                                    id="keterangan_edit"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Upload File</label>
                                <input type="hidden" name="file_lama" id="file_lama">
                                <small>(*Kosongkan jika tidak ingin mengubah file)</small>
                                <div id="container-dropzone-edit">
                                    <div class="needsclick dropzone" id="image-dropzone-edit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="form_submit_edit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> --}}
    </div>
@endsection

@section('script')

    {{-- <script>
        $('#form_add').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = "{{ route('admin.dokumen.add') }}";
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
                    $('#modal_add').modal('toggle');
                    $('#form_submit').attr('disabled', false);
                    swalToast(response.message, response.data);
                    cardRefresh();
                    if (response.message == 200) {
                        forgetDokumenSisa();
                    }

                    $('.dokumen').remove();
                    $('#container-dropzone').empty();
                    $('#container-dropzone').append(
                        '<div class="needsclick dropzone" id="image-dropzone"></div>'
                    );
                    createDropZoneAdd();
                }
            });
        });

        $('#modal_edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var dok_id = button.data('dok_id');
            var sub_sub_kategori = button.data('sub_sub_kategori');
            var nama = button.data('nama');
            var keterangan = button.data('keterangan');
            var file = button.data('file');

            var modal = $(this);
            modal.find('#title_edit').text("Edit");
            modal.find('#id_edit').val(dok_id);
            modal.find('#sub_sub_kategori_edit').val(sub_sub_kategori);
            modal.find('#nama_edit').val(nama);
            modal.find('#keterangan_edit').val(keterangan);
            modal.find('#file_lama').val(file);
        })

        $('#form_edit').submit(function(e) {
            e.preventDefault();
            myDropzoneEdit.processQueue();

            myDropzoneEdit.on("success", function(file, response) {
                $('#form_edit').append(
                    '<input type="hidden" name="dokumen_edit" class="dokumen-edit" value="' + response
                    .name +
                    '">')
                uploadedImageMapEdit[file.upload.filename] = response.name;
                saveDokumenSisa(response.name);

                var url = "{{ route('admin.dokumen.edit') }}";
                var fd = new FormData($('#form_edit')[0]);

                $.ajax({
                    type: "post",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response.data);
                        $('#modal_edit').modal('toggle');
                        $('#form_submit_edit').prop("disabled", false);
                        swalToast(response.message, response.data);
                        cardRefresh();
                        if (response.message == 200) {
                            forgetDokumenSisa();
                        }

                        $('.dokumen-edit').remove();
                        $('#container-dropzone-edit').empty();
                        $('#container-dropzone-edit').append(
                            '<div class="needsclick dropzone" id="image-dropzone-edit"></div>'
                        );

                        createDropZoneEdit();

                        // myDropzoneEdit.removeFile(file);
                    }
                });
            });
        });
    </script>

    <script>
        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
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
                    var url = "{{ route('admin.dokumen.delete') }}";
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
                        }
                    });
                }
            })
        }

        function dataTable(id) {
            var url =
                "{{ route('admin.dokumen.data', ['kategori' => $kategori->id, 'subKategori' => $subKategori->id]) }}";
            console.log(url);
            var datatable = $(id).DataTable({
                responsive: true,
                autoWidth: false,
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
                        var div = '<div class="overlay">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('#card').append(div);
                    },
                    complete: function() {
                        $('.overlay').remove();
                    }
                },
                deferRender: true,
                columns: [{
                        data: 'dok_id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "align-middle"
                    },
                    {
                        data: 'nama_sub_kategori',
                        name: 'nama_sub_kategori',
                        className: "align-middle"
                    },
                    {
                        data: 'sub_sub_kategori',
                        name: 'sub_sub_kategori',
                        className: "align-middle"
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        className: "align-middle"
                    },
                    {
                        data: 'path',
                        name: 'path',
                        className: "align-middle"
                    },
                    {
                        data: 'uploader',
                        name: 'uploader',
                        className: "align-middle"
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
    </script> --}}
@endsection
