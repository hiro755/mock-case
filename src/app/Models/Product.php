<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'brand_name',
        'description',
        'img_url',
        'condition',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function getIsSoldAttribute()
    {
        return !is_null($this->buyer_id);
    }
}