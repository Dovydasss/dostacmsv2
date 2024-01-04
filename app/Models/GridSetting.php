<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GridSetting extends Model
{
    use HasFactory;
    protected $fillable = ['page_id', 'layout'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
