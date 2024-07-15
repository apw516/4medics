@foreach ($data as $as )
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
@endforeach
