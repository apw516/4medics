@foreach ($assesmen as $as)
    <div class="tab-pane" id="timeline">
        <!-- The timeline -->
        <div class="timeline timeline-inverse">
            <!-- timeline time label -->
            <div class="time-label">
                <span class="bg-danger">
                    {{ $as->tgl_masuk }}
                </span>
            </div>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <div>
                <i class="fas fa-envelope bg-primary"></i>

                <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> {{ $as->tgl_periksa }}</span>

                    <h3 class="timeline-header"><a href="" class="mr-2">Dokter : {{ $as->nama_dokter }}</a>
                        {{ $as->nama_unit }}</h3>

                    <div class="timeline-body">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td colspan="2" class="text-center text-bold">Tanda Tanda Vital</td>
                            </tr>
                            <tr>
                                <td width="60%">
                                    <div class="form-group row mt-4">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Tekanan
                                            Darah</label>
                                        <div class="col-sm-5">
                                            {{ $as->tekanan_darah }} mm Hg
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group row mt-4">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Suhu Tubuh</label>
                                        <div class="col-sm-5">
                                            {{ $as->suhu_tubuh }} °C
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="2">
                                    Subject ( S ) : {{ trim($as->subject) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="2">
                                    Object ( O ) : {{ trim($as->object) }}

                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="2">
                                    Assesment ( A ) : {{ trim($as->assesment) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-italic" colspan="1">
                                    PLanning ( P ) : {{ trim($as->planning) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="timeline-footer">
                        <a href="#" class="btn btn-info btn-sm"><i class="bi bi-printer-fill mr-1"></i> Print</a>
                    </div>
                </div>
            </div>
            <!-- END timeline item -->
            <!-- timeline item -->
            <div>
                <i class="far fa-clock bg-gray"></i>
            </div>
        </div>
    </div>
@endforeach
