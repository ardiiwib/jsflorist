<?php

namespace App\Controllers;
use App\Models\CategoryModel; // Import CategoryModel
use App\Models\ProductModel;
use App\Models\ArtikelModel;
class Home extends BaseController
{
     public function index()
    {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();
 
        $bouquetCategoryNames = [
            'Hand Bouquet - All Category',
            'Wedding Bouquet',
            'Graduation Bouquet',
            'Anniversarry Bouquet',
            'Baloon Bouquet',
            'Artificial Bouquet',
        ];
 
        // Ambil semua kategori dari database dalam satu kali panggilan
        $allCategories = $categoryModel->findAll();
 
        // Inisialisasi array
        $bouquetCategories   = [];
        $nonBouquetCategories = [];
        $bouquetCategoryIds  = [];
        $nonBouquetCategoryIds = [];
        $categoryNamesMap    = [];
 
        // Pisahkan kategori bouquet dan non-bouquet dalam satu loop
        foreach ($allCategories as $category) {
            $categoryNamesMap[$category['category_id']] = $category['nama_kategori'];
            if (in_array($category['nama_kategori'], $bouquetCategoryNames)) {
                $bouquetCategories[]  = $category;
                $bouquetCategoryIds[] = $category['category_id'];
            } else {
                $nonBouquetCategories[] = $category;
                $nonBouquetCategoryIds[] = $category['category_id'];
            }
        }
 
        $data['categories']            = $bouquetCategories;
        $data['allExistingCategories'] = $allCategories; // Jika masih diperlukan di view
        $data['categoryNamesMap']      = $categoryNamesMap;
 
        // --- Ambil Produk berdasarkan Kategori ---
        $productsByCategory = [];
        if (!empty($bouquetCategoryIds)) {
            $allBouquetProducts = $productModel->whereIn('category_id', $bouquetCategoryIds)
                                               ->where('is_active', 1)
                                               ->findAll();
            foreach ($allBouquetProducts as $product) {
                $productsByCategory[$product['category_id']][] = $product;
            }
        }
        $data['productsByCategory'] = $productsByCategory;
 
        $nonBouquetProducts = [];
        if (!empty($nonBouquetCategoryIds)) {
            $nonBouquetProducts = $productModel->whereIn('category_id', $nonBouquetCategoryIds)
                                               ->where('is_active', 1)
                                               ->findAll();
        }
        $data['nonBouquetProducts'] = $nonBouquetProducts;
 
        // --- Ambil Produk Bestseller (hanya dari kategori bouquet) ---
        $bestsellerBouquetProducts = [];
        if (!empty($bouquetCategoryIds)) {
            $bestsellerBouquetProducts = $productModel->whereIn('category_id', $bouquetCategoryIds)
                                                      ->where('is_active', 1)
                                                      ->orderBy('tanggal_dibuat', 'DESC')
                                                      ->limit(6)
                                                      ->findAll();
        }
        $data['bestsellerBouquetProducts'] = $bestsellerBouquetProducts;
 
        // --- Ambil Artikel ---
        $artikelModel = new ArtikelModel();
        $data['artikels'] = $artikelModel->orderBy('tanggal_dibuat', 'DESC')->findAll();

        // Memuat view dashboard dan mengirimkan data
        return view('dashboard', $data);
    }

    public function shop()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // Ambil data filter dari request (GET atau POST)
        $keyword = $this->request->getVar('keyword');
        $categoryId = $this->request->getVar('category');

        // Mulai query builder untuk produk yang aktif
        $productsQuery = $productModel->where('is_active', 1);

        // Terapkan filter jika ada
        if (!empty($categoryId)) {
            $productsQuery->where('category_id', $categoryId);
        }

        if (!empty($keyword)) {
            $productsQuery->like('nama_produk', $keyword)
                          ->orLike('deskripsi_produk', $keyword);
        }
        
        // Siapkan data untuk view
        $data = [
            'products'   => $productsQuery->paginate(9, 'shop_group'), // 'shop_group' adalah nama grup paginasi
            'pager'      => $productModel->pager,
            'categories' => $categoryModel->findAll(),
            'selectedCategory' => $categoryId,
            'keyword'    => $keyword,
        ];
        
        return view('shop', $data);
    }

    public function productDetail($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // Ambil detail produk bersama dengan nama kategorinya
        $product = $productModel->select('products.*, categories.nama_kategori')
                                ->join('categories', 'categories.category_id = products.category_id', 'left')
                                ->where('products.product_id', $id)
                                ->where('products.is_active', 1)
                                ->first();

        // Jika produk tidak ditemukan, tampilkan halaman 404
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product with ID $id not found.");
        }

        // Ambil produk terkait (dari kategori yang sama, kecuali produk ini sendiri)
        $relatedProducts = $productModel->where('category_id', $product['category_id'])
                                        ->where('product_id !=', $id)
                                        ->where('is_active', 1)
                                        ->limit(4)
                                        ->findAll();

        $data = [
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
            'categories'      => $categoryModel->findAll(), // Untuk sidebar
        ];

        return view('shop-detail', $data);
    }

    public function artikel($id)
    {
        $artikelModel = new ArtikelModel();
        $productModel = new ProductModel(); // Tambahkan ProductModel
        $artikel = $artikelModel->find($id);

        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Artikel with ID $id not found.");
        }

        $relatedProducts = [];
        // Cek jika ada produk terkait di artikel
        if (!empty($artikel['produk_terkait'])) {
            // Ubah string ID produk (e.g., "PRDK01,PRDK02") menjadi array
            $relatedProductIds = explode(',', $artikel['produk_terkait']);
            
            // Hapus spasi kosong dari setiap ID
            $relatedProductIds = array_map('trim', $relatedProductIds);

            // Ambil data produk berdasarkan ID yang terkait, beserta nama kategorinya
            $relatedProducts = $productModel
                ->select('products.*, categories.nama_kategori')
                ->join('categories', 'categories.category_id = products.category_id', 'left')
                ->whereIn('products.product_id', $relatedProductIds)
                ->where('products.is_active', 1)
                ->findAll();
        }

        $data = [
            'artikel' => $artikel,
            'relatedProducts' => $relatedProducts, // Kirim produk terkait ke view
        ];

        return view('artikel_detail', $data);
    }
      public function allArticles()
    {
        $artikelModel = new ArtikelModel();
        $data['artikels'] = $artikelModel->orderBy('tanggal_dibuat', 'DESC')->findAll();

        return view('all_articles', $data); // Buat view baru bernama all_articles.php
    }
}
