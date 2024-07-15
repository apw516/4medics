    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="">4medics by.epitech</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
    <script>
        function logout() {
            Swal.fire({
                title: 'Logout',
                text: "Apakah anda ingin logout ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "<?= route('logout') ?>";
                }
            })
        }
    </script>
