<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;
    use UUID;

    /**
     * @var array<int,string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'last_name',
        'company',
        'photo',
    ];

    /**
     * @return HasMany
     */
    public function contactItems(): HasMany
    {
        return $this->hasMany(ContactItem::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->name} {$this->last_name}",
        );
    }
}
