<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-shopping-cart me-2"></i> Data Transaksi</h1>
    <!-- Tombol Trigger Modal Tambah Transaksi -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahTransaksi">
        <i class="fas fa-plus me-1"></i> Tambah Transaksi
    </button>
</div>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Summary Card -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <h6 class="text-uppercase fw-bold">Total Transaksi</h6>
                <h3 class="fw-bold mb-0"><?= number_format($total_transaksi) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-dark">
            <div class="card-body">
                <h6 class="text-uppercase fw-bold">Total Qty</h6>
                <h3 class="fw-bold mb-0"><?= number_format($total_qty) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body">
                <h6 class="text-uppercase fw-bold">Total Pendapatan</h6>
                <h3 class="fw-bold mb-0">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Transaksi -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer / User</th>
                        <th>Nama Product</th>
                        <th>Price</th>
                        <th>Jumlah (Qty)</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php $no = 1; foreach ($transactions as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['user_name'] ?? 'User ID: ' . $row['user_id']) ?></td>
                            <td><?= esc($row['product_name']) ?></td>
                            <td><?= number_format($row['total']/$row['qty']) ?></td>
                            <td><?= number_format($row['qty']) ?></td>
                            <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td><?= esc($row['created_at']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada data transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="modalTambahTransaksi" tabindex="-1" aria-labelledby="modalTambahTransaksiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('transactions/store') ?>" method="POST" id="formTransaksi">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahTransaksiLabel"><i class="fas fa-shopping-cart me-1"></i> Buat Transaksi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih Customer / User</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="" disabled selected>-- Pilih Customer --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= esc($u['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Pilih Product</label>
                        <select class="form-select" id="product_id" name="product_id" required>
                            <option value="" disabled selected data-price="0" data-stock="0">-- Pilih Product --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>" data-stock="<?= $p['qty_in_stock'] ?>">
                                    <?= esc($p['name']) ?> (Stok Tersedia: <?= $p['qty_in_stock'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga_satuan" class="form-label">Harga Satuan</label>
                        <input type="text" class="form-control bg-light" id="harga_satuan" readonly value="Rp 0">
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah (Qty)</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="1" required disabled>
                        <small class="text-danger fw-bold" id="info-stok"></small>
                    </div>

                    <div class="p-3 bg-light rounded border mb-3">
                        <span class="text-muted d-block small fw-bold">TOTAL HARGA:</span>
                        <h4 class="text-success fw-bold mb-0" id="display-total">Rp 0</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk Pengaturan Field, Batasan Qty, & Kalkulasi -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productSelect = document.getElementById('product_id');
        const jumlahInput = document.getElementById('jumlah');
        const hargaSatuanInput = document.getElementById('harga_satuan');
        const displayTotal = document.getElementById('display-total');
        const infoStok = document.getElementById('info-stok');
        const formTransaksi = document.getElementById('formTransaksi');

        function updateFormState() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

            if (productSelect.value === "") {
                jumlahInput.disabled = true;
                jumlahInput.value = 1;
                hargaSatuanInput.value = "Rp 0";
                infoStok.textContent = "";
                displayTotal.textContent = "Rp 0";
                return;
            }

            jumlahInput.disabled = false;
            jumlahInput.max = stock;

            hargaSatuanInput.value = 'Rp ' + price.toLocaleString('id-ID');

            let qty = parseInt(jumlahInput.value) || 0;

            if (qty > stock) {
                qty = stock;
                jumlahInput.value = stock;
            }

            if (stock <= 0) {
                infoStok.textContent = "Stok produk habis!";
                jumlahInput.disabled = true;
            } else {
                infoStok.textContent = `Maksimal qty yang dapat diinput: ${stock}`;
            }

            const total = price * qty;
            displayTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        productSelect.addEventListener('change', updateFormState);

        jumlahInput.addEventListener('input', function () {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            let qty = parseInt(this.value) || 0;

            if (qty > stock) {
                alert('Jumlah tidak boleh melebihi sisa stok (' + stock + ')!');
                this.value = stock;
                qty = stock;
            }

            if (qty < 1 && this.value !== "") {
                this.value = 1;
                qty = 1;
            }

            const total = price * qty;
            displayTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        });

        formTransaksi.addEventListener('submit', function (e) {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const qty = parseInt(jumlahInput.value) || 0;

            if (qty > stock || qty < 1) {
                alert('Jumlah pesanan tidak valid atau melebihi stok!');
                e.preventDefault();
                return;
            }

            const konfirmasi = confirm('Apakah Anda yakin ingin memproses transaksi ini? Stok produk akan otomatis berkurang.');
            if (!konfirmasi) {
                e.preventDefault();
            }
        });
    });
</script>
<?= $this->endSection() ?>