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
            <table class="table table-responsiv" id="table_transaksi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
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
                    <div class="form-group ">
                        <label for="exampleFormControlInput1">Koda transaksi</label>
                        <input name="kode_transaksi" id="kode_transaksi" required type="text" class="form-control" placeholder="Input Koda transaksi" value="">
                    </div>
                    <div class="form-group">
                        <label for="anggota_id">Nama</label>
                        <select name="anggota_id" id="anggota_id" required class="form-control" required>
                            <option value="">-Pilih-</option>
                            @foreach($anggota as $anggota)
                            <option value="{{$anggota->id}}">{{$anggota->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="buku_id">Judul Buku</label>
                        <select name="buku_id" id="buku_id" required class="form-control" required>
                            <option value="">-Pilih-</option>
                            @foreach($buku as $buku)
                            <option value="{{$buku->id}}">{{$buku->judul_buku}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="exampleFormControlInput1">Tanggal Pinjam</label>
                        <input name="tgl_pinjam" id="tgl_pinjam" required type="datetime-local" class="form-control" value="">
                    </div>
                    <div class="form-group ">
                        <label for="exampleFormControlInput1">Tanggal Kembali</label>
                        <input name="tgl_kembali" id="tgl_kembali" required type="datetime-local" class="form-control" value="">
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
        $('#table_transaksi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('transaksi')}}",
                type: "GET"
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
            }, {
                data: 'kode_transaksi',
                name: 'kode_transaksi',
            }, {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'judul_buku',
                name: 'judul_buku'
            }, {
                data: 'tgl_pinjam',
                name: 'tgl_pinjam'
            }, {
                data: 'tgl_kembali',
                name: 'tgl_kembali'
            }, {
                data: 'status',
                name: 'status'
            }, {
                data: 'action',
                name: 'action'
            }, ],
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
            $('#modal-judul').html('Tambah Data transaksi');
            $('#modal-tambah-edit').modal('show')
        });

        //Tombol Edit
        $('body').on('click', '.edit-post', function() {
            var data_id = $(this).data('id');
            $.get('transaksi/' + data_id + '/edit', function(data) {
                $('#modal-judul').html('Edit Data transaksi');
                $('#tombol-simpan').val('edit-post');
                $('#modal-tambah-edit').modal('show');

                $('#id').val(data.id);
                $('#kode_transaksi').val(data.kode_transaksi);
                $('#anggota_id').val(data.anggota_id);
                $('#buku_id').val(data.buku_id);
                $('#tgl_pinjam').val(data.tgl_pinjam);
                $('#tgl_kembali').val(data.tgl_kembali)
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
                        url: "{{route('transaksi.store')}}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            $('#form-tambah-edit').trigger('reset');
                            $('#modal-tambah-edit').modal('hide');
                            $('#tombol-simpan').html('Simpan');
                            var oTable = $('#table_transaksi').dataTable();
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


        // btn refresh
        $('.btn-refresh').click(function(e) {
            e.preventDefault();
            $('.preloader').fadeIn();
            location.reload();
        })

    });
</script>


@endsection