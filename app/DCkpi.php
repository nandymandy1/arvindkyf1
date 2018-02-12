<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DCkpi extends Model
{
    protected $fillable = [
      'factory_id',
      'cut_qty',
      'consumption',
      'pcs_sew_emb',
      'c_men', 'mcs_used',
      'no_bandkife',
      'no_stknife',
      'no_fusing',
      'fusing_out'
    ];
}
