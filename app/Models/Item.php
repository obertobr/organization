<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'fk_item',
    ];

    public function parentItem()
    {
        return $this->belongsTo(Item::class, 'fk_item');
    }

    public function childItems()
    {
        return $this->hasMany(Item::class, 'fk_item');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'item_tags', 'fk_item', 'fk_tag');
    }
}
