<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    /**
     * Relasi: semua barang hilang yang termasuk kategori ini
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lostItems()
    {
        return $this->hasMany(LostItem::class);
    }

    /**
     * Relasi: semua barang temuan yang termasuk kategori ini
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foundItems()
    {
        return $this->hasMany(FoundItem::class);
    }
}
