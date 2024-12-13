<div @if (count($data) < 1) hidden @endif class="row">
    <div class="col-md-6">

        @foreach ($data as $d)
        <div class="alert alert-info mt-1" role="alert">
            Order Farmasi pasien {{ $d->nama_pasien }} <button class="float-right btn btn-warning pilihheader"
            idheader="{{ $d->id }}">Terima</button>
        </div>
        @endforeach
    </div>
    {{-- <div class="col-md-3 mt-3">
        <div class="card">
            <div class="card-header">Order Masuk</div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <th>Nama Pasien</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $d->nama_pasien}} <button class="btn btn-success pilihheader" idheader="{{ $d->id}}">Terima</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</div>
<script>
    $(".pilihheader").on('click', function(event) {
        $(".v_kedua").removeAttr('hidden', true);
        $(".v_utama").attr('hidden', true);
        idheader = $(this).attr('idheader')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idheader
            },
            url: '<?= route('ambil_detail_orderan') ?>',
            success: function(response) {
                $('.v_kedua').html(response);
                spinner.hide();
            }
        });
    });
</script>
