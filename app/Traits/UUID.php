<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UUID
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
           if (is_null($model->getKey())) {
               $model->setAttribute(
                   $model->getKeyName(),
                   Str::uuid()->toString()
               );
           }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
