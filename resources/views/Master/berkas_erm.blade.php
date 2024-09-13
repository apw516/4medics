<button class="btn btn-danger mb-3" onclick="kembali()"><i class="bi bi-backspace-fill mr-2"></i> Batal</button>

<!-- Main content -->
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <table class="table table-sm table-bordered">
            <tr>
                <td width="15%" class="text-bold">Nomor RM</td>
                <td class="font-italic">{{ $pasien[0]->no_rm }}</td>
                <td width="15%" class="text-bold">Nomor Identitas</td>
                <td class="font-italic">{{ $pasien[0]->nik_bpjs }}</td>
            </tr>
            <tr>
                <td width="15%" class="text-bold">Nama Pasien</td>
                <td  class="font-italic"colspan="3">{{ $pasien[0]->nama_px }}</td>
            </tr>
            <tr>
                <td width="15%" class="text-bold">Jenis Kelamin</td>
                <td class="font-italic" colspan="3">@if($pasien[0]->jenis_kelamin == 'L') Laki - laki @else Perempuan @endif</td>
            </tr>
            <tr>
                <td width="15%" class="text-bold">Tempat, Tanggal lahir</td>
                <td class="font-italic" colspan="3">{{ $pasien[0]->tempat_lahir }},{{ $pasien[0]->tgl_lahir }}</td>
            </tr>
            <tr>
                <td width="15%" class="text-bold">Alamat</td>
                <td  class="font-italic"colspan="3">{{ $pasien[0]->alamat }}</td>
            </tr>
        </table>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            @foreach ($erm as $e)
            <div class="card">
                <div class="card-header bg-light text-bold">Dokter : {{ $e->nama_dokter }} | Unit : {{ $e->nama_unit }} | Tanggal Kunjungan : {{ $e->tgl_masuk }} <h4 class="float-right text-bold">Kunjungan ke : {{ $e->counter}}</h5></div>
                <div class="card-body">
                    <div class="timeline-body">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td colspan="2" class="text-center text-bold bg-light">Tanda Tanda Vital</td>
                            </tr>
                            <tr>
                                <td width="60%">
                                    <div class="form-group row mt-4">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Tekanan
                                            Darah</label>
                                        <div class="col-sm-5">
                                            {{ $e->tekanan_darah }} mm Hg
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group row mt-4">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Suhu Tubuh</label>
                                        <div class="col-sm-5">
                                            {{ $e->suhu_tubuh }} °C
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="2">
                                    Subject ( S ) : {{ trim($e->subject) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="2">
                                    Object ( O ) : {{ trim($e->object) }}

                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="2">
                                    Assesment ( A ) : {{ trim($e->assesment) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="1">
                                    PLanning ( P ) : {{ trim($e->planning) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Serial #</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Call of Duty</td>
                        <td>455-981-221</td>
                        <td>El snort testosterone trophy driving gloves handsome</td>
                        <td>$64.50</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Need for Speed IV</td>
                        <td>247-925-726</td>
                        <td>Wes Anderson umami biodiesel</td>
                        <td>$50.00</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Monsters DVD</td>
                        <td>735-845-642</td>
                        <td>Terry Richardson helvetica tousled street art master</td>
                        <td>$10.70</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Grown Ups Blue Ray</td>
                        <td>422-568-642</td>
                        <td>Tousled lomo letterpress</td>
                        <td>$25.99</td>
                    </tr>
                </tbody>
            </table> --}}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                    class="fas fa-print"></i> Print</a>
        </div>
    </div>
</div>
<script>
    function kembali() {
        $(".v_kedua").attr('hidden', true);
        $(".v_utama").removeAttr('hidden', true);
    }
</script>
