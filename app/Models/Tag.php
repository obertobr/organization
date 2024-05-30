<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_tags', 'fk_tag', 'fk_item');
    }
}
