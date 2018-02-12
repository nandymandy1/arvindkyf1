<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSkpi extends Model
{
    protected $fillable = [
      'no_load',
      'no_line',
      'elo',
      'so_pl',
      'no_sew_mcs',
      'no_people',
      'no_help',
      'no_kaja',
      'no_opr',
      'sam',
      'no_send',
    ];
}
