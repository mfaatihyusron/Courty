<!-- BANNER SECTION -->
<section class="relative h-64 overflow-hidden shadow-md">
    <!-- Background Image (Pemain melihat lapangan) -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://reezkypradata.com/wp-content/uploads/2021/01/Contoh-Shutterstock.jpg');">
        <div class="absolute inset-0 bg-gray-900/70"></div> <!-- Overlay Ungu Gradient -->
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
        <h1 class="text-4xl font-extrabold text-white mb-2">Pesanan Saya</h1>
        <p class="text-lg text-purple-100 max-w-xl">
            Lihat riwayat booking, status pembayaran, dan tiket masuk lapangan Anda.
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
        <?php if (empty($orders)): ?>
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="bg-gray-100 p-4 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-500 max-w-md mb-6">Anda belum melakukan booking lapangan apapun. Mulai cari lapangan sekarang!</p>
                <a href="<?= site_url('App/venue') ?>" class="px-6 py-2.5 bg-[#B9CF32] text-white font-bold rounded-lg shadow hover:bg-[#a6bd2e] transition">
                    Cari Lapangan
                </a>
            </div>
        <?php else: ?>
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-700">Daftar Riwayat Booking</h2>
            </div>
            <ul class="divide-y divide-gray-100">
                <?php foreach ($orders as $order): ?>
                    <li class="p-6 hover:bg-gray-50 transition duration-150">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            
                            <!-- Info Order -->
                            <div class="flex-grow">
                                <div class="flex items-center flex-wrap gap-2 mb-1">
                                    <h3 class="text-lg font-bold text-[#926699]">
                                        <?= html_escape($order['venue_name']) ?>
                                    </h3>
                                    <!-- Badge Status -->
                                    <?php 
                                    $status_class = '';
                                    $status_label = $order['status'];
                                    
                                    if($order['status'] == 'Pending') {
                                        $status_class = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                        $status_label = 'Menunggu Konfirmasi';
                                    } elseif($order['status'] == 'Confirmed') {
                                        $status_class = 'bg-blue-100 text-blue-800 border border-blue-200';
                                        $status_label = 'Siap Bayar';
                                    } elseif($order['status'] == 'Paid') {
                                        $status_class = 'bg-purple-100 text-purple-800 border border-purple-200';
                                        $status_label = 'Verifikasi Pembayaran';
                                    } elseif($order['status'] == 'Completed') {
                                        $status_class = 'bg-green-100 text-green-800 border border-green-200';
                                        $status_label = 'Selesai';
                                    } elseif(strpos($order['status'], 'Ditolak') !== false) {
                                        $status_class = 'bg-red-100 text-red-800 border border-red-200';
                                    }
                                    ?>
                                    <span class="px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide rounded-full <?= $status_class ?>">
                                        <?= $status_label ?>
                                    </span>
                                </div>
                                <p class="text-gray-700 font-medium"><?= html_escape($order['court_name']) ?> <span class="text-gray-400 mx-1">•</span> <?= html_escape($order['sport_name']) ?></p>
                                <div class="flex items-center text-sm text-gray-500 mt-2">
                                    <span class="flex items-center mr-4">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <?= date('d M Y', strtotime($order['booking_date'])) ?>
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <?= $order['start_time'] ?> - <?= $order['end_time'] ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Harga & Aksi -->
                            <div class="text-right flex flex-col items-end min-w-[150px]">
                                <p class="text-xs text-gray-500 uppercase">Total Biaya</p>
                                <p class="text-xl font-bold text-gray-900 mb-3">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></p>
                                
                                <!-- LOGIKA TOMBOL -->
                                <?php if ($order['status'] == 'Pending'): ?>
                                    <span class="text-xs text-gray-500 italic bg-gray-100 px-2 py-1 rounded">Menunggu Mitra...</span>
                                
                                <?php elseif ($order['status'] == 'Confirmed'): ?>
                                    <!-- Tombol Bayar -->
                                    <button onclick="openPaymentModal(<?= $order['id'] ?>, '<?= base_url($order['link_qr']) ?>')" 
                                            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg shadow hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Bayar Sekarang
                                    </button>

                                <?php elseif ($order['status'] == 'Paid'): ?>
                                    <button onclick='openDetailModal(<?= json_encode($order) ?>)' class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Bukti
                                    </button>

                                <?php elseif ($order['status'] == 'Completed'): ?>
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="flex items-center text-green-600 font-bold text-sm">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Transaksi Selesai
                                        </div>
                                        <button onclick='openDetailModal(<?= json_encode($order) ?>)' 
                                                class="text-sm font-medium text-gray-600 hover:text-[#926699] border-b border-dashed border-gray-400 hover:border-[#926699]">
                                            Lihat Rincian
                                        </button>
                                    </div>
                                    
                                <?php elseif (strpos($order['status'], 'Ditolak') !== false): ?>
                                    <span class="text-red-500 text-xs font-medium bg-red-50 px-2 py-1 rounded border border-red-100">
                                        <?= $order['status'] ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Upload Pembayaran (Existing) -->
