<?php

namespace App\Models;

use App\Enums\ContactItemTypeEnum;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactItem extends Model
{
    use HasFactory;
    use UUID;

    /**
     * @var array <int,string>
     */
    protected $fillable = [
        'contact_id',
        'type',
        'value',
    ];

    protected $casts = [
        'type' => ContactItemTypeEnum::class,
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
