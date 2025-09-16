<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderRequest;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    /**
     * Menampilkan dashboard sales beserta daftar request yang pernah dibuat.
     */
    public function index()
    {
        // Ambil hanya request yang dibuat oleh user sales yang sedang login
        $orderRequests = OrderRequest::where('user_id', Auth::id())->latest()->get();

        return view('sales.dashboard', compact('orderRequests'));
    }

    /**
     * Menyimpan permintaan barang baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data dari form
        $request->validate([
            'item_name' => 'required|string|max:255',
            'current_stock' => 'required|integer|min:0',
            'required_stock' => 'required|integer|min:0',
            'order_quantity' => 'required|integer|min:1',
        ]);

        // Buat request baru
        OrderRequest::create([
            'user_id' => Auth::id(), // ID user sales yang sedang login
            'item_name' => $request->item_name,
            'current_stock' => $request->current_stock,
            'required_stock' => $request->required_stock,
            'order_quantity' => $request->order_quantity,
            // Status otomatis 'pending' sesuai default di migrasi
        ]);

        return redirect()->route('sales.dashboard')->with('success', 'Order request has been submitted successfully!');
    }
}