<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'nama_barang',
        'deskripsi',
        'lokasi_terakhir',
        'tanggal_hilang',
        'foto_barang',
        'status',
    ];

    /**
     * Casting atribut
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_hilang' => 'datetime',
    ];

    /**
     * Relasi: user yang melaporkan barang hilang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: kategori barang hilang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: laporan terkait barang hilang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function report()
    {
        return $this->hasOne(Report::class);
    }

    /**
     * Scope: hanya barang hilang yang aktif (hilang/ditemukan)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['hilang', 'ditemukan']);
    }

    /**
     * Scope: filter berdasarkan kategori
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: filter berdasarkan lokasi terakhir
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('lokasi_terakhir', 'like', "%{$location}%");
    }

    /**
     * Scope: filter berdasarkan rentang tanggal hilang
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_hilang', [$startDate, $endDate]);
    }
}
