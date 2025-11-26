<div class="py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Masuk</h1>
    <p class="text-gray-600 mb-6">Kelola booking yang masuk ke venue Anda.</p>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= $this->session->flashdata('success') ?></div>
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
                                    ?>">
                                    <?= $order['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if($order['status'] == 'Pending'): ?>
                                    <button onclick="openApproveModal(<?= $order['id'] ?>)" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md">
                                        Terima & Upload QR
                                    </button>
                                <?php elseif($order['status'] == 'Paid'): ?>
                                    <a href="<?= base_url($order['link_payment_prove']) ?>" target="_blank" class="text-blue-600 hover:text-blue-900 underline mr-2">Cek Bukti</a>
                                    <a href="<?= site_url('Mitra/verify_payment/' . $order['id']) ?>" onclick="return confirm('Verifikasi pembayaran ini valid?')" class="text-green-600 hover:text-green-900 font-bold">
                                        Verifikasi
                                    </a>
                                <?php elseif($order['status'] == 'Completed'): ?>
                                    <span class="text-gray-400">Selesai</span>
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

<!-- Modal Approve & Upload QR -->
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

<script>
    function openApproveModal(id) {
        document.getElementById('approveBookingId').value = id;
        document.getElementById('approveModal').classList.remove('hidden');
    }
</script>