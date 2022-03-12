<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtimes extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'employee_id',
        'date',
        'time_started',
        'time_ended',
    ];
}
