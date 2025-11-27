<!-- BANNER SECTION -->
<section class="relative h-64 overflow-hidden shadow-md">
    <!-- Background Image (Manajemen/Clipboard) -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=2032&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-emerald-900/80"></div> <!-- Overlay Hijau/Emerald Gelap -->
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center text-center sm:text-left">
        <h1 class="text-4xl font-extrabold text-white mb-2">Order Masuk</h1>
        <p class="text-lg text-emerald-100 max-w-xl">
            Kelola pesanan yang masuk, verifikasi pembayaran, dan atur jadwal lapangan Anda secara real-time.
        </p>
    </div>
</section>

<!-- KONTEN UTAMA -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-8 relative z-10">

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-6"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100 min-h-[300px]">
        <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="font-bold text-gray-700 text-lg">Daftar Permintaan Booking</h2>
            <div class="text-sm text-gray-500">Total: <?= count($orders) ?> Order</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pemesan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Lapangan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(empty($orders)): ?>
                        <tr><td colspan="5" class="px-6 py-16 text-center text-gray-500 italic">Belum ada pesanan masuk saat ini.</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900"><?= html_escape($order['user_name']) ?></div>
                                    <div class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <?= html_escape($order['user_telp']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium"><?= html_escape($order['court_name']) ?></div>
                                    <div class="text-sm font-bold text-[#B9CF32] mt-1">Rp <?= number_format($order['total_price'],0,',','.') ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="font-medium"><?= date('d M Y', strtotime($order['booking_date'])) ?></div>
                                    <div class="text-xs text-gray-500 mt-1 bg-gray-100 inline-block px-2 py-0.5 rounded">
                                        <?= $order['start_time'] ?> - <?= $order['end_time'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php 
                                    $status_class = '';
                                    $status_label = $order['status'];
                                    
                                    if($order['status']=='Pending') {
                                        $status_class = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                        $status_label = 'Perlu Konfirmasi';
                                    } elseif($order['status']=='Confirmed') {
                                        $status_class = 'bg-blue-100 text-blue-800 border border-blue-200';
                                        $status_label = 'Menunggu Bayar';
                                    } elseif($order['status']=='Paid') {
                                        $status_class = 'bg-purple-100 text-purple-800 border border-purple-200';
                                        $status_label = 'Verifikasi Bukti';
                                    } elseif($order['status']=='Completed') {
                                        $status_class = 'bg-green-100 text-green-800 border border-green-200';
                                        $status_label = 'Selesai';
                                    } elseif(strpos($order['status'], 'Ditolak') !== false) {
                                        $status_class = 'bg-red-100 text-red-800 border border-red-200';
                                        $status_label = 'Ditolak';
                                    }
                                    ?>
                                    <span class="px-2.5 py-0.5 text-xs font-bold uppercase rounded-full <?= $status_class ?>">
                                        <?= $status_label ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex flex-col gap-2 w-32">
                                    <?php if($order['status'] == 'Pending'): ?>
                                        <button onclick="openApproveModal(<?= $order['id'] ?>)" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded-lg shadow-sm text-xs font-bold transition">
                                            Terima
                                        </button>
                                        <button onclick="openRejectOrderModal(<?= $order['id'] ?>)" class="w-full text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            Tolak
                                        </button>

                                    <?php elseif($order['status'] == 'Paid'): ?>
                                        <a href="<?= base_url($order['link_payment_prove']) ?>" target="_blank" class="text-center text-blue-600 hover:text-blue-800 text-xs underline font-medium mb-1 block">Lihat Bukti</a>
                                        <a href="<?= site_url('Mitra/verify_payment/' . $order['id']) ?>" onclick="return confirm('Pastikan dana sudah masuk mutasi rekening Anda. Lanjutkan?')" class="w-full text-center text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg shadow-sm text-xs font-bold transition">
                                            Valid
                                        </a>
                                        <button onclick="openRejectPaymentModal(<?= $order['id'] ?>)" class="w-full text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold transition mt-1">
                                            Tidak Valid
                                        </button>

                                    <?php elseif($order['status'] == 'Completed'): ?>
                                        <span class="text-gray-400 text-xs text-center italic">Archived</span>
                                    <?php elseif(strpos($order['status'], 'Ditolak') !== false): ?>
                                        <span class="text-red-300 text-xs text-center italic">Closed</span>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs text-center">Menunggu User</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Approve (Upload QR) -->
<div id="approveModal" class="fixed inset-0 bg-gray-900/60 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm flex items-center justify-center">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Terima Pesanan</h3>
            <p class="text-sm text-gray-600 mb-6">Upload QR Code pembayaran untuk dikirim ke pemesan.</p>
            
            <form action="<?= site_url('Mitra/approve_booking') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="booking_id" id="approveBookingId">
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">File QR Code (JPG/PNG)</label>
                    <input type="file" name="qr_code" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg cursor-pointer">
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#B9CF32] text-white font-bold rounded-xl hover:bg-[#a6bd2e] transition shadow-lg">Kirim & Terima</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak Pesanan -->
<div id="rejectOrderModal" class="fixed inset-0 bg-gray-900/60 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm flex items-center justify-center">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6 border-l-8 border-red-500">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tolak Pesanan Baru</h3>
            <p class="text-sm text-gray-600 mb-6">Mengapa pesanan ini tidak bisa diterima?</p>
            
            <form action="<?= site_url('Mitra/reject_booking') ?>" method="POST">
                <input type="hidden" name="booking_id" id="rejectOrderBookingId">
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alasan Penolakan</label>
                    <select name="reject_reason" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white">
                        <option value="Ditolak: jadwal bentrok dengan booking offline">Jadwal bentrok dengan booking offline</option>
                        <option value="Ditolak: tanggal termasuk hari libur operasional">Tanggal termasuk hari libur operasional</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('rejectOrderModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg">Tolak Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak Pembayaran -->
<div id="rejectPaymentModal" class="fixed inset-0 bg-gray-900/60 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm flex items-center justify-center">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6 border-l-8 border-orange-500">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tolak Bukti Pembayaran</h3>
            <p class="text-sm text-gray-600 mb-6">Apa masalah pada bukti pembayaran ini?</p>
            
            <form action="<?= site_url('Mitra/reject_booking') ?>" method="POST">
                <input type="hidden" name="booking_id" id="rejectPaymentBookingId">
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alasan Penolakan</label>
                    <select name="reject_reason" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                        <option value="Ditolak: bukti pembayaran tidak valid/palsu">Bukti pembayaran tidak valid/palsu</option>
                        <option value="Ditolak: nominal pembayaran tidak sesuai">Nominal pembayaran tidak sesuai</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('rejectPaymentModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg">Tolak Bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openApproveModal(id) {
        document.getElementById('approveBookingId').value = id;
        document.getElementById('approveModal').classList.remove('hidden');
        document.getElementById('approveModal').classList.add('flex');
    }

    function openRejectOrderModal(id) {
        document.getElementById('rejectOrderBookingId').value = id;
        document.getElementById('rejectOrderModal').classList.remove('hidden');
        document.getElementById('rejectOrderModal').classList.add('flex');
    }

    function openRejectPaymentModal(id) {
        document.getElementById('rejectPaymentBookingId').value = id;
        document.getElementById('rejectPaymentModal').classList.remove('hidden');
        document.getElementById('rejectPaymentModal').classList.add('flex');
    }
</script>