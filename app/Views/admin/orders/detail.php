<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>
Detail Pesanan #<?= esc($order['order_id']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1 class="mb-4">Detail Pesanan #<?= esc($order['order_id']) ?></h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <h4 class="mb-3">Informasi Pesanan</h4>
                <p class="detail-row"><strong>Status Pesanan:</strong> <span class="badge bg-info text-dark status-badge"><?= esc($order['status_pesanan']) ?></span></p>
                <p class="detail-row"><strong>Tanggal Pesan:</strong> <?= esc(date('d F Y, H:i', strtotime($order['tanggal_pesan']))) ?> WITA</p>
                <p class="detail-row"><strong>Tanggal Pengantaran:</strong> <?= esc(date('d F Y, H:i', strtotime($order['tanggal_pengantaran']))) ?> WITA</p>
                <p class="detail-row"><strong>Tipe Pengantaran:</strong> <?= esc($order['tipe_pengantaran']) ?></p>
                <p class="detail-row"><strong>Total Harga:</strong> Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></p>
                <p class="detail-row"><strong>Metode Pembayaran:</strong> <?= esc($order['metode_pembayaran']) ?></p>
                <?php if (!empty($order['bukti_bayar'])): ?>
                    <p class="detail-row"><strong>Bukti Pembayaran:</strong> <a href="<?= base_url(esc($order['bukti_bayar'])) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Bukti</a></p>
                <?php else: ?>
                    <p class="detail-row"><strong>Bukti Pembayaran:</strong> Belum diunggah</p>
                <?php endif; ?>
                <?php if (!empty($order['catatan_penerima'])): ?>
                    <p class="detail-row"><strong>Catatan/Ucapan:</strong> <?= nl2br(esc($order['catatan_penerima'])) ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <h4 class="mb-3">Informasi Pelanggan & Penerima</h4>
                <p class="detail-row"><strong>Nama Pemesan:</strong> <?= esc($order['penerima_nama']) ?></p>
                <p class="detail-row"><strong>Nomor HP Pemesan:</strong> <?= esc($order['nomor_pemesan']) ?></p>
                <?php if (!empty($order['penerima_nomor_hp'])): ?>
                    <p class="detail-row"><strong>Nomor HP Penerima:</strong> <?= esc($order['penerima_nomor_hp']) ?></p>
                <?php endif; ?>
                <?php if ($order['tipe_pengantaran'] === 'Delivery'): ?>
                    <p class="detail-row"><strong>Alamat Pengiriman:</strong> <?= esc($order['alamat_pengiriman_teks']) ?></p>
                    <?php if (!empty($order['alamat_latitude']) && !empty($order['alamat_longitude'])): ?>
                        <p class="detail-row"><strong>Koordinat (Lat, Lng):</strong> <?= esc($order['alamat_latitude']) ?>, <?= esc($order['alamat_longitude']) ?></p>
                        <a href="https://www.google.com/maps/search/?api=1&query=<?= esc($order['alamat_latitude']) ?>,<?= esc($order['alamat_longitude']) ?>" target="_blank" class="btn btn-sm btn-outline-info mt-2">Lihat di Peta</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <h4 class="mb-3">Item Pesanan</h4>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Nama Produk</th>
                            <th>Kuantitas</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $itemSubtotal = 0; ?>
                        <?php if (!empty($orderItems)): ?>
                            <?php foreach ($orderItems as $item): ?>
                                <?php $currentSubtotal = $item['harga_satuan'] * $item['kuantitas']; ?>
                                <?php $itemSubtotal += $currentSubtotal; ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($item['gambar_url'])): ?>
                                          <img src="<?= base_url('assets/img/gambar/' . esc($item['gambar_url'])) ?>" alt="<?= esc($item['nama_produk']) ?>" class="product-thumbnail">
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/img/default-product.jpg') ?>" alt="No Image">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= esc($item['nama_produk']) ?>
                                        <?php if (!empty($item['custom_details_decoded'])): ?>
                                            <div class="text-muted small mt-1">
                                                <?php foreach ($item['custom_details_decoded'] as $key => $value): ?>
                                                    <?php if (!is_array($value)): ?>
                                                        <div><strong><?= esc(ucwords(str_replace('_', ' ', $key))) ?>:</strong> <?= esc($value) ?></div>
                                                    <?php elseif (!empty($value)): // Handle array like 'bunga' ?>
                                                        <div><strong><?= esc(ucwords(str_replace('_', ' ', $key))) ?>:</strong> <?= esc(implode(', ', $value)) ?></div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['kuantitas']) ?></td>
                                    <td>Rp<?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($currentSubtotal, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada item pesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total Item Pesanan:</strong></td>
                            <td><strong>Rp<?= number_format($itemSubtotal, 0, ',', '.') ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <h4 class="mb-3">Ubah Status Pesanan</h4>
            <form action="<?= base_url('admin/orders/updateStatus/' . $order['order_id']) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="status_pesanan" class="form-label">Status Baru:</label>
                    <select class="form-select" id="status_pesanan" name="status_pesanan" required>
                        <?php foreach ($availableStatuses as $status): ?>
                            <option value="<?= esc($status) ?>" <?= ($order['status_pesanan'] === $status) ? 'selected' : '' ?>>
                                <?= esc($status) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui Status</button>
            </form>

            <div class="mt-4 text-center">
                <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>