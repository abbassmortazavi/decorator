<?php

namespace App\Infrastructure\Models;

use App\Infrastructure\Traits\Models\BaseAttributesTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BaseEntity.
 *
 * @package namespace App\Entities;
 */
abstract class BaseModel extends Model
{
    use SoftDeletes, HasFactory, BaseAttributesTraits;

    protected $hidden = ['deleted_at'];
}
