<table id="tabelpasien" class="table table-sm table-bordered text-sm table-hover">
    <thead>
        <th>No RM</th>
        <th>No Identitas</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($mt_pasien as $p)
            <tr>
                <td>{{ $p->no_rm }}</td>
                <td>{{ $p->NIK }}</td>
                <td>{{ $p->nama_pasien }}</td>
                <td>{{ $p->TGL_LAHIR }}</td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->alamat }}</td>
                <td>
                    <button class="btn btn-xs btn-success pilihpasien" rm="{{ $p->no_rm }}"><i
                            class="bi bi-r-square"></i></button>
                    <button class="btn btn-xs btn-warning editpasien" rm="{{ $p->no_rm }}"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-xs btn-danger hapuspasien" rm="{{ $p->no_rm }}" nama="{{ $p->nama_pasien }}"><i
                            class="bi bi-file-earmark-x"></i></button>
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
            url: '<?= route('ambilformpendaftaran') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    });
    $('#tabelpasien').on('click', '.hapuspasien', function() {
        rm = $(this).attr('rm')
        nama = $(this).attr('nama')
        Swal.fire({
            title: "Data Pasien " + nama + " Nomor RM " + rm + " Akan dihapus",
            text: "Klik cancel untuk membatalkan",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus Data!"
        }).then((result) => {
            if (result.isConfirmed) {
                hapuspasien(rm)
            }
        });
    });
    $('#tabelpasien').on('click', '.editpasien', function() {
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
    function hapuspasien(rm) {
        Swal.fire({
            title: "Anda Yakin ?",
            text: "Klik cancel untuk membatalkan",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Saya yakin!"
        }).then((result) => {
            if (result.isConfirmed) {
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        rm
                    },
                    url: '<?= route('hapuspasien') ?>',
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
        });
    }
</script>
