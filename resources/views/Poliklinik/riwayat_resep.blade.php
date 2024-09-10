@foreach ($data_resep as $d)
    <div class="card">
        <div class="card-header">Resep {{ $d->nama_dokter }} | tanggal {{ $d->tgl_entry }}
            <button class="btn btn-success float-right pilihresep" idheader="{{ $d->id }}"><i
                    class="bi bi-check2-circle"></i></button>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered table-sm text-xs table-hover">
                <thead>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Aturan Pakai</th>
                    <th>Sediaan</th>
                    <th>QTY</th>
                </thead>
                <tbody>
                    @foreach ($data_resep2 as $dr)
                        @if ($dr->id_header == $d->id)
                            <tr>
                                <td>{{ $dr->nama_barang }}</td>
                                <td>{{ $dr->dosis }}</td>
                                <td>{{ $dr->aturan_pakai }}</td>
                                <td>{{ $dr->sediaan }}</td>
                                <td>{{ $dr->qty }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach
<script>
    $(".pilihresep").on('click', function(event) {
        Swal.fire({
            title: "Resep dipilih untuk digunakan ?",
            text: "Klik OK untuk melanjutkan ...",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                idheader = $(this).attr('idheader')
                cari_detail_resepnya(idheader)
            }
        });
    });
    function cari_detail_resepnya(id) {
        spinner = $('#loader')
        spinner.show();
        $('#modalriwayatresep').modal('hide')
        var max_fields = 10;
        // var wrapper = $(".input_komponen_obat_racik");
        var wrapper = $(".input_layanan");
        var x = 1;
        if (x < max_fields) {
            x++; //text box increment
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    id
                },
                url: '<?= route('ambil_detail_resep') ?>',
                success: function(response) {
                    // wrapper.after(html);
                    // $('#daftarpxumum').attr('disabled', true);
                    $(wrapper).append(response);
                    $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
                        e.preventDefault();
                        $(this).parent('div').remove();
                        x--;
                    })
                    spinner.hide();
                }
            });
        }
    }
</script>
