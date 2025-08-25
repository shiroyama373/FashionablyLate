<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // カテゴリテーブルのカラムに合わせて
    protected $fillable = [
        'name', // または 'content' など、マイグレーションで作ったカラム名
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}