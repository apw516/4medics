<button class="btn btn-danger" onclick="kembali2()">
    <i class="bi bi-backspace-fill mr-2"></i> Kembali</button>
<div class="card mt-2">
    <div class="card-header">Rincian Biaya Obat</div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <th>Nama Obat</th>
                <th>Sediaan</th>
                <th>Dosis</th>
                <th>Aturan Pakai</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </thead>
            <tbody>
                @php
                    $gt = 0;
                @endphp
                @foreach ($arraynd as $d)
                    <tr>
                        <td>{{ $d['namaobat'] }}</td>
                        <td>{{ $d['sediaan'] }}</td>
                        <td>{{ $d['dosis'] }}</td>
                        <td>{{ $d['aturan_pakai'] }}</td>
                        <td>{{ $d['qty'] }}</td>
                        <td>Rp. {{ number_format($d['hargajual'], 2) }} </td>
                        <td>Rp. {{ number_format($d['total'], 2) }}</td>
                    </tr>
                    @php
                        $gt = $d['total'] + $gt;
                    @endphp
                @endforeach
                <tr class="text-bold font-lg">
                    <td colspan="6" class="text-center">Grand Total</td>
                    <td>Rp. {{ number_format($gt, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <button class="btn btn-success float-right" onclick="simpanorder()"><i
                class="far fa bi bi-download mr-1 ml-1"></i> Simpan</button>
        <button class="btn btn-danger float-right mr-1" onclick="kembali2()">
            <i class="bi bi-backspace-fill mr-2"></i> Kembali</button>
    </div>
</div>
<script>
    function kembali2() {
        $(".v_detail_1").removeAttr('hidden', true);
        $(".v_detail_2").attr('hidden', true);
    }

    function simpanorder() {
        Swal.fire({
            title: "Orderan akan disimpan ?",
            text: "Klik cancel untuk batal simpan !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya,Simpan "
        }).then((result) => {
            if (result.isConfirmed) {

                spinner = $('#loader')
                spinner.show();
                header = $('#idheader').val()
                var data = $('.form_layanan').serializeArray();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: JSON.stringify(data),
                        header
                    },
                    url: '<?= route('simpanorderan') ?>',
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
