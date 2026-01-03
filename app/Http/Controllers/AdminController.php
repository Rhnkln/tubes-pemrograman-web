<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        // Statistik umum
        $totalUsers = User::count();
        $totalLostItems = LostItem::count();
        $totalFoundItems = FoundItem::count();
        $totalReports = $totalLostItems + $totalFoundItems;

        // Pending reports
        $pendingLost = LostItem::whereIn('status', ['hilang', 'ditemukan'])->count();
        $pendingFound = FoundItem::whereIn('status', ['menunggu', 'diklaim'])->count();
        $pendingReports = $pendingLost + $pendingFound;

        // Semua laporan untuk list / tabel
        $allLostItems = LostItem::with('user', 'category')->latest()->get();
        $allFoundItems = FoundItem::with('user', 'category')->latest()->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalLostItems',
            'totalFoundItems',
            'totalReports',
            'pendingReports',
            'allLostItems',
            'allFoundItems'
        ));
    }

    /**
     * Show users list.
     */
    public function users(Request $request)
    {
        $query = User::with('role');

        // Search by name, email, or NIM
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('nim', 'like', "%{$request->search}%");
        }

        $users = $query->paginate(15);

        return view('admin.users', ['users' => $users]);
    }

    /**
     * Delete user.
     */
    public function destroyUser(User $user)
    {
        // Cegah user menghapus akun sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Show all user reports (Lost + Found) in admin panel.
     */
    public function reports(Request $request)
    {
        $type = $request->type;     // kehilangan | penemuan
        $status = $request->status; // filter status
        $reports = collect();

        /**
         * LOST ITEMS (KEHILANGAN)
         */
        if (!$type || $type === 'kehilangan') {
            $lostItems = LostItem::with('user')
                ->when($status, fn($q) => $q->where('status', $status))
                ->get()
                ->map(fn($item) => (object) [
                    'judul' => $item->nama_barang,
                    'tipe' => 'kehilangan',
                    'status' => $item->status,
                    'tanggal_laporan' => $item->created_at,
                    'user' => $item->user,
                    'lostItem' => $item,
                    'foundItem' => null,
                ]);

            $reports = $reports->merge($lostItems);
        }

        /**
         * FOUND ITEMS (PENEMUAN)
         */
        if (!$type || $type === 'penemuan') {
            $foundItems = FoundItem::with('user')
                ->when($status, fn($q) => $q->where('status', $status))
                ->get()
                ->map(fn($item) => (object) [
                    'judul' => $item->nama_barang,
                    'tipe' => 'penemuan',
                    'status' => $item->status,
                    'tanggal_laporan' => $item->created_at,
                    'user' => $item->user,
                    'lostItem' => null,
                    'foundItem' => $item,
                ]);

            $reports = $reports->merge($foundItems);
        }

        // Urutkan terbaru
        $reports = $reports->sortByDesc('tanggal_laporan');

        // Pagination manual
        $perPage = 15;
        $page = request()->get('page', 1);
        $paginatedReports = new \Illuminate\Pagination\LengthAwarePaginator(
            $reports->forPage($page, $perPage),
            $reports->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.reports', ['reports' => $paginatedReports]);
    }

    /**
     * Show report detail.
     */
    public function showReport(Report $report)
    {
        return view('admin.show-report', [
            'report' => $report->load(['user', 'lostItem', 'foundItem'])
        ]);
    }

    /**
     * Update report status.
     */
    public function updateReportStatus(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,diproses,terselesaikan,ditolak'],
        ]);

        $report->update($validated);

        return back()->with('success', 'Status laporan berhasil diperbarui!');
    }

    /**
     * Delete report.
     */
    public function destroyReport(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.reports')->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Show lost items list.
     */
    public function lostItems(Request $request)
    {
        $query = LostItem::with(['user', 'category']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('nama_barang', 'like', "%{$request->search}%");
        }

        $items = $query->latest()->paginate(15);

        return view('admin.lost-items', ['items' => $items]);
    }

    /**
     * Show found items list.
     */
    public function foundItems(Request $request)
    {
        $query = FoundItem::with(['user', 'category']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('nama_barang', 'like', "%{$request->search}%");
        }

        $items = $query->latest()->paginate(15);

        return view('admin.found-items', ['items' => $items]);
    }

    /**
     * Update lost item status.
     */
    public function updateLostItemStatus(Request $request, LostItem $item)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:hilang,ditemukan,selesai'],
        ]);

        $item->update($validated);

        return back()->with('success', 'Status barang hilang berhasil diperbarui!');
    }

    /**
     * Update found item status.
     */
    public function updateFoundItemStatus(Request $request, FoundItem $item)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu,diklaim,selesai'],
        ]);

        $item->update($validated);

        return back()->with('success', 'Status barang temuan berhasil diperbarui!');
    }

    /**
     * Delete lost item.
     */
    public function destroyLostItem(LostItem $item)
    {
        if ($item->foto_barang) {
            \Storage::delete('public/' . $item->foto_barang);
        }

        $item->delete();
        return redirect()->route('admin.lost-items')->with('success', 'Barang hilang berhasil dihapus!');
    }

    /**
     * Delete found item.
     */
    public function destroyFoundItem(FoundItem $item)
    {
        if ($item->foto_barang) {
            \Storage::delete('public/' . $item->foto_barang);
        }
        $item->delete();
        return redirect()->route('admin.found-items')->with('success', 'Barang temuan berhasil dihapus!');
    }

    /**
     * Show categories list.
     */
    public function categories()
    {
        $categories = Category::withCount(['lostItems', 'foundItems'])->get();

        return view('admin.categories', ['categories' => $categories]);
    }

    /**
     * Store new category.
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'slug' => ['required', 'string', 'unique:categories'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        Category::create($validated);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Delete category.
     */
    public function destroyCategory(Category $category)
    {
        if ($category->lostItems()->exists() || $category->foundItems()->exists()) {
            return back()->with('error', 'Tidak bisa menghapus kategori yang sudah digunakan!');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Show lost item detail (Admin view).
     */
    public function showLostItem(LostItem $item)
    {
        return view('admin.lost-item', compact('item'));
    }
}
