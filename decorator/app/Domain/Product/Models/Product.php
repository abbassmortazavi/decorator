<?php

namespace App\Domain\Product\Models;

use App\Infrastructure\Models\BaseModel;

class Product extends BaseModel
{
    protected $fillable = ['position', 'priority', 'image', 'middle_content_title', 'middle_content', 'footer_content'];

    protected $appends = ['updated_at_affix', 'created_at_affix'];

}
