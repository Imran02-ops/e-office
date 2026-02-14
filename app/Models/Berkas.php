<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = [
        'nama_berkas',
        'file_path',
        'status'
    ];
}

