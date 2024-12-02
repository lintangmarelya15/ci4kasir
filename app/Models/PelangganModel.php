<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table      = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_pelanggan', 'alamat', 'nomor_telepon'];

    protected $validationRules = [
        'nama_pelanggan'  => 'required|min_length[3]',
        'alamat'          => 'required|min_length[5]',
        'nomor_telepon'   => 'required|numeric|min_length[10]'
    ];
}
 