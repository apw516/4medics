<div class="card mt-3">
    <div class="card-header">Data Pasien</div>
    <div class="card-body">
        <table id="tabelpasienpoli" class="table table-sm table-bordered text-sm">
            <thead>
                <th>Tgl Masuk</th>
                <th>Kunjungan Ke</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>Unit Tujuan</th>
                <th>Dokter Pemeriksa</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->tgl_masuk }}</td>
                        <td>{{ $d->counter }}</td>
                        <td>{{ $d->no_rm }}</td>
                        <td>{{ $d->nama_pasien }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>{{ $d->nama_unit }}</td>
                        <td>{{ $d->nama_dokter }}</td>
                        <td><button class="btn btn-success btn-sm pilihpasien" kode_kunjungan={{ $d->kode_kunjungan }}><i
                                    class="bi bi-journal-plus r-2"></i></button></td>
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
    $(".pilihpasien").on('click', function(event) {
        $(".v_kedua").removeAttr('hidden', true);
        $(".v_utama").attr('hidden', true);
        kode_kunjungan = $(this).attr('kode_kunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kode_kunjungan
            },
            url: '<?= route('ambil_data_pasien_erm') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    });
