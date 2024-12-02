<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use CodeIgniter\Controller;

class Pelanggan extends Controller
{
    protected $PelangganModel;

    public function __construct()
    {
        $this->PelangganModel = new PelangganModel();
    }

    public function index()
    {
        return view('data_pelanggan/v_pelanggan');
    } 

    public function tampil_pelanggan()
    {
        // Ambil data pelanggan
        $pelanggan = $this->PelangganModel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'pelanggan' => $pelanggan
        ]);
    }

    public function simpan_pelanggan()
    {
        //validasi input dari AJAX
        $data = [
            'nama_pelanggan'  => $this->request->getPost('nama_pelanggan'),
            'alamat'          => $this->request->getPost('alamat'),
            'nomor_telepon'   => $this->request->getPost('nomor_telepon')
        ];

        // Validasi input
        if (!$this->validate([
            'nama_pelanggan' => 'required',
            'alamat'         => 'required',
            'nomor_telepon'  => 'required'
        ])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }

        // Simpan data pelanggan
        if ($this->PelangganModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data pelanggan berhasil disimpan'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data pelanggan'
            ]);
        }
    }


    public function hapus($id)
    {
        // Hapus data pelanggan berdasarkan ID
        if ($this->PelangganModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data pelanggan berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus data pelanggan'
            ]);
        }
    }


    public function updatePelanggan()
    {
        $id = $this->request->getVar('id_pelanggan');
        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'alamat'       => $this->request->getVar('alamat'),
            'nomor_telepon'        => $this->request->getVar('nomor_telepon'),
        ];

        if ($this->PelangganModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Produk berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui produk']);
        }
    }

    public function detail($id) {
        $pelanggan = $this->PelangganModel->find($id); // Ubah ke $this->produkmodel
        
        if ($pelanggan) {
            return $this->response->setJSON(['status' => 'success', 'pelanggan' => $pelanggan]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
        
        }
    }
}
