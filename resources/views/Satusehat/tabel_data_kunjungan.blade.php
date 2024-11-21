<div class="card mt-3">
    <div class="card-header">Data Pasien</div>
    <div class="card-body">
        <table id="tabelpasienpoli" class="table table-sm table-bordered text-sm">
            <thead>
                <th>Tgl Masuk</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Unit Tujuan</th>
                <th>Dokter Pemeriksa</th>
                <th>Status Satu Sehat</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->tgl_masuk }}</td>
                        <td>{{ $d->no_rm }}</td>
                        <td>{{ $d->nama_pasien }}</td>
                        <td>{{ $d->nama_unit }}</td>
                        <td>{{ $d->nama_dokter }}</td>
                        <td>
                            @if ($d->bridging_satu_sehat == 1)
                                Sudah Terkirim
                            @else
                                Belum Dikirim
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm editkunjungan"
                                kode_kunjungan={{ $d->kode_kunjungan }}><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-success btn-sm kirimpasien" kode_kunjungan={{ $d->kode_kunjungan }}><i
                                    class="bi bi-send"></i></button>
                            <button class="btn btn-danger btn-sm pulangkanpasien"
                                kode_kunjungan={{ $d->kode_kunjungan }}><i class="bi bi-calendar2-x"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function() {
        $("#tabelpasienpoli").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 6,
            "searching": true
        })
    });
    $(".editkunjungan").on('click', function(event) {

    });
    $(".kirimpasien").on('click', function(event) {
        kodekunjungan = $(this).attr('kode_kunjungan')
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data kunjungan akan dikirim ke platform satu sehat ...",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Kirim"
        }).then((result) => {
            if (result.isConfirmed) {
                kirimpasien(kodekunjungan)
            }
        });
    });

    function kirimpasien(kode) {
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                kode
            },
            url: '<?= route('kirimkunjunganpasien') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(data) {
                if (data.kode == 500) {
                    spinner.hide()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: data.message,
                        footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.message,
                        footer: ''
                    })
                }
            }
        });
    }
    $(".pulangkanpasien").on('click', function(event) {
        kodekunjungan = $(this).attr('kode_kunjungan')
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data kunjungan akan ditutup diplatform satu sehat ...",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Kirim"
        }).then((result) => {
            if (result.isConfirmed) {
                pulangkanpasien(kodekunjungan)
            }
        });
    });
    function pulangkanpasien($kodekunjungan)
    {
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                kodekunjungan
            },
            url: '<?= route('pulangkanpasien') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(data) {
                if (data.kode == 500) {
                    spinner.hide()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: data.message,
                        footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.message,
                        footer: ''
                    })
                }
            }
        });
    }
