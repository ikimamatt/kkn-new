<!-- Footer Start -->
<footer class="footer">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(houseId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan bisa membatalkan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batalkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, kirimkan form
                    document.getElementById('delete-form-' + houseId).submit();
                }
            });
        }

        // Alert untuk sukses
        function showSuccessMessage(message) {
            Swal.fire({
                title: 'Sukses!',
                text: message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }

        // Alert untuk error
        function showErrorMessage(message) {
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                text: message,
                icon: 'error',
                confirmButtonText: 'Tutup'
            });
        }

        // Contoh penggunaan
        // showSuccessMessage('Data berhasil dihapus!');
        // showErrorMessage('Terjadi kesalahan saat menghapus data.');
    </script>
    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            title: 'Terjadi Kesalahan!',
            text: '{{ implode(', ', $errors->all()) }}',
            icon: 'error',
            confirmButtonText: 'Tutup'
        });
    </script>
@endif
</footer>
<!-- end Footer -->