<div id="paymentModal" class="fixed inset-0 bg-gray-900/60 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm flex items-center justify-center">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-[#926699] p-4 text-center">
            <h3 class="text-lg font-bold text-white">Pembayaran</h3>
            <p class="text-purple-200 text-xs">Selesaikan pembayaran untuk mengamankan jadwal</p>
        </div>
        
        <div class="p-6">
            <div class="mb-6 text-center">
                <p class="text-sm text-gray-600 mb-3 font-medium">Scan QR Code di bawah ini:</p>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-2 inline-block">
                    <img id="modalQrImage" src="" alt="QR Code" class="w-48 h-48 object-contain rounded-lg">
                </div>
            </div>

            <form action="<?= site_url('Booking/upload_payment') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="booking_id" id="modalBookingId">
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Upload Bukti Transfer</label>
                    <input type="file" name="payment_proof" required 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-[#926699] hover:file:bg-purple-100 cursor-pointer border border-gray-200 rounded-lg">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, PDF. Max 2MB.</p>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('paymentModal').classList.add('hidden')" class="flex-1 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-[#926699] text-white font-bold rounded-xl hover:bg-[#7d5583] transition shadow-lg">Kirim Bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Rincian Pesanan (Existing) -->
<div id="detailModal" class="fixed inset-0 bg-gray-900/60 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm flex items-center justify-center">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 my-8">
        <div class="flex justify-between items-center border-b p-5">
            <h3 class="text-xl font-bold text-gray-800">Rincian Pesanan</h3>
            <button onclick="document.getElementById('detailModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="p-6 space-y-5 overflow-y-auto max-h-[80vh]">
            <!-- Detail Utama -->
            <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
                <p class="text-xs text-purple-600 uppercase tracking-wide font-bold mb-1">Venue & Lapangan</p>
                <p class="text-lg font-bold text-gray-900" id="detailVenueName"></p>
                <p class="text-gray-600 text-sm" id="detailCourtName"></p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Tanggal</p>
                    <p class="font-semibold text-gray-900" id="detailDate"></p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Jam</p>
                    <p class="font-semibold text-gray-900" id="detailTime"></p>
                </div>
            </div>

            <div class="border-t border-dashed border-gray-300 pt-4">
                <div class="flex justify-between items-center mb-1">
                    <p class="text-gray-600 font-medium">Total Pembayaran</p>
                    <p class="text-xl font-extrabold text-[#B9CF32]" id="detailPrice"></p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-gray-500 text-sm">Status</p>
                    <span class="text-sm font-medium px-2 py-0.5 bg-gray-100 rounded" id="detailStatus"></span>
                </div>
            </div>

            <!-- Bukti Bayar Section -->
            <div>
                <p class="text-sm font-bold text-gray-800 mb-3 border-b pb-1 inline-block">Bukti Pembayaran</p>
                <div class="border rounded-xl overflow-hidden bg-gray-50 flex justify-center items-center min-h-[150px] relative group">
                    <img id="detailPaymentProof" src="" alt="Belum ada bukti bayar" class="w-full h-auto object-contain hidden">
                    
                    <p id="noProofText" class="text-gray-400 text-sm italic hidden p-4">Tidak ada bukti pembayaran terlampir.</p>
                    
                    <!-- Hover overlay for download -->
                    <a id="downloadProofLink" href="#" target="_blank" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200 hidden">
                        <span class="text-white font-semibold text-sm flex items-center bg-black/50 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat Penuh
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="p-5 border-t bg-gray-50 rounded-b-2xl">
            <button onclick="document.getElementById('detailModal').classList.add('hidden')" class="w-full py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-bold hover:bg-gray-100 transition shadow-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Modal Upload (Existing)
    function openPaymentModal(id, qrLink) {
        document.getElementById('modalBookingId').value = id;
        document.getElementById('modalQrImage').src = qrLink;
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    // Modal Detail (Existing)
    function openDetailModal(order) {
        document.getElementById('detailVenueName').textContent = order.venue_name;
        document.getElementById('detailCourtName').textContent = order.court_name + ' (' + order.sport_name + ')';
        
        const dateObj = new Date(order.booking_date);
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        document.getElementById('detailDate').textContent = dateObj.toLocaleDateString('id-ID', options);
        
        document.getElementById('detailTime').textContent = order.start_time + ' - ' + order.end_time;
        document.getElementById('detailPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(order.total_price);
        document.getElementById('detailStatus').textContent = order.status;

        const imgEl = document.getElementById('detailPaymentProof');
        const linkEl = document.getElementById('downloadProofLink');
        const noProofText = document.getElementById('noProofText');

        if (order.link_payment_prove) {
            // Path fix
            const basePath = '<?php echo base_url(); ?>';
            const fullPath = basePath + order.link_payment_prove;

            imgEl.src = fullPath;
            imgEl.classList.remove('hidden');
            linkEl.href = fullPath;
            linkEl.classList.remove('hidden');
            noProofText.classList.add('hidden');
        } else {
            imgEl.classList.add('hidden');
            linkEl.classList.add('hidden');
            noProofText.classList.remove('hidden');
        }

        document.getElementById('detailModal').classList.remove('hidden');
    }
</script>