<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class References extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'code',
        'name',
        'expression',
    ];
}
