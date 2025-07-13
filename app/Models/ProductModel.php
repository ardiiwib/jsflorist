<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'product_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'category_id',
        'nama_produk',
        'deskripsi_produk',
        'harga',
        'gambar_url',
        'berat_gram',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'tanggal_dibuat';
    protected $updatedField  = 'tanggal_diupdate';
    protected $dateFormat    = 'datetime';

    protected $validationRules = [
        'category_id'      => 'required|integer',
        'nama_produk'      => 'required|min_length[5]|max_length[255]',
        'deskripsi_produk' => 'permit_empty',
        'harga'            => 'required|decimal|greater_than_equal_to[0]',
        'gambar_url'       => 'permit_empty|valid_url', // Validasi URL opsional
        'berat_gram'       => 'permit_empty|integer|greater_than_equal_to[0]',
        'is_active'        => 'permit_empty|is_boolean',
    ];

    protected $validationMessages = []; // Tambahkan pesan kustom jika diperlukan

    protected $skipValidation = false;

    // Contoh relasi (Anda bisa tambahkan method untuk mengambil kategori)
    public function getProductWithCategory(int $productId)
    {
        return $this->select('products.*, categories.nama_kategori')
                    ->join('categories', 'categories.category_id = products.category_id')
                    ->where('products.product_id', $productId)
                    ->first();
    }
}