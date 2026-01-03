<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'content',
        'found_item_id',
        'lost_item_id',
        'is_read',
    ];

    /**
     * Relasi: user pengirim
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Relasi: user penerima
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * Relasi: terkait dengan item yang ditemukan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foundItem()
    {
        return $this->belongsTo(FoundItem::class);
    }

    /**
     * Relasi: terkait dengan item yang hilang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lostItem()
    {
        return $this->belongsTo(LostItem::class);
    }
}
