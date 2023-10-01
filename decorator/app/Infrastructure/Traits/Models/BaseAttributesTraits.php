<?php

namespace App\Infrastructure\Traits\Models;


use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;


trait BaseAttributesTraits
{
    /**
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => Carbon::make($value)->format('Y-m-d H:i:s')
        );
    }

    /**
     * @return Attribute
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => Carbon::make($value)->format('Y-m-d H:i:s')
        );
    }


    /**
     * Return Created At Date
     *
     * @return string|null
     * @throws Exception
     */
    public function getCreatedAtAffixAttribute(): ?string
    {
        return !empty($this->created_at) ? jdate($this->created_at)->format('Y-m-d H:i:s') : null;
    }

    /**
     * Return Updated At Date
     *
     * @return string|null
     * @throws Exception
     */
    public function getUpdatedAtAffixAttribute(): ?string
    {
        return !empty($this->updated_at) ? jdate($this->updated_at)->format('Y-m-d H:i:s') : null;
    }


    public function getDeletedAtAffixAttribute(): ?string
    {
        return !empty($this->deleted_at) ? jdate($this->deleted_at)->format('Y-m-d H:i:s') : null;

    }

}
