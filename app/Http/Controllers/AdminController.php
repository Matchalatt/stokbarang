<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan daftar pengguna yang belum disetujui.
     */
    public function index()
    {
        // Ambil ID untuk role 'admin'
        $adminRoleId = Role::where('name', 'admin')->value('id');

        // Ambil semua user yang BUKAN admin dan status approve-nya false
        $pendingUsers = User::where('role_id', '!=', $adminRoleId)
                            ->where('approve', false)
                            ->with('role') // Memuat relasi role untuk ditampilkan di view
                            ->get();

        return view('admin.dashboard', compact('pendingUsers'));
    }

    /**
     * Menyetujui seorang pengguna.
     */
    public function approve(User $user)
    {
        $user->update(['approve' => true]);

        return redirect()->route('admin.dashboard')->with('success', 'User ' . $user->name . ' has been approved.');
    }
}