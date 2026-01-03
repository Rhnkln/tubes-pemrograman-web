<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\FoundItem;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * Menampilkan item hilang dan item temuan terbaru,
     * serta total item hilang dan temuan.
     */
    public function index()
    {
        // Ambil 6 laporan barang hilang terbaru yang aktif
        $recentLostItems = LostItem::active()
            ->with(['user', 'category']) // Load relasi user & category
            ->latest()
            ->limit(6)
            ->get();

        // Ambil 6 laporan barang temuan terbaru yang aktif
        $recentFoundItems = FoundItem::active()
            ->with(['user', 'category']) // Load relasi user & category
            ->latest()
            ->limit(6)
            ->get();

        // Hitung total item hilang dan temuan
        $totalLostItems = LostItem::count();
        $totalFoundItems = FoundItem::count();

        // Kembalikan view welcome dengan data
        return view('welcome', [
            'recentLostItems' => $recentLostItems,
            'recentFoundItems' => $recentFoundItems,
            'totalLostItems' => $totalLostItems,
            'totalFoundItems' => $totalFoundItems,
        ]);
    }
}
