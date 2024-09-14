<div class="v_detail_1">
    <button class="btn btn-danger" onclick="kembali()">
        <i class="bi bi-backspace-fill mr-2"></i> Kembali</button>
    <div class="card mt-2">
        <div class="card-header mt-2">Data Order</div>
        <div class="card-body">
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            {{-- <i class="fas fa-globe"></i> AdminLTE, Inc.
                          <small class="float-right">Date: 2/10/2014</small> --}}
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong>{{ $data2[0]->nama_pasien }}.</strong><br>
                            {{ $data2[0]->no_rm }}<br>
                            {{-- San Francisco, CA 94107<br>
                          Phone: (804) 123-5432<br>
                          Email: info@almasaeedstudio.com --}}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        Dokter
                        <address>
                            <strong>{{ $data2[0]->nama_dokter }}</strong><br>
                            {{ $data2[0]->nama_unit_kirim }}<br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Tanggal Order {{ $data2[0]->tgl_entry }}</b><br>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <input  hidden type="text" name="idheader" id="idheader" value="{{ $idheader }}">
                        <form action="" method="post" class="form_layanan">
                            <div class="input_layanan">
                                <div>
                                    @foreach ($data as $d)
                                        <div class="form-row text-xs">
                                            <div class="form-group col-md-4"><label for="">Nama Obat</label><input
                                                    readonly type=""
                                                    class="form-control form-control-sm text-xs edit_field" id=""
                                                    name="namaobat" value="{{ $d->nama_barang }}">
                                                <input hidden readonly type="" class="form-control form-control-sm"
                                                    id="" name="idobat" value="{{ $d->kode_barang }}">
                                                <input hidden readonly type="" class="form-control form-control-sm"
                                                    id="" name="iddetail" value="{{ $d->id_detail }}">
                                            </div>
                                            <div class="form-group col-md-1"><label
                                                    for="inputPassword4">Sediaan</label><input readonly type=""
                                                    class="form-control form-control-sm" id="" name="sediaan"
                                                    value="{{ $d->sediaan }}">
                                            </div>
                                            <div class="form-group col-md-1"><label for="inputPassword4">Dosis</label><input
                                                    readonly type="" class="form-control form-control-sm"
                                                    id="" name="dosis" value="{{ $d->dosis }}">
                                            </div>
                                            <div class="form-group col-md-3"><label for="inputPassword4">Aturan
                                                    Pakai</label>
                                                <textarea type="" class="form-control form-control-sm" id="" name="aturanpakai" rows="4">{{ $d->aturan_pakai }}</textarea>
                                            </div>
                                            <div class="form-group col-md-1"><label for="inputPassword4">Qty</label><input
                                                    type="" class="form-control form-control-sm" id=""
                                                    name="qty" value="{{ $d->qty }}"></div><i
                                                class="bi bi-x-square remove_field form-group col-md-1 text-danger"
                                                kode2=""></i>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.col -->
                </div>

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                        <button type="button" class="btn btn-success float-right" onclick="terimaorder()"><i
                                class="far fa-credit-card"></i> Terima
                            Order</button>
                        <button type="button" class="btn btn-info float-right mr-1 ml-1" data-toggle="modal"
                            data-target="#modaltambahobat"><i class="far fa bi bi-bookmark-check"></i> Tambah Obat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div hidden class="v_detail_2">

</div>
<!-- Modal -->
<div class="modal fade" id="modaltambahobat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputPassword2" class="sr-only">Password</label>
                            <input type="text" class="form-control" id="namaobat" placeholder="cari obat ...">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2" onclick="cariobat_farmasi()"><i
                                class="bi bi-search mr-1 ml-1"></i> Cari
                            Obat</button>
                    </div>
                    <div class="v_tabel_stok_obat">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function kembali() {
        $(".v_kedua").attr('hidden', true);
        $(".v_utama").removeAttr('hidden', true);
    }
    $(document).ready(function() {
        hapus()
    })

    function hapus() {
        var wrapper = $(".input_layanan");
        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    }

    function cariobat_farmasi() {
        namaobat = $('#namaobat').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                namaobat
            },
            url: '<?= route('cari_obat_farmasi') ?>',
            error: function(response) {
                spinner.hide()
                alert('error')
            },
            success: function(response) {
                spinner.hide()
                $('.v_tabel_stok_obat').html(response);
            }
        });
    }

    function terimaorder() {
        $(".v_detail_1").attr('hidden', true);
        $(".v_detail_2").removeAttr('hidden', true);
        spinner = $('#loader')
        spinner.show();
        var data = $('.form_layanan').serializeArray();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('hitungorderanfarmasi') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(response) {
                spinner.hide()
                $('.v_detail_2').html(response);

            }
        });

    }
</script>
