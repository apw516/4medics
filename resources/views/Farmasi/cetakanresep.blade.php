<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resep Obat</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/adminlte/dist/css/adminlte.min.css') }}">
</head>

<body>
    <div class="wrapper">
        <div class="card mt-2">
            <div class="card-header">Nota Resep</div>
            <div class="card-body">
                <table class="table talbe-sm table-bordered">
                    <thead>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Aturan Pakai</th>
                    </thead>
                    <tbody>
                        @foreach ($dataresep as $d)
                            <tr>
                                <td>{{ $d->keterangan01 }}</td>
                                <td>{{ $d->jumlah_layanan }}</td>
                                <td>{{ $d->aturan_pakai }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
