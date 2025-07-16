<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel; // <-- Tambahkan ini

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel; // <-- Tambahkan ini

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel(); // <-- Tambahkan ini
    }
 public function index()
    {
        // Use the class property for the ProductModel
        // $productModel = new ProductModel(); // REMOVE THIS LINE
        // $categoryModel = new CategoryModel(); // REMOVE THIS LINE if not needed, but can keep for consistency

        $categoryId = $this->request->getGet('category');

        $perPage = 10; // Jumlah produk per halaman

        $builder = $this->productModel // Use $this->productModel here
            ->select('products.*, categories.nama_kategori')
            ->join('categories', 'categories.category_id = products.category_id', 'left');

        if (!empty($categoryId)) {
            $builder->where('products.category_id', $categoryId);
        }

        $products = $builder->paginate($perPage, 'products');

        return view('admin/products/index', [
            'products' => $products,
            'pager' => $this->productModel->pager, // Use $this->productModel->pager here
            'categories' => $this->categoryModel->findAll(), // Use $this->categoryModel here
            'selectedCategory' => $categoryId
        ]);
    }

    
    public function create()
    {
        // Ambil data kategori untuk dropdown
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/products/create', $data);
    }



    public function store()
    {
        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'harga'       => 'required|numeric',
            'category_id' => 'required',

            'gambar_url'  => 'uploaded[gambar_url]|max_size[gambar_url,2048]|is_image[gambar_url]|mime_in[gambar_url,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarFile = $this->request->getFile('gambar_url');
        $namaGambar = $gambarFile->getRandomName();
        $gambarFile->move('assets/img/gambar', $namaGambar);

        $this->productModel->save([
            'nama_produk'      => $this->request->getVar('nama_produk'),
            'deskripsi_produk' => $this->request->getVar('deskripsi_produk'),
            'harga'            => $this->request->getVar('harga'),
            'category_id'      => $this->request->getVar('category_id'),
            'is_active'        => $this->request->getVar('is_active') ?? 0,
            'gambar_url'       => $namaGambar,
        ]);

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['product'] = $this->productModel->find($id);
        if (empty($data['product'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }
        // Ambil data kategori untuk dropdown
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/products/edit', $data);
    }



    public function update($id)
    {
        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'harga'       => 'required|numeric',
            'category_id' => 'required',

        ];

        $gambarFile = $this->request->getFile('gambar_url');
        if ($gambarFile->isValid()) {
            $rules['gambar_url'] = 'max_size[gambar_url,2048]|is_image[gambar_url]|mime_in[gambar_url,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $dataToUpdate = [
            'nama_produk'      => $this->request->getVar('nama_produk'),
            'deskripsi_produk' => $this->request->getVar('deskripsi_produk'),
            'harga'            => $this->request->getVar('harga'),
            'category_id'      => $this->request->getVar('category_id'),
            'is_active'        => $this->request->getVar('is_active') ?? 0,
        ];

        if ($gambarFile->isValid()) {
            $productLama = $this->productModel->find($id);
            if ($productLama['gambar_url'] && file_exists('assets/img/gambar/' . $productLama['gambar_url'])) {
                unlink('assets/img/gambar/' . $productLama['gambar_url']);
            }
            $namaGambar = $gambarFile->getRandomName();
            $gambarFile->move('assets/img/gambar', $namaGambar);
            $dataToUpdate['gambar_url'] = $namaGambar;
        }

        $this->productModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil diperbarui.');
    }
    
    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if ($product) {
            if ($product['gambar_url'] && file_exists('assets/img/gambar/' . $product['gambar_url'])) {
                unlink('assets/img/gambar/' . $product['gambar_url']);
            }
            $this->productModel->delete($id);
            return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
        }
        return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
    }
}