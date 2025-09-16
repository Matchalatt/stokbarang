<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchasing Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .aurora-gradient { 
            background: linear-gradient(-45deg, #0d324d, #7f5a83, #2c5364, #1c2e4a); 
            background-size: 400% 400%; 
            animation: aurora 20s ease infinite; 
        }
        @keyframes aurora { 
            0% { background-position: 0% 50%; } 
            50% { background-position: 100% 50%; } 
            100% { background-position: 0% 50%; } 
        }
        
        /* CSS untuk animasi modal yang halus dengan backdrop blur */
        #edit-modal {
            transition: all 0.3s ease-in-out;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        
        #edit-modal.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        #edit-modal.show {
            opacity: 1;
            visibility: visible;
        }
        
        #edit-modal .modal-content {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform: scale(0.7) translateY(-50px);
        }
        
        #edit-modal.show .modal-content {
            transform: scale(1) translateY(0);
        }
        
        /* Animasi fade in untuk background */
        @keyframes fadeInBackdrop {
            from {
                background-color: rgba(0, 0, 0, 0);
            }
            to {
                background-color: rgba(0, 0, 0, 0.5);
            }
        }
        
        #edit-modal.show {
            animation: fadeInBackdrop 0.3s ease-out forwards;
        }
    </style>
</head>
<body class="antialiased aurora-gradient text-gray-200">
    
    <header class="bg-gray-900/30 backdrop-blur-md sticky top-0 z-20 border-b border-gray-700">
        <nav class="container mx-auto px-4 lg:px-6 py-3 flex justify-between items-center">
            <a href="#" class="flex items-center text-xl font-bold text-white tracking-wider">
                <svg class="w-7 h-7 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span>Purchasing Panel</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5">
                    Logout
                </button>
            </form>
        </nav>
    </header>
    
    <main class="container mx-auto mt-8 mb-10 px-4">
        <div class="w-full p-6 sm:p-8 bg-gray-900/60 rounded-xl shadow-2xl backdrop-blur-md border border-gray-700">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-6">All Order Requests</h1>
            @if (session('success'))
                <div class="bg-cyan-900/50 border border-cyan-500 text-cyan-200 px-4 py-3 rounded-lg mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-700">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Item Name</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Requested By</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Price</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Total Price</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderRequests as $request)
                            <tr class="border-b border-gray-800">
                                <td class="px-5 py-4 text-white">{{ $request->item_name }}</td>
                                <td class="px-5 py-4 text-gray-400">{{ $request->user->name }}</td>
                                <td class="px-5 py-4 text-white">Rp {{ number_format($request->price_per_item ?? 0, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-white">Rp {{ number_format(($request->price_per_item ?? 0) * ($request->confirmed_order_quantity ?? $request->order_quantity), 0, ',', '.') }}</td>
                                <td class="px-5 py-4">
                                    @if($request->status == 'pending')<span class="px-3 py-1 text-xs font-semibold text-yellow-200 bg-yellow-900/50 rounded-full">Pending</span>
                                    @elseif($request->status == 'processed')<span class="px-3 py-1 text-xs font-semibold text-blue-200 bg-blue-900/50 rounded-full">Processed</span>
                                    @else<span class="px-3 py-1 text-xs font-semibold text-green-200 bg-green-900/50 rounded-full">Completed</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 flex items-center gap-2">
                                    <button type="button" class="open-modal-button text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-xs px-3 py-2"
                                            data-item-name="{{ $request->item_name }}"
                                            data-requester-name="{{ $request->user->name }}"
                                            data-request-date="{{ $request->created_at->format('d M Y') }}"
                                            data-current-stock="{{ $request->current_stock }}"
                                            data-required-stock="{{ $request->required_stock }}"
                                            data-requested-order="{{ $request->order_quantity }}"
                                            data-price-per-item="{{ $request->price_per_item ?? '' }}"
                                            data-confirmed-quantity="{{ $request->confirmed_order_quantity ?? $request->order_quantity }}"
                                            data-update-url="{{ route('purchasing.order-requests.update', $request->id) }}">
                                        Detail
                                    </button>

                                    @if($request->status !== 'completed')
                                    <form action="{{ route('purchasing.order-requests.update-status', $request->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-white {{ $request->status === 'pending' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} font-medium rounded-lg text-xs px-3 py-2">
                                            {{ $request->status === 'pending' ? 'Process' : 'Complete' }}
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-5 text-center text-gray-500">No requests found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- MODAL DENGAN BACKGROUND TRANSPARAN DAN ANIMASI YANG DIPERBAIKI --}}
    <div id="edit-modal" class="fixed inset-0 z-30 flex items-center justify-center p-4 hidden bg-black/50">
        <div class="modal-content w-full max-w-lg bg-gray-900/90 rounded-xl shadow-2xl backdrop-blur-md border border-gray-700/50">
            <div class="p-6 sm:p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 id="modal-title" class="text-2xl font-bold text-white mb-1">Order Detail: Nama Barang</h2>
                        <p id="modal-subtitle" class="text-gray-400 text-sm">Requested by Nama Sales on Tanggal</p>
                    </div>
                    <button type="button" id="close-modal-button" class="p-1 -m-1 text-2xl text-gray-400 hover:text-white transition-colors duration-200">&times;</button>
                </div>

                <div class="mt-6 mb-6 border-b border-gray-700/50 pb-6">
                    <h3 class="text-lg font-semibold text-cyan-400 mb-4">Initial Request Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div class="bg-gray-800/50 rounded-lg p-3 backdrop-blur-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">Current Stock</p>
                            <p id="modal-current-stock" class="text-lg font-semibold text-white mt-1"></p>
                        </div>
                        <div class="bg-gray-800/50 rounded-lg p-3 backdrop-blur-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">Required Stock</p>
                            <p id="modal-required-stock" class="text-lg font-semibold text-white mt-1"></p>
                        </div>
                        <div class="bg-gray-800/50 rounded-lg p-3 backdrop-blur-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">Requested Order</p>
                            <p id="modal-requested-order" class="text-lg font-semibold text-white mt-1"></p>
                        </div>
                    </div>
                </div>

                <form id="modal-form" action="" method="POST">
                    @csrf @method('PUT')
                    <h3 class="text-lg font-semibold text-cyan-400 mb-4">Confirmation Form</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="sm:col-span-2">
                            <label for="price_per_item" class="block mb-2 text-sm font-medium text-gray-300">Price per Item (Rp)</label>
                            <input id="modal-price" type="number" step="any" name="price_per_item" class="w-full p-2.5 bg-gray-800/70 border border-gray-600 rounded-md focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-white placeholder-gray-400" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="confirmed_order_quantity" class="block mb-2 text-sm font-medium text-gray-300">Confirmed Order Quantity</label>
                            <input id="modal-quantity" type="number" name="confirmed_order_quantity" class="w-full p-2.5 bg-gray-800/70 border border-gray-600 rounded-md focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 text-white placeholder-gray-400" required>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-8">
                        <button type="submit" class="w-full py-2.5 px-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-cyan-500 focus:outline-none">
                            Save Changes
                        </button>
                        <button type="button" id="cancel-button" class="w-full text-center py-2.5 px-4 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-gray-500 focus:outline-none">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK MENGONTROL ANIMASI MODAL YANG DIPERBAIKI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('edit-modal');
            const modalContent = modal.querySelector('.modal-content');
            const openModalButtons = document.querySelectorAll('.open-modal-button');
            const closeModalButton = document.getElementById('close-modal-button');
            const cancelButton = document.getElementById('cancel-button');

            const openModal = (e) => {
                const button = e.currentTarget;
                
                // Isi modal dengan data dari tombol yang diklik
                document.getElementById('modal-title').textContent = `Order Detail: ${button.dataset.itemName}`;
                document.getElementById('modal-subtitle').textContent = `Requested by ${button.dataset.requesterName} on ${button.dataset.requestDate}`;
                document.getElementById('modal-current-stock').textContent = button.dataset.currentStock;
                document.getElementById('modal-required-stock').textContent = button.dataset.requiredStock;
                document.getElementById('modal-requested-order').textContent = button.dataset.requestedOrder;
                document.getElementById('modal-price').value = button.dataset.pricePerItem;
                document.getElementById('modal-quantity').value = button.dataset.confirmedQuantity;
                document.getElementById('modal-form').action = button.dataset.updateUrl;

                // Tampilkan modal dengan animasi yang smooth
                modal.classList.remove('hidden');
                // Force reflow untuk memastikan transisi berjalan
                modal.offsetHeight;
                modal.classList.add('show');
                
                // Prevent body scroll when modal is open
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                // Sembunyikan modal dengan animasi
                modal.classList.remove('show');
                
                // Restore body scroll
                document.body.style.overflow = '';
                
                // Hide modal setelah animasi selesai
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300); // Durasi sesuai dengan CSS transition
            };

            // Event listeners
            openModalButtons.forEach(button => {
                button.addEventListener('click', openModal);
            });
            
            closeModalButton.addEventListener('click', closeModal);
            cancelButton.addEventListener('click', closeModal);
            
            // Tutup modal jika user mengklik area di luar konten modal
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            // Tutup modal dengan tombol ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.classList.contains('show')) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>