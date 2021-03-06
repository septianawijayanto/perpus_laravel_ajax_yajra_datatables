@extends('admin.layouts.master')
@section('konten')
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">{{$title}}</h3>

    </div>
    <div class="panel-body">
        <button type="button" class="btn btn-warning btn-xs btn-refresh"><i class="fa fa-refresh"></i></button>
        <a href="javascript:void(0)" class="btn btn-primary btn-xs" id="tombol-tambah"><i class="fa fa-plus"></i> </a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <!-- Tabel -->
            <table class="table table-responsiv" id="table_anggota">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Agama</th>
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
                                <label for="exampleFormControlInput1">Nama</label>
                                <input name="nama" id="nama" required type="text" class="form-control" placeholder="Input Nama" value="">
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Username</label>
                                <input name="username" id="username" required type="text" class="form-control" placeholder="Input Username" value="">
                            </div>
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select name="level" id="level" required class="form-control" required>
                                    <option value="">-Pilih-</option>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Password</label>
                                <input name="password" id="password" required type="password" class="form-control" placeholder="Input Password" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Tanggal Lahir</label>
                                <input name="tgl_lahir" id="tgl_lahir" required type="date" class="form-control" placeholder="Input Tanggal Lahir" value="">
                            </div>
                            <div class="form-group ">
                                <label for="exampleFormControlInput1">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="Input Alamat" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select name="agama" id="agama" required class="form-control" required>
                                    <option value="">-Pilih-</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Protestan">Protestan</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
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



@stop

@section('scripts')


<script type="text/javascript">
    $(document).ready(function() {
        $('#table_anggota').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('anggota')}}",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'nama',
                    name: 'nama'
                }, {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'level',
                    name: 'level'
                },
                {
                    data: 'tgl_lahir',
                    name: 'tgl_lahir'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'agama',
                    name: 'agama',
                }, {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [0, 'DESC']
            ]
        });

        // btn refresh
        $('.btn-refresh').click(function(e) {
            e.preventDefault();
            $('.preloader').fadeIn();
            location.reload();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Hapus Data
        //Ketika Tombol hapus di klik keluar Modal Hapus 
        $(document).on('click', '.delete', function() {
            dataId = $(this).attr('id');
            $('#konfirmasi-modal').modal('show');
        });
        //jika tombol hapus pada modal konfirmasi di klik maka
        $('#tombol-hapus').click(function() {
            $.ajax({

                url: "anggota/" + dataId, //eksekusi ajax ke url ini
                type: 'delete',
                beforeSend: function() {
                    $('#tombol-hapus').text('Menghapus...'); //set text untuk tombol hapus
                },
                success: function(data) { //jika sukses
                    setTimeout(function() {
                        $('#konfirmasi-modal').modal('hide'); //sembunyikan konfirmasi modal
                        var oTable = $('#table_anggota').dataTable();
                        oTable.fnDraw(false); //reset datatable
                    });
                    toastr.success( //tampilkan toastr warning
                        'Data Berhasil Dihapus',
                    );
                }
            })
        });
        //TOMBOL TAMBAH DATA
        //jika tombol-tambah diklik maka
        $('#tombol-tambah').click(function() {
            $('#button-simpan').val("create-post"); //valuenya menjadi create-post
            $('#id').val(''); //valuenya menjadi kosong
            $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
            $('#modal-judul').html("Tambah Anggota Baru"); //valuenya tambah anggota baru
            $('#modal-tambah-edit').modal('show'); //modal tampil
        });



        //ketika class edit-post yang ada pada tag body di klik maka
        $('body').on('click', '.edit-post', function() {
            var data_id = $(this).data('id');
            $.get('anggota/' + data_id + '/edit', function(data) {
                $('#modal-judul').html("Edit Data Anggota");
                $('#tombol-simpan').val("edit-post");
                $('#modal-tambah-edit').modal('show');

                //set value masing-masing id berdasarkan data yg diperoleh dari ajax get request diatas               
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#username').val(data.username);
                $('#level').val(data.level);
                $('#password').val(data.password);
                $('#tgl_lahir').val(data.tgl_lahir);
                $('#alamat').val(data.alamat);
                $('#agama').val(data.agama);

            })
        });


        //SIMPAN & UPDATE DATA DAN VALIDASI (SISI CLIENT)
        //jika id = form-tambah-edit panjangnya lebih dari 0 atau bisa dibilang terdapat data dalam form tersebut maka
        //jalankan jquery validator terhadap setiap inputan dll dan eksekusi script ajax untuk simpan data
        if ($("#form-tambah-edit").length > 0) {
            $("#form-tambah-edit").validate({
                submitHandler: function(form) {
                    var actionType = $('#tombol-simpan').val();
                    $('#tombol-simpan').html('Saving ...');

                    $.ajax({
                        data: $('#form-tambah-edit')
                            .serialize(), //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                        url: "{{ route('anggota.store') }}", //url simpan data
                        type: "POST", //karena simpan kita pakai method POST
                        dataType: 'json', //data tipe kita kirim berupa JSON
                        success: function(data) { //jika berhasil 
                            $('#form-tambah-edit').trigger("reset"); //form reset
                            $('#modal-tambah-edit').modal('hide'); //modal hide
                            $('#tombol-simpan').html('Simpan'); //tombol simpan
                            var oTable = $('#table_anggota').dataTable(); //inialisasi datatable
                            oTable.fnDraw(false); //reset datatable
                            toastr.success( //tampilkan toastr dengan notif data berhasil disimpan pada posisi kanan bawah
                                'Data Berhasil Disimpan',
                            );
                        },
                        error: function(data) { //jika error tampilkan error pada console
                            console.log('Error:', data);
                            $('#tombol-simpan').html('Simpan');
                        }
                    });
                }
            })
        }
    });
</script>


@endsection