<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderRequest;

class PurchasingController extends Controller
{
    /**
     * Menampilkan dashboard purchasing dengan semua order request.
     */
    public function index()
    {
        $orderRequests = OrderRequest::with('user')->latest()->get();
        return view('purchasing.dashboard', compact('orderRequests'));
    }

    /**
     * Menampilkan halaman detail untuk mengedit request.
     */
    public function edit(OrderRequest $orderRequest)
    {
        return view('purchasing.edit', compact('orderRequest'));
    }

    /**
     * Memproses update harga dan jumlah order.
     */
    public function update(Request $request, OrderRequest $orderRequest)
    {
        $request->validate([
            'price_per_item' => 'required|numeric|min:0',
            'confirmed_order_quantity' => 'required|integer|min:1',
        ]);

        $orderRequest->update([
            'price_per_item' => $request->price_per_item,
            'confirmed_order_quantity' => $request->confirmed_order_quantity,
        ]);

        return redirect()->route('purchasing.dashboard')->with('success', 'Order details have been updated!');
    }

    /**
     * Memproses update status (pending -> processed -> completed).
     */
    public function updateStatus(Request $request, OrderRequest $orderRequest)
    {
        $newStatus = '';
        if ($orderRequest->status === 'pending') {
            $newStatus = 'processed';
        } elseif ($orderRequest->status === 'processed') {
            $newStatus = 'completed';
        }

        if ($newStatus) {
            $orderRequest->update(['status' => $newStatus]);
            return redirect()->route('purchasing.dashboard')->with('success', 'Order status updated to ' . $newStatus);
        }

        return redirect()->route('purchasing.dashboard')->with('error', 'Cannot update status.');
    }
}