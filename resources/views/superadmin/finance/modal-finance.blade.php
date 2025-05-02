<div class="modal fade" id="modalKeuangan" tabindex="-1" aria-labelledby="modalKeuanganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKeuanganLabel">Tambahkan Data Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('superadmin.finance.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal" class="form-label"> <span class="text-danger">*</span>
                                Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="date" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jenis" class="form-label"><span class="text-danger">*</span>
                                Jenis</label>
                            <select class="form-select" id="jenis" name="type" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label"> <span class="text-danger">*</span>
                                Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="category"
                                placeholder="Perlengkapan RT" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="item_name"
                                placeholder="Kipas Angin">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="quantity" min="0"
                                value="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan (Rp)</label>
                            <input type="text" class="form-control" id="harga_satuan" placeholder="Rp 0"
                                oninput="formatRupiah(this)">
                            <input type="hidden" name="unit_price" id="harga_satuan_real">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="description" placeholder="Keperluan acara 17 agustusan"
                            rows="3"></textarea>
                    </div>
                    <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const modal = document.getElementById('modalKeuangan')
    modal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget
        const isEdit = button.hasAttribute('data-id')
        const form = modal.querySelector('form')

        // Judul
        const title = modal.querySelector('.modal-title')
        title.textContent = isEdit ? 'Edit Data Keuangan' : 'Tambahkan Data Keuangan'

        // Method spoofing
        let methodInput = form.querySelector('input[name="_method"]')
        if (!methodInput) {
            methodInput = document.createElement('input')
            methodInput.setAttribute('name', '_method')
            methodInput.setAttribute('type', 'hidden')
            form.appendChild(methodInput)
        }

        if (isEdit) {
            form.action = `/superadmin/keuangan/${button.dataset.id}`;
            methodInput.value = 'PUT'

            const unit_price = button.dataset.unit_price || ''
            const formattedUnitPrice = 'Rp ' + Number(unit_price).toLocaleString('id-ID');

            // Isi form dari data attribute
            form.date.value = button.dataset.date || ''
            form.type.value = button.dataset.type || ''
            form.category.value = button.dataset.category || ''
            form.item_name.value = button.dataset.item_name || ''
            form.quantity.value = button.dataset.quantity || 0
            document.getElementById('harga_satuan').value = formattedUnitPrice
            document.getElementById('harga_satuan_real').value = button.dataset.unit_price || ''
            form.description.value = button.dataset.description || ''
        } else {
            // Reset form
            form.reset()
            form.action = `{{ route('superadmin.finance.store') }}`
            methodInput.value = 'POST'
        }
    })
</script>
