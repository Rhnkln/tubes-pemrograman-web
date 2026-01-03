<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles  Role yang diperbolehkan mengakses route ini
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login, redirect ke halaman login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil nama role user saat ini
        $userRole = auth()->user()->role?->name;

        // Jika role user tidak termasuk dalam role yang diperbolehkan, tampilkan 403
        if (!in_array($userRole, $roles)) {
            return response()->view('errors.403', [], 403);
        }

        // Lanjutkan request ke controller/next middleware
        return $next($request);
    }

    public function destroyReport(Report $report)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak punya akses untuk menghapus laporan.');
        }

        $report->delete();

        return redirect()->route('admin.reports')->with('success', 'Laporan berhasil dihapus!');
    }

}
