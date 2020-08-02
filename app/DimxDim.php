<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DimxDim extends Model
{
    protected $table = "dimx_dim";
    public $timestamps = false;
    protected $fillable = ['dim_id','nim','nama',
    'thn_masuk','dari_jlh_anak',
    'penghasilan_ayah','penghasilan_ayah_id',
    'penghasilan_ibu','penghasilan_ibu_id',
    'pekerjaan_ayah_id','keterangan_pekerjaan_ayah',
    'pekerjaan_ibu_id','keterangan_pekerjaan_ibu'];

    public function skkm()
    {
        return $this->hasMany(SKKM::class);
    }
}
