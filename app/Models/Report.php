<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lost_item_id',
        'found_item_id',
        'user_id',
        'judul',
        'keterangan',
        'tipe',
        'status',
        'tanggal_laporan',
    ];

    /**
     * Casting atribut
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_laporan' => 'datetime',
    ];

    /**
     * Relasi: laporan dibuat oleh user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: laporan kehilangan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lostItem()
    {
        return $this->belongsTo(LostItem::class);
    }

    /**
     * Relasi: laporan penemuan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foundItem()
    {
        return $this->belongsTo(FoundItem::class);
    }

    /**
     * Scope: ambil laporan dengan status pending
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: filter laporan berdasarkan tipe
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('tipe', $type);
    }

    /**
     * Scope: filter laporan berdasarkan status
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
