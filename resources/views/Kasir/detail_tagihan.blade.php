<button class="btn btn-danger" onclick="kembali()">
    <i class="bi bi-backspace-fill mr-2"></i> Batal</button>
<input hidden name="kodekunjungan" id="kodekunjungan" type="text" value="{{ $kode_kunjungan }}">
<div class="card mt-2">
    <div class="card-header">Detail Tagihan Pasien</div>
    <div class="card-body">
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <th>Kode layanan Header</th>
                <th>Kode layanan Detail</th>
                <th>Nama</th>
                <th>Tarif</th>
                <th>Jumlah</th>
                <th>Total</th>
            </thead>
            <tbody>
                @php
                    $gt = 0;
                @endphp
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->kode_layanan_header }}</td>
                        <td>{{ $d->id_layanan_detail }}</td>
                        <td>{{ $d->keterangan01 }}</td>
                        <td>
                            Rp. {{ number_format($d->total_tarif, 2) }}
                        </td>
                        <td>{{ $d->jumlah_layanan }}</td>
                        <td>
                            Rp. {{ number_format($d->total_layanan, 2) }}
                        </td>
                    </tr>
                    @php
                        $gt = $d->total_layanan + $gt;
                    @endphp
                @endforeach
                <tr class="text-center text-bold bg-light">
                    <td colspan="5">Grand Total</td>
                    <td>Rp. {{ number_format($gt, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger" onclick="kembali()"><i class="bi bi-backspace-fill mr-2"></i> Kembali</button>
        <button class="btn btn-success" onclick="bayar()" @if(count($data) == 0) disabled @endif><i class="bi bi-wallet"></i> Bayar</button>
    </div>
</div>
<script>
    function kembali() {
        $(".v_kedua").attr('hidden', true);
        $(".v_utama").removeAttr('hidden', true);
    }

    function bayar() {
        kodekunjungan = $('#kodekunjungan').val()
        Swal.fire({
            title: "Tagihan sudah dibayar ?",
            text: "Klik OK untuk melanjutkan ...",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                bayartagihan(kodekunjungan)
            }
        });
    }

    function bayartagihan(kodekunjungan) {
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                kodekunjungan
            },
            url: '<?= route('bayartagihan') ?>',
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
                    location.reload()
                }
            }
        });
    }
</script>
