<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
