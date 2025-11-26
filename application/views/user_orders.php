<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Pesanan Saya</h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <?php if (empty($orders)): ?>
            <div class="p-6 text-center text-gray-500">Belum ada pesanan.</div>
        <?php else: ?>
            <ul class="divide-y divide-gray-200">
                <?php foreach ($orders as $order): ?>
                    <li class="p-6 hover:bg-gray-50 transition">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            
                            <!-- Info Order -->
                            <div class="mb-4 md:mb-0">
                                <div class="flex items-center">
                                    <h3 class="text-lg font-bold text-[#926699] mr-2">
                                        <?= html_escape($order['venue_name']) ?>
                                    </h3>
                                    <!-- Badge Status -->
                                    <?php 
                                    $status_color = 'bg-gray-100 text-gray-800';
                                    if($order['status'] == 'Pending') $status_color = 'bg-yellow-100 text-yellow-800';
                                    if($order['status'] == 'Confirmed') $status_color = 'bg-blue-100 text-blue-800';
                                    if($order['status'] == 'Paid') $status_color = 'bg-purple-100 text-purple-800';
                                    if($order['status'] == 'Completed') $status_color = 'bg-green-100 text-green-800';
                                    ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $status_color ?>">
                                        <?= $order['status'] ?>
                                    </span>
                                </div>
                                <p class="text-gray-600"><?= html_escape($order['court_name']) ?> (<?= html_escape($order['sport_name']) ?>)</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-calendar mr-1"></i> <?= date('d M Y', strtotime($order['booking_date'])) ?> | 
                                    <i class="fas fa-clock mr-1"></i> <?= $order['start_time'] ?> - <?= $order['end_time'] ?>
                                </p>
                            </div>

                            <!-- Harga & Aksi -->
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900 mb-2">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></p>
                                
                                <!-- LOGIKA TOMBOL -->
                                <?php if ($order['status'] == 'Pending'): ?>
                                    <p class="text-sm text-gray-500 italic">Menunggu Konfirmasi Mitra...</p>
                                
                                <?php elseif ($order['status'] == 'Confirmed'): ?>
                                    <!-- Tombol Bayar (Muncul Modal) -->
                                    <button onclick="openPaymentModal(<?= $order['id'] ?>, '<?= base_url($order['link_qr']) ?>')" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                        Bayar Sekarang
                                    </button>

                                <?php elseif ($order['status'] == 'Paid'): ?>
                                    <p class="text-sm text-indigo-600 font-semibold">Sedang Diverifikasi Mitra</p>
                                    <a href="<?= base_url($order['link_payment_prove']) ?>" target="_blank" class="text-xs text-gray-400 hover:underline">Lihat Bukti Upload</a>

                                <?php elseif ($order['status'] == 'Completed'): ?>
                                    <div class="flex items-center text-green-600 font-bold">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Selesai
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Upload Pembayaran -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Lakukan Pembayaran</h3>
            
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-2">Scan QR Code di bawah ini:</p>
                <img id="modalQrImage" src="" alt="QR Code" class="mx-auto w-48 h-48 object-contain border rounded-md mb-4">
            </div>

            <form action="<?= site_url('Booking/upload_payment') ?>" method="POST" enctype="multipart/form-data" class="mt-4 text-left">
                <input type="hidden" name="booking_id" id="modalBookingId">
                
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Transfer</label>
                <input type="file" name="payment_proof" required 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                
                <div class="mt-5 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('paymentModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Kirim Bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openPaymentModal(id, qrLink) {
        document.getElementById('modalBookingId').value = id;
        document.getElementById('modalQrImage').src = qrLink;
        document.getElementById('paymentModal').classList.remove('hidden');
    }
</script>