<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkmodel;
    
    public function __construct()
    {
        $this->produkmodel = new ProdukModel();
    }

    public function index()
    {
        return view('data_produk/v_produk');
    }    
    
    public function tampil_produk()
    {
        $produk = $this->produkmodel->findAll();

        return $this->response->setJSON([
            'status'    => 'success',
            'produk'    => $produk
        ]);
    }
    
    public function simpan_produk()
    {
        //validasi input dari AJAX
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_produk'   => 'required',
            'harga'         => 'required|decimal',
            'stok'          => 'required|integer',
        ]);

        if(!$validation->withRequest($this->request)->run()){
            return $this->response->setJSON([
                'status'       => 'error',
                'errors'       => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
        ];

        $this->produkmodel->save($data);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => 'Data produk berhasil disimpan',
        ]);
    }

    public function hapus_produk($id)
    {
        // Cek apakah produk dengan ID yang diberikan ada di database
        $produk = $this->produkmodel->find($id);
        if (!$produk) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Produk tidak ditemukan',
            ]);
        }

        // Hapus produk
        if ($this->produkmodel->delete($id)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Produk berhasil dihapus',
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menghapus produk',
            ]);
        }
    }

    public function detail($id) {
        $produk = $this->produkmodel->find($id); // Ubah ke $this->produkmodel
        
        if ($produk) {
            return $this->response->setJSON(['status' => 'success', 'produk' => $produk]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
        }
    }
    
    public function updateProduk()
    {
        $id = $this->request->getVar('id_produk');
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga'       => $this->request->getVar('harga'),
            'stok'        => $this->request->getVar('stok'),
        ];

        if ($this->produkmodel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Produk berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui produk']);
        }
    }

}