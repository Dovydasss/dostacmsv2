<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Header extends Model
{
    use HasFactory;
    protected $table = 'header';
    protected $fillable = [
        'header_image',
        'width',
        'height',
        'show_header'

    ];

}
