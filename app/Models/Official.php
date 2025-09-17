<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'position',
        'image_path',
        'term_start',
        'term_end',
        'status'
    ];

    protected $casts = [
        'term_start' => 'date',
        'term_end' => 'date'
    ];
}
