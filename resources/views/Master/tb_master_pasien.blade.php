<button class="btn btn-success" onclick="sinkrondaapasien()"><i class="bi bi-send"></i> Sinkron Data Satu
    Sehat</button>
<table id="tabelpasien" class="table table-sm table-bordered text-sm table-hover">
    <thead>
        <th>No RM</th>
        <th>ID satu sehat</th>
        <th>No Identitas</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($pasien as $p)
            <tr>
                <td>{{ $p->no_rm }}</td>
                <td>{{ $p->id_satu_sehat }}</td>
                <td>{{ $p->NIK }}</td>
                <td>{{ $p->nama_pasien }}</td>
                <td>{{ $p->TGL_LAHIR }}</td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->alamat }}</td>
                <td>
                    <button class="btn btn-xs btn-warning pilihpasien" rm="{{ $p->no_rm }}"><i
                            class="bi bi-pencil-square"></i></button>
                </td>
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
            url: '<?= route('ambilformeditpasien') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    });

    function sinkrondaapasien() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data pasien akan dikirim ke data satu sehat ...",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Kirim ..."
        }).then((result) => {
            if (result.isConfirmed) {
                kirimpasien()
            }
        });
    }

    function kirimpasien() {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}"
            },
            url: '<?= route('kirimasiensatusehat') ?>',
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
