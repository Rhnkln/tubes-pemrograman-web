<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display the conversation between the authenticated user
     * and the other user related to a specific lost or found item.
     *
     * @param Request $request
     * @param string $itemType ('found' or 'lost')
     * @param int $itemId
     */
    public function index(Request $request, $itemType, $itemId)
    {
        $user = Auth::user();

        // Ambil item berdasarkan tipe
        $item = $itemType === 'found'
            ? FoundItem::findOrFail($itemId)
            : LostItem::findOrFail($itemId);

        // Id pengguna lain dalam percakapan
        $otherUserId = $item->user_id;

        // Ambil semua pesan terkait percakapan ini
        $messages = Message::where(function($q) use ($user, $otherUserId) {
                $q->where('from_user_id', $user->id)
                  ->where('to_user_id', $otherUserId);
            })
            ->orWhere(function($q) use ($user, $otherUserId) {
                $q->where('from_user_id', $otherUserId)
                  ->where('to_user_id', $user->id);
            })
            ->where($itemType === 'found' ? 'found_item_id' : 'lost_item_id', $itemId)
            ->orderBy('created_at')
            ->get();

        return view('messages.index', compact('messages', 'item', 'itemType', 'itemId', 'otherUserId'));
    }

    /**
     * Store a new message for the conversation related
     * to a specific lost or found item.
     *
     * @param Request $request
     * @param string $itemType ('found' or 'lost')
     * @param int $itemId
     */
    public function store(Request $request, $itemType, $itemId)
    {
        // Validasi input pesan
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Ambil item berdasarkan tipe
        $item = $itemType === 'found'
            ? FoundItem::findOrFail($itemId)
            : LostItem::findOrFail($itemId);

        $otherUserId = $item->user_id;

        // Simpan pesan
        Message::create([
            'from_user_id' => $user->id,
            'to_user_id' => $otherUserId,
            'content' => $request->content,
            'found_item_id' => $itemType === 'found' ? $itemId : null,
            'lost_item_id' => $itemType === 'lost' ? $itemId : null,
        ]);

        return redirect()->back();
    }
}
