<div class="py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Masuk</h1>
    <p class="text-gray-600 mb-6">Kelola booking yang masuk ke venue Anda.</p>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="bg-white shadow overflow-hidden rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Lapangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if(empty($orders)): ?>
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada pesanan masuk.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= html_escape($order['user_name']) ?></div>
                                <div class="text-sm text-gray-500"><?= html_escape($order['user_telp']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= html_escape($order['court_name']) ?></div>
                                <div class="text-sm text-gray-500 font-bold">Rp <?= number_format($order['total_price'],0,',','.') ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M', strtotime($order['booking_date'])) ?><br>
                                <?= $order['start_time'] ?> - <?= $order['end_time'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php 
                                    if($order['status']=='Pending') echo 'bg-yellow-100 text-yellow-800';
                                    elseif($order['status']=='Confirmed') echo 'bg-blue-100 text-blue-800';
                                    elseif($order['status']=='Paid') echo 'bg-purple-100 text-purple-800';
                                    elseif($order['status']=='Completed') echo 'bg-green-100 text-green-800';
                                    elseif(strpos($order['status'], 'Ditolak') !== false) echo 'bg-red-100 text-red-800';
                                    ?>">
                                    <?= $order['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <?php if($order['status'] == 'Pending'): ?>
                                    <!-- Terima -->
                                    <button onclick="openApproveModal(<?= $order['id'] ?>)" class="text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1 rounded-md transition">
                                        Terima
                                    </button>
                                    <!-- Tolak Booking -->
                                    <button onclick="openRejectOrderModal(<?= $order['id'] ?>)" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md transition">
                                        Tolak
                                    </button>

                                <?php elseif($order['status'] == 'Paid'): ?>
                                    <a href="<?= base_url($order['link_payment_prove']) ?>" target="_blank" class="text-blue-600 hover:text-blue-900 underline mr-2">Cek Bukti</a>
                                    <!-- Verifikasi -->
                                    <a href="<?= site_url('Mitra/verify_payment/' . $order['id']) ?>" onclick="return confirm('Verifikasi pembayaran ini valid?')" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md transition font-bold">
                                        Valid
                                    </a>
                                    <!-- Tolak Pembayaran -->
                                    <button onclick="openRejectPaymentModal(<?= $order['id'] ?>)" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md transition">
                                        Tolak
                                    </button>

                                <?php elseif($order['status'] == 'Completed'): ?>
                                    <span class="text-gray-400">Selesai</span>
                                <?php elseif(strpos($order['status'], 'Ditolak') !== false): ?>
                                    <span class="text-red-400">Dibatalkan</span>
                                <?php else: ?>
                                    <span class="text-gray-400">Menunggu User</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Approve & Upload QR (Yang Lama) -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Setujui Booking</h3>
        
        <form action="<?= site_url('Mitra/approve_booking') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" id="approveBookingId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload QR Code Pembayaran</label>
                <input type="file" name="qr_code" required class="block w-full text-sm border border-gray-300 rounded-md p-2">
                <p class="text-xs text-gray-500 mt-1">User akan scan QR ini untuk membayar.</p>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#B9CF32] text-white rounded-md">Kirim QR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tolak Pesanan (Pending -> Ditolak) -->
<div id="rejectOrderModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold text-red-600 mb-4">Tolak Pesanan Baru</h3>
        <p class="text-sm text-gray-600 mb-4">Pilih alasan penolakan untuk memberitahu User.</p>
        
        <form action="<?= site_url('Mitra/reject_booking') ?>" method="POST">
            <input type="hidden" name="booking_id" id="rejectOrderBookingId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan:</label>
                <select name="reject_reason" class="w-full border border-gray-300 rounded-md p-2 focus:ring-red-500 focus:border-red-500">
                    <option value="Ditolak: jadwal bentrok dengan booking offline">Jadwal bentrok dengan booking offline</option>
                    <option value="Ditolak: tanggal termasuk hari libur operasional">Tanggal termasuk hari libur operasional</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('rejectOrderModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Tolak Pesanan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tolak Pembayaran (Paid -> Ditolak) -->
<div id="rejectPaymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold text-red-600 mb-4">Tolak Bukti Pembayaran</h3>
        <p class="text-sm text-gray-600 mb-4">Bukti pembayaran tidak sesuai? Pilih alasannya.</p>
        
        <form action="<?= site_url('Mitra/reject_booking') ?>" method="POST">
            <input type="hidden" name="booking_id" id="rejectPaymentBookingId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan:</label>
                <select name="reject_reason" class="w-full border border-gray-300 rounded-md p-2 focus:ring-red-500 focus:border-red-500">
                    <option value="Ditolak: bukti pembayaran tidak valid/palsu">Bukti pembayaran tidak valid/palsu</option>
                    <option value="Ditolak: nominal pembayaran tidak sesuai">Nominal pembayaran tidak sesuai</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('rejectPaymentModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Tolak Bukti</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal(id) {
        document.getElementById('approveBookingId').value = id;
        document.getElementById('approveModal').classList.remove('hidden');
    }

    function openRejectOrderModal(id) {
        document.getElementById('rejectOrderBookingId').value = id;
        document.getElementById('rejectOrderModal').classList.remove('hidden');
    }

    function openRejectPaymentModal(id) {
        document.getElementById('rejectPaymentBookingId').value = id;
        document.getElementById('rejectPaymentModal').classList.remove('hidden');
    }
</script>