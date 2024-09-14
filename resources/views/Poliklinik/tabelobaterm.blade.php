   <table id="tabelstok" class="table table-sm table-bordered text-xs table-hover">
       <thead>
           <th>Nama Obat</th>
           <th>Dosis</th>
           <th>Aturan Pakai</th>
           <th>Sediaan</th>
           <th>===</th>
       </thead>
       <tbody>
           @foreach ($master_barang as $d)
               <tr class="pilihobat" kodebarang="{{ $d->kode_barang }}" nama="{{ $d->nama_barang }}"
                   sediaan="{{ $d->sediaan }}" dosis="{{ $d->dosis }}" aturanpakai = "{{ $d->aturan_pakai }}">
                   <td>{{ $d->nama_barang }}</td>
                   <td>{{ $d->dosis }}</td>
                   <td>{{ $d->aturan_pakai }}</td>
                   <td>{{ $d->sediaan }}</td>
                   <td></td>
               </tr>
           @endforeach
       </tbody>
   </table>
   <script>
       $(function() {
           $("#tabelstok").DataTable({
               "responsive": true,
               "lengthChange": false,
               "autoWidth": true,
               "pageLength": 5,
               "searching": true
           })
       });
       $(".pilihobat").on('click', function(event) {
           idtarif = $(this).attr('kodebarang')
           nama = $(this).attr('nama')
           dosis = $(this).attr('dosis')
           aturan = $(this).attr('aturanpakai')
           sediaan = $(this).attr('sediaan')
           var wrapper = $(".input_layanan");
           $(wrapper).append(
               '<div class="form-row text-xs"><div class="form-group col-md-3"><label for="">Nama Obat</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="" name="namaobat" value="' +
            nama +
            '"><input hidden readonly type="" class="form-control form-control-sm" id="" name="idobat" value="' +
            idtarif +
            '"></div><div class="form-group col-md-1"><label for="inputPassword4">Sediaan</label><input readonly type="" class="form-control form-control-sm" id="" name="sediaan" value="' +
            sediaan +
            '"></div><div class="form-group col-md-1"><label for="inputPassword4">Dosis</label><input readonly type="" class="form-control form-control-sm" id="" name="dosis" value="' +
            dosis +
            '"></div><div class="form-group col-md-3"><label for="inputPassword4">Aturan Pakai</label><textarea type="" class="form-control form-control-sm" id="" name="aturanpakai" rows="4">'+aturan+'</textarea></div><div class="form-group col-md-1"><label for="inputPassword4">Qty</label><input type="" class="form-control form-control-sm" id="" name="qty" value="0"></div><i class="bi bi-x-square remove_field form-group col-md-1 text-danger" kode2=""></i></div>'
           );
           $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
               e.preventDefault();
               $(this).parent('div').remove();
               x--;
           })
       });
