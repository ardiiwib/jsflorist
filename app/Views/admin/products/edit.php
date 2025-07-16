<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>
Edit Produk: <?= esc($product['nama_produk']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1>Edit Produk</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <strong>Terjadi Kesalahan:</strong>
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/products/update/' . $product['product_id']) ?>" method="post" enctype="multipart/form-data">


            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= old('nama_produk', $product['nama_produk']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi_produk" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3"><?= old('deskripsi_produk', $product['deskripsi_produk']) ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>" <?= (old('category_id', $product['category_id']) == $category['category_id']) ? 'selected' : '' ?>>
                                <?= esc($category['nama_kategori']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?= old('harga', $product['harga']) ?>" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="gambar_url" class="form-label">Ganti Gambar Produk (Opsional)</label>
                <div class="d-flex align-items-center">
                    <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>" alt="<?= esc($product['nama_produk']) ?>" class="product-thumbnail me-3">
                    <input class="form-control" type="file" id="gambar_url" name="gambar_url">
                </div>
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $product['is_active']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_active">Aktifkan Produk</label>
            </div>
            <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
