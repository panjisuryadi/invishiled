<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-box me-2"></i> Data User</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
        <i class="fas fa-plus me-1"></i> Tambah User
    </button>
</div>

<!-- Flash Message / Notifikasi Sukses -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Summary Card -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <h6 class="text-uppercase fw-bold">Total User</h6>
                <h3 class="fw-bold mb-0"><?= number_format($total_user) ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data User -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Created At</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['name']) ?></td>
                            <td><?= esc($row['created_at']) ?></td>
                            <td class="text-center">
                                <!-- Tombol Edit (Trigger Modal) -->
                                <button type="button" class="btn btn-sm btn-warning text-white btn-edit" 
                                    data-id="<?= $row['id'] ?>"
                                    data-name="<?= esc($row['name']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <!-- Tombol Delete dengan Konfirmasi JS Sederhana -->
                                <a href="<?= base_url('users/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk <?= esc($row['name']) ?>?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada data user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('users/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahUserLabel"><i class="fas fa-plus-circle me-1"></i> Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama User</label>
                        <input type="text" class="form-control" name="name" required placeholder="Masukkan nama User">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUserLabel"><i class="fas fa-edit me-1"></i> Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama User</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = this.getAttribute('data-price');
                const qty = this.getAttribute('data-qty');
                

                // Masukkan data ke dalam form dengan pengecekan aman
                const elId = document.getElementById('edit-id');
                const elName = document.getElementById('edit-name');
                const elForm = document.getElementById('formEdit');

                if (elId) elId.value = id;
                if (elName) elName.value = name;
                if (elForm) elForm.action = "<?= base_url('users/update/') ?>" + id;

                // Tampilkan modal
                var myModal = new bootstrap.Modal(document.getElementById('modalEditUser'));
                myModal.show();
            });
        });
    });
</script>
<?= $this->endSection() ?>