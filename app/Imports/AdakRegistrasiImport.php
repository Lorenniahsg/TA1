<?php

namespace App\Imports;

use App\AdakRegistrasi;
use Maatwebsite\Excel\Concerns\ToModel;

class AdakRegistrasiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdakRegistrasi([
          'dim_id'=> $row[0],
          'ta' => $row[1],
          'sem_ta' => $row[2],
          'nr' => $row[3],
          'status_akhir_registrasi' => $row[4],
        ]);
    }
}
