<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;
    public $softDeletes = false;

    protected $fillable = [
        'code',
        'name',
    ];
}
