<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    // Specify the table if it's not the pluralized form of the model name
    protected $table = 'content_blocks';

    // Mass assignable attributes
    protected $fillable = ['title', 'page_id', 'type', 'content', 'order'];

    // Relationship with Page
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Add any other necessary methods or attributes here
}
