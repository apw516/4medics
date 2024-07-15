<table id="tabelpasien" class="table table-sm table-bordered text-sm table-hover">
    <thead>
        <th>No RM</th>
        <th>No Identitas</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
    </thead>
    <tbody>
        @foreach ($mt_pasien as $p )
            <tr class="pilihpasien" rm="{{ $p->no_rm }}">
                <td>{{ $p->no_rm}}</td>
                <td>{{ $p->NIK}}</td>
                <td>{{ $p->nama_pasien}}</td>
                <td>{{ $p->TGL_LAHIR}}</td>
                <td>{{ $p->jenis_kelamin}}</td>
                <td>{{ $p->alamat}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tabelpasien").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 6,
            "searching": true
        })
    });
    $('#tabelpasien').on('click', '.pilihpasien', function() {
        rm = $(this).attr('rm')
        $(".v_kedua").removeAttr('hidden', true);
        $(".v_utama").attr('hidden', true);
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                rm
            },
            url: '<?= route('ambilformpendaftaran') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    });
</script>
