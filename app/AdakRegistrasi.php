<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdakRegistrasi extends Model
{
    protected $table = "adak_registrasi";
    protected $fillable = ['dim_id','ta','sem_ta','nr','status_akhir_registrasi'];
    public $timestamps = false;
}
