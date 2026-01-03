<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show lost items list.
     */
    public function lostItems(Request $request)
    {
        $query = LostItem::active()->with(['user', 'category']);

        // Search by name or description
        if ($request->search) {
            $query->where('nama_barang', 'like', "%{$request->search}%")
                  ->orWhere('deskripsi', 'like', "%{$request->search}%");
        }

        // Filter by category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by location
        if ($request->location) {
            $query->where('lokasi_terakhir', 'like', "%{$request->location}%");
        }

        // Filter by date range
        if ($request->date_from && $request->date_to) {
            $query->whereDate('tanggal_hilang', '>=', $request->date_from)
                  ->whereDate('tanggal_hilang', '<=', $request->date_to);
        }

        $lostItems = $query->paginate(12);
        $categories = Category::all();

        return view('reports.lost-items', [
            'lostItems' => $lostItems,
            'categories' => $categories,
        ]);
    }

    /**
     * Show found items list.
     */
    public function foundItems(Request $request)
    {
        $query = FoundItem::active()->with(['user', 'category']);

        // Search by name or description
        if ($request->search) {
            $query->where('nama_barang', 'like', "%{$request->search}%")
                  ->orWhere('deskripsi', 'like', "%{$request->search}%");
        }

        // Filter by category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by location
        if ($request->location) {
            $query->where('lokasi_ditemukan', 'like', "%{$request->location}%");
        }

        // Filter by date range
        if ($request->date_from && $request->date_to) {
            $query->whereDate('tanggal_ditemukan', '>=', $request->date_from)
                  ->whereDate('tanggal_ditemukan', '<=', $request->date_to);
        }

        $foundItems = $query->paginate(12);
        $categories = Category::all();

        return view('reports.found-items', [
            'foundItems' => $foundItems,
            'categories' => $categories,
        ]);
    }

    /**
     * Show form to create lost item.
     */
    public function createLostItem()
    {
        $categories = Category::all();
        return view('reports.create-lost-item', ['categories' => $categories]);
    }

    /**
     * Store lost item.
     */
    public function storeLostItem(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'deskripsi' => ['required', 'string', 'max:1000'],
            'lokasi_terakhir' => ['required', 'string', 'max:255'],
            'tanggal_hilang' => ['required', 'date'],
            'foto_barang' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Simpan file jika ada
        if ($request->hasFile('foto_barang')) {
            $validated['foto_barang'] = $request->file('foto_barang')->store('lost-items', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'hilang';

        LostItem::create($validated);

        return redirect()->route('dashboard')->with('success', 'Laporan kehilangan berhasil dibuat!');
    }

    /**
     * Show form to create found item.
     */
    public function createFoundItem()
    {
        $categories = Category::all();
        return view('reports.create-found-item', ['categories' => $categories]);
    }

    /**
     * Store found item.
     */
    public function storeFoundItem(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'deskripsi' => ['required', 'string', 'max:1000'],
            'lokasi_ditemukan' => ['required', 'string', 'max:255'],
            'tanggal_ditemukan' => ['required', 'date'],
            'kontak_penemu' => ['required', 'string', 'max:50'],
            'foto_barang' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Simpan file jika ada
        if ($request->hasFile('foto_barang')) {
            $validated['foto_barang'] = $request->file('foto_barang')->store('found-items', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'menunggu';
        $validated['allow_contact'] = $request->has('allow_contact');

        FoundItem::create($validated);

        return redirect()->route('dashboard')->with('success', 'Laporan penemuan berhasil dibuat!');
    }

    /**
     * Show lost item detail.
     */
    public function showLostItem(LostItem $lostItem)
    {
        return view('reports.show-lost-item', [
            'item' => $lostItem->load(['user', 'category'])
        ]);
    }

    /**
     * Show found item detail.
     */
    public function showFoundItem(FoundItem $foundItem)
    {
        return view('reports.show-found-item', [
            'item' => $foundItem->load(['user', 'category'])
        ]);
    }

    /**
     * Edit lost item.
     */
    public function editLostItem(LostItem $lostItem)
    {
        // Pastikan hanya pemilik laporan
        if ($lostItem->user_id !== auth()->id()) {
            return abort(403);
        }

        $categories = Category::all();
        return view('reports.edit-lost-item', [
            'item' => $lostItem,
            'categories' => $categories,
        ]);
    }

    /**
     * Update lost item.
     */
    public function updateLostItem(Request $request, LostItem $lostItem)
    {
        // Pastikan hanya pemilik laporan
        if ($lostItem->user_id !== auth()->id()) {
            return abort(403);
        }

        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'deskripsi' => ['required', 'string', 'max:1000'],
            'lokasi_terakhir' => ['required', 'string', 'max:255'],
            'tanggal_hilang' => ['required', 'date'],
            'foto_barang' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Update file jika ada
        if ($request->hasFile('foto_barang')) {
            if ($lostItem->foto_barang) {
                \Storage::delete('public/' . $lostItem->foto_barang);
            }
            $validated['foto_barang'] = $request->file('foto_barang')->store('lost-items', 'public');
        }

        $lostItem->update($validated);

        return redirect()->route('dashboard')->with('success', 'Laporan kehilangan berhasil diperbarui!');
    }

    /**
     * Delete lost item.
     */
    public function destroyLostItem(LostItem $lostItem)
    {
        if ($lostItem->user_id !== auth()->id()) {
            return abort(403);
        }

        if ($lostItem->foto_barang) {
            \Storage::delete('public/' . $lostItem->foto_barang);
        }

        $lostItem->delete();

        return redirect()->route('dashboard')->with('success', 'Laporan kehilangan berhasil dihapus!');
    }

    /**
     * Delete found item.
     */
    public function destroyFoundItem(FoundItem $foundItem)
    {
        if ($foundItem->user_id !== auth()->id()) {
            return abort(403);
        }

        if ($foundItem->foto_barang) {
            \Storage::delete('public/' . $foundItem->foto_barang);
        }

        $foundItem->delete();

        return redirect()->route('dashboard')->with('success', 'Laporan penemuan berhasil dihapus!');
    }

    /**
     * Update status of lost or found item.
     */
    public function updateStatus(Request $request, $id)
    {
        // Tentukan model dan status yang valid berdasarkan route
        if ($request->is('lost-items/*/status')) {
            $item = \App\Models\LostItem::findOrFail($id);
            $validStatus = ['hilang','ditemukan','selesai'];
        } elseif ($request->is('found-items/*/status')) {
            $item = \App\Models\FoundItem::findOrFail($id);
            $validStatus = ['menunggu','diklaim','selesai'];
        } else {
            abort(404);
        }

        // Pastikan hanya pemilik laporan bisa update
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengubah status ini.');
        }

        // Validasi status
        $request->validate([
            'status' => 'required|in:' . implode(',', $validStatus),
        ]);

        // Update status
        $item->status = $request->status;
        $item->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
