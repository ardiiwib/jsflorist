<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>
Manajemen Produk
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manajemen Produk</h1>
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Produk</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
       <form action="" method="get" class="mb-4">
    <label for="category">Filter berdasarkan Kategori:</label>
    <select name="category" id="category" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= esc($category['category_id']) ?>"
                <?= ($category['category_id'] == $selectedCategory) ? 'selected' : '' ?>>
                <?= esc($category['nama_kategori']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>
    </div>
</div>


<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>" alt="<?= esc($product['nama_produk']) ?>" class="product-thumbnail">
                                </td>
                                <td><?= esc($product['nama_produk']) ?></td>
                          <td><?= esc($product['nama_kategori'] ?? 'Tanpa Kategori') ?></td>
                                <td>Rp<?= number_format($product['harga'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($product['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/products/edit/' . $product['product_id']) ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('admin/products/delete/' . $product['product_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Produk tidak ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 d-flex justify-content-center">
           <?= $pager->links('products', 'default_full') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>