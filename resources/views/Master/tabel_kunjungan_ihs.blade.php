<table id="tbihskunjungan" class="table table-sm table-bordered table-hover">
    <thead>
        <th>No RM</th>
        <th>Id satu sehat Pasien</th>
        <th>Id satu sehat Kunjungan</th>
        <th>Nama Pasien</th>
        <th>Nama Dokter</th>
        <th>Nama Poli</th>
        <th>Tgl Masuk</th>
        <th>Jam Masuk</th>
        <th>Jam Selesai</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->kode_ihs_pasien }}</td>
                <td>{{ $d->ihs_code }}</td>
                <td>{{ $d->nama_pasien }}</td>
                <td>{{ $d->nama_dokter }}</td>
                <td>{{ $d->nama_poli }}</td>
                <td>{{ $d->tgl_masuk }}</td>
                <td>{{ $d->jam_masuk }}</td>
                <td>{{ $d->jam_selesai }}</td>
                <td>@if($d->status_ihs == 1) Sudah dikirim @else Belum dikirim @endif <br>
                    @if($d->status_kunjungan == 0)
                        Counter Gagal dikirim <br>
                    @endif
                    @if($d->status_masuk_ruangan == 0)
                        Gagal Update Counter <br>
                    @endif
                    @if($d->status_anamnesis == 0)
                        Anamnesa belum dikirim  <br>
                    @endif
                    @if($d->status_diagnosis == 0)
                        Diagnosa belum dikirkm  <br>
                    @endif
                    @if($d->status_encounter == 0)
                        Pasien Belum dipulangkan  <br>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-success kirimkunjungan" idk="{{ $d->idk }}"><i
                            class="bi bi-send"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tbihskunjungan").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 6,
            "searching": true
        })
    });
    $('#tbihskunjungan').on('click', '.kirimkunjungan', function() {
        idk = $(this).attr('idk')
        Swal.fire({
            title: "Data Kunjungan pasien akan dikirim ke satu sehat ?",
            text: "Klik cancel untuk batal",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, kirim!"
        }).then((result) => {
            if (result.isConfirmed) {
                kirimsatusehat(idk)
            }
        });
    });
    function kirimsatusehat(idk) {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                idk
            },
            url: '<?= route('kirimdatakunjungansatusehat') ?>',
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
                spinner.hide()
                if (data.kode == 500) {
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
                    location.reload()
                }
            }
        });
    }
</script>
