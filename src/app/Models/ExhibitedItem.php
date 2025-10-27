<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image_path', 'price', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
