<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menangani pembuatan user baru dari form registrasi.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form registrasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'divisi' => ['required', 'string', 'exists:roles,name'], // Memastikan divisi valid
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' akan mencocokkan dengan 'password_confirmation'
        ]);

        // 2. Cari ID role berdasarkan nama 'divisi'
        $role = Role::where('name', $request->divisi)->first();

        // 3. Buat user baru di database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role_id' => $role->id,
            // Kolom 'approve' otomatis bernilai 'false' sesuai default di migrasi
        ]);

        // 4. Arahkan kembali ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin approval.');
    }

    /**
     * Menangani permintaan login dari user.
     */
    public function login(Request $request)
    {
        // 1. Validasi input email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba lakukan proses autentikasi
        if (Auth::attempt($credentials)) {
            // Jika berhasil, buat ulang sesi untuk keamanan
            $request->session()->regenerate();

            // 3. Cek apakah akun sudah disetujui (approve == true)
            if (auth()->user()->approve) {

                // 4. Cek peran (role) user dan arahkan ke dashboard yang sesuai
                $role = auth()->user()->role->name;

                if ($role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'));
                } elseif ($role === 'gudang') {
                    return redirect()->intended('/gudang/dashboard');
                } elseif ($role === 'sales') {
                    return redirect()->intended('/sales/dashboard');
                } elseif ($role === 'purchasing') {
                    return redirect()->intended('/purchasing/dashboard');
                }

                // Jika role tidak dikenal, logout untuk keamanan
                Auth::logout();
                return redirect('/login');

            } else {
                // Jika akun belum disetujui, logout dan kirim pesan error
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending approval from an administrator.',
                ]);
            }
        }

        // 5. Jika email atau password salah, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Menangani proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}