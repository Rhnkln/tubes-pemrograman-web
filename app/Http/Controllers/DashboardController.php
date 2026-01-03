<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * Menampilkan statistik item hilang, item temuan,
     * dan laporan terbaru untuk user yang sedang login.
     */
    public function index()
    {
        $user = auth()->user();

        // Hitung total item hilang dan temuan
        $lostItemsCount  = LostItem::count();
        $foundItemsCount = FoundItem::count();
        $reportsCount    = $lostItemsCount + $foundItemsCount;

        // Ambil 5 item hilang terbaru
        $recentLostItems = LostItem::latest()
            ->take(5)
            ->get();

        // Ambil 5 item temuan terbaru
        $recentFoundItems = FoundItem::latest()
            ->take(5)
            ->get();

        // Ambil 5 laporan terbaru milik user
        $recentReports = Report::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        // Kembalikan view dashboard dengan data
        return view('dashboard.index', [
            'lostItemsCount' => $lostItemsCount,
            'foundItemsCount' => $foundItemsCount,
            'reportsCount' => $reportsCount,
            'recentLostItems' => $recentLostItems,
            'recentFoundItems' => $recentFoundItems,
            'recentReports' => $recentReports,
        ]);
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        return view('dashboard.profile', ['user' => auth()->user()]);
    }

    /**
     * Update user profile.
     *
     * Menangani update data profil dan foto profil.
     */
    public function updateProfile(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'phone' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = auth()->user();

        // Upload dan simpan foto profil baru jika ada
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                \Storage::delete('public/' . $user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profile', 'public');
            $validated['foto_profil'] = $path;
        }

        // Update data user
        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
