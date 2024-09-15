<div class="card">
    <div class="card-header">Orderan Dikirim</div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <th>Nama Obat</th>
                <th>Aturan Pakai</th>
                <th>Sediaan</th>
                <th>Dosis</th>
                <th>QTY</th>
            </thead>
            <tbody>
                @foreach ($data as $d )
                    <tr>
                        <td>{{ $d->nama_barang }}</td>
                        <td>{{ $d->aturan_pakai }}</td>
                        <td>{{ $d->sediaan }}</td>
                        <td>{{ $d->dosis }}</td>
                        <td>{{ $d->qty }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Orderan Diterima / dilayanai </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <th>Nama Obat</th>
                <th>Aturan Pakai</th>
                <th>Sediaan</th>
                <th>Dosis</th>
                <th>QTY</th>
            </thead>
            <tbody>
                @foreach ($data2 as $d )
                    <tr>
                        <td>{{ $d->keterangan01 }}</td>
                        <td>{{ $d->aturan_pakai }}</td>
                        <td>{{ $d->satuan_barang }}</td>
                        <td>{{ $d->dosis }}</td>
                        <td>{{ $d->jumlah_layanan }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm returobat" iddetail="{{ $d->iddetail }}" idheader="{{ $d->idheader }}"><i
                                class="bi bi-trash3"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            @if(count($data2) > 0)
            <button class="btn btn-info cetakresep" idheader="{{ $d->idheader }}"><i class="bi bi-printer mr-1 ml-1"></i> Cetak Resep</button>
            @endif
        </div>
    </div>
</div>
<script>
      $(".returobat").on('click', function(event) {
        Swal.fire({
            title: "Layanan obat akan dibatalkan ?",
            text: "Klik OK untuk melanjutkan ...",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                iddetail = $(this).attr('iddetail')
                idheader = $(this).attr('idheader')
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        iddetail,idheader
                    },
                    url: '<?= route('batallayananresep') ?>',
                    error: function(data) {
                        spinner.hide();
                    },
                    success: function(data) {
                        spinner.hide();
                        if(data.kode == 200){
                            Swal.fire(data.message, "", "success");
                            $('#modalinfo').modal('toggle');
                            location.reload()
                        }else{
                            Swal.fire(data.message, "", "error");
                        }
                    }
                });
            }
        });
    });
      $(".cetakresep").on('click', function(event) {
        Swal.fire({
            title: "Resep akan dicetak ?",
            text: "Klik OK untuk melanjutkan ...",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                idheader = $(this).attr('idheader')
                window.open('cetakresep/'+idheader);
            }
        });
    });
</script>
