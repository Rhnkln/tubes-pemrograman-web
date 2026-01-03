<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundItem extends Model
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
        'lokasi_ditemukan',
        'tanggal_ditemukan',
        'foto_barang',
        'kontak_penemu',
        'allow_contact',
        'status',
    ];

    /**
     * Casting atribut
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_ditemukan' => 'datetime',
    ];

    /**
     * Relasi: user yang melaporkan barang temuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: kategori barang temuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: laporan terkait barang temuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function report()
    {
        return $this->hasOne(Report::class);
    }

    /**
     * Scope: hanya barang temuan yang aktif (menunggu/diklaim)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['menunggu', 'diklaim']);
    }

    /**
     * Scope: filter berdasarkan kategori
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: filter berdasarkan lokasi ditemukannya barang
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('lokasi_ditemukan', 'like', "%{$location}%");
    }

    /**
     * Scope: filter berdasarkan rentang tanggal ditemukan
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_ditemukan', [$startDate, $endDate]);
    }
}
