<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProducts extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'col_a', 'col_b', 'col_c',
    ];

}
