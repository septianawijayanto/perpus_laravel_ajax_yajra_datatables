@extends('admin.layouts.master')
@section('konten')
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">{{$title}}</h3>

    </div>
    <div class="panel-body">
        <button type="button" class="btn btn-warning btn-xs btn-refresh"><i class="fa fa-refresh"></i></button>
        <button id="tombol-tambah" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <!-- Tabel -->
            <table class="table table-responsiv" id="table_buku">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode buku</th>
                        <th>Nama buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Klasifikasi</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

            </table>
            <!-- End Tabel -->
        </div>
    </div>
</div>
<!-- MULAI MODAL FORM TAMBAH/EDIT-->
<div class="modal fade" id="modal-tambah-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-judul"></h5>
            </div>

            <div class="modal-body">
                <form id="form-tambah-edit" enctype="multipart/form-data">
                    <div class="form-group ">
                        <input name="id" id="id" required type="hidden" class="form-control" value="">
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Koda Buku</label>
                                <input name="kode" id="kode" required type="text" class="form-control" placeholder="Input Koda Buku" value="">
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Judul Buku</label>
                                <input name="judul_buku" id="judul_buku" required type="text" class="form-control" placeholder="Input Judul Buku" value="">
                            </div>
                            <!-- <div class="form-group ">
                                <label for="exampleFormControlInput1">gambar</label>
                                <input name="gambar" id="gambar" required type="file" class="form-control" placeholder="Input Gambar" value="">
                            </div> -->
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Penulis</label>
                                <input name="penulis" id="penulis" required type="text" class="form-control" placeholder="Input Penulis" value="">
                            </div>
                            <div class="form-group">
                                <label for="penerbit_id">Penerbit</label>
                                <select name="penerbit_id" id="penerbit_id" required class="form-control" required>
                                    <option value="">-Pilih-</option>
                                    @foreach($penerbit as $pen)
                                    <option value="{{$pen->id}}">{{$pen->nama_penerbit}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="klasifikasi_id">Klasifikasi</label>
                                <select name="klasifikasi_id" id="klasifikasi_id" required class="form-control" required>
                                    <option value="">-Pilih-</option>
                                    @foreach($klasifikasi as $klaf)
                                    <option value="{{$klaf->id}}">{{$klaf->nama_klasifikasi}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select name="kelas" id="kelas" required class="form-control" required>
                                    <option value="">-Pilih-</option>
                                    @foreach($kelas as $kelas)
                                    <option value="{{$kelas}}">{{$kelas}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Tahun Terbit</label>
                                <input name="tahun_terbit" id="tahun_terbit" required type="text" class="form-control" placeholder="Input Tahun Terbit" value="">
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Tahun Pengadaan</label>
                                <input name="tahun_pengadaan" id="tahun_pengadaan" required type="text" class="form-control" placeholder="Input Tahun Pengadaan" value="">
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Sumber Dana</label>
                                <input name="sumber_dana" id="sumber_dana" required type="text" class="form-control" placeholder="Input Sumber Dana" value="">
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Jumlah</label>
                                <input name="jumlah" id="jumlah" required type="text" class="form-control" placeholder="Input Jumlah" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" id="tombol-simpan" value="create" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->
@endsection
@section('scripts')


<script type="text/javascript">
    $(document).ready(function() {
        $('#table_buku').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('buku')}}",
                type: "GET"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                }, {
                    data: 'kode',
                    name: 'kode',
                },
                {
                    data: 'judul_buku',
                    name: 'judul_buku',
                }, {
                    data: 'penulis',
                    name: 'penulis'
                }, {
                    data: 'penerbit',
                    name: 'penerbit'
                }, {
                    data: 'klasifikasi',
                    name: 'klasifikasi'
                }, {
                    data: 'jumlah',
                    name: 'jumlah'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [0, 'DESC']
            ]
        });

        $.ajaxSetup({
            headers: {
                'X_CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Tombol Tambah
        $('#tombol-tambah').click(function() {
            $('#tombol-simpan').val('create-post');
            $('#id').val('');
            $('#form-tambah-edit').trigger('reset');
            $('#modal-judul').html('Tambah Data buku');
            $('#modal-tambah-edit').modal('show')
        });

        //Tombol Edit
        $('body').on('click', '.edit-post', function() {
            var data_id = $(this).data('id');
            $.get('buku/' + data_id + '/edit', function(data) {
                $('#modal-judul').html('Edit Data buku');

                $('#tombol-simpan').val('edit-post');
                $('#modal-tambah-edit').modal('show');

                $('#id').val(data.id);
                $('#kode').val(data.kode);
                $('#judul_buku').val(data.judul_buku);
                $('#penulis').val(data.penulis);
                $('#penerbit_id').val(data.penerbit_id);
                $('#klasifikasi_id').val(data.klasifikasi_id);
                $('#kelas').val(data.kelas);
                $('#tahun_terbit').val(data.tahun_terbit);
                $('#tahun_pengadaan').val(data.tahun_pengadaan);
                $('#sumber_dana').val(data.sumber_dana);
                $('#jumlah').val(data.jumlah);
            })
        });

        //Simpan dan Edit STore
        if ($('#form-tambah-edit').length > 0) {
            $('#form-tambah-edit').validate({
                submitHandler: function(form) {
                    var actionType = $('#tombol-simpan').val();
                    $('#tombol-simpan').html('Saving ...');

                    $.ajax({
                        data: $('#form-tambah-edit').serialize(),
                        url: "{{route('buku.store')}}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            $('#form-tambah-edit').trigger('reset');
                            $('#modal-tambah-edit').modal('hide');
                            $('#tombol-simpan').html('Simpan');
                            var oTable = $('#table_buku').dataTable();
                            oTable.fnDraw(false);
                            toastr.success('Data Berhasil Disimpan');
                        },
                        error: function(data) {
                            console.log('Eror', data);
                            $('#tombol-simpan').html('Simpan');
                        }
                    })
                }
            })
        }

        //Tombol Hapus
        $(document).on('click', '.delete', function() {
            dataid = $(this).attr('id');
            $('#konfirmasi-modal').modal('show');
        });

        //Delete
        $('#tombol-hapus').click(function() {
            $.ajax({
                url: "buku/" + dataid,
                type: 'delete',
                beforeSend: function() {
                    $('#tombol-hapus').text('Menghapus...');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#konfirmasi-modal').modal('hide');
                        var oTable = $('#table_buku').dataTable();
                        oTable.fnDraw(false);
                    });
                    toastr.success('Data Berhasil Dihapus');
                }

            })
        });


        // btn refresh
        $('.btn-refresh').click(function(e) {
            e.preventDefault();
            $('.preloader').fadeIn();
            location.reload();
        })

    });
</script>


@endsection