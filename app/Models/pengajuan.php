<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pengajuan',
        'nama',
        'no_hp',
        'alamat',
        'jenis_surat',
        'keperluan',
        'file_ktp',
        'file_kk',
        'status'
    ];
}