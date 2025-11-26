<div class="py-6">
    <h1 class="text-4xl font-bold text-[#B9CF32] mb-2">Dashboard Mitra</h1>
    <p class="text-gray-600 mb-8">Kelola informasi GOR/Venue Anda di sini.</p>
    
    <?php 
    if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $this->session->flashdata('success'); ?></span>
        </div>
    <?php endif; 
    if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $this->session->flashdata('error'); ?></span>
        </div>
    <?php endif; 
    ?>

    <!-- ============================================== -->
    <!-- BAGIAN 1: DETAIL VENUE UTAMA -->
    <!-- ============================================== -->
    <div class="bg-white shadow-2xl rounded-xl border border-gray-100 p-8 mb-12">
        
        <!-- HEADER DAN TOMBOL AKSI VENUE -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-4">
            <h2 class="text-3xl font-bold text-[#926699]"><?php echo html_escape($venue['venue_name']); ?></h2>
            <div class="mt-3 md:mt-0 space-x-3 flex">
                <a href="<?php echo site_url('mitra/edit_venue'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-lg shadow-md hover:bg-indigo-600 transition duration-150">
                    <i class="fas fa-edit"></i> Edit Venue Detail
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Kolom Kiri: Foto dan Deskripsi -->
            <div class="md:col-span-2 space-y-6">
                
                <!-- Foto Profil Venue -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Foto Utama Venue</h3>
                    <?php 
                    $img_src = base_url($venue['link_profile_img']);
                    // Cek jika link_profile_img adalah placeholder
                    if ($venue['link_profile_img'] == 'placeholder.jpg' || empty($venue['link_profile_img'])) {
                        $img_src = "https://placehold.co/800x400/926699/ffffff?text=FOTO+VENUE+BELUM+DIUPLOAD";
                    }
                    ?>
                    <img src="<?php echo $img_src; ?>" 
                         alt="Foto Profil Venue <?php echo html_escape($venue['venue_name']); ?>" 
                         class="w-full h-auto object-cover rounded-xl shadow-lg border border-gray-200">
                </div>

                <!-- Deskripsi -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?php echo html_escape($venue['description']); ?></p>
                </div>
            </div>

            <!-- Kolom Kanan: Detail Kontak & Waktu -->
            <div class="md:col-span-1 space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Detail Kontak & Waktu</h3>
                
                <!-- ID Mitra -->
                <div>
                    <p class="text-sm font-medium text-gray-500">ID Mitra (User)</p>
                    <p class="text-lg font-bold text-[#926699]"><?php echo html_escape($venue['id_user']); ?></p>
                </div>

                <!-- Jam Operasional -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Jam Operasional</p>
                    <p class="text-lg text-gray-700"><?php echo html_escape($venue['opening_time']); ?> - <?php echo html_escape($venue['closing_time']); ?></p>
                </div>
                
                <!-- Alamat -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Alamat</p>
                    <p class="text-lg text-gray-700"><?php echo html_escape($venue['address']); ?></p>
                </div>

                <!-- Maps URL -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Link Google Maps</p>
                    <a href="<?php echo html_escape($venue['maps_url']); ?>" target="_blank" class="text-blue-500 hover:text-blue-700 truncate block">
                        <?php 
                            // Tampilkan teks link yang lebih pendek
                            echo (strlen($venue['maps_url']) > 30) ? substr(html_escape($venue['maps_url']), 0, 30) . '...' : html_escape($venue['maps_url']);
                        ?>
                    </a>
                </div>
            </div>
        </div>
        
    </div>

    <!-- ============================================== -->
    <!-- BAGIAN 2: LIST COURT/LAPANGAN -->
    <!-- ============================================== -->
    <div class="bg-white shadow-2xl rounded-xl overflow-hidden border border-gray-100">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Daftar Lapangan yang Dimiliki (Courts)</h3>
                <p class="text-sm text-gray-500">Total Lapangan: <?php echo count($courts); ?></p>
            </div>
            <!-- Tombol Tambah Lapangan DIPINDAH ke sini -->
            <a href="<?php echo site_url('mitra/add_court'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-[#B9CF32] rounded-lg shadow-md hover:bg-[#a6bd2e] transition duration-150">
                <i class="fas fa-plus"></i> Tambah Lapangan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            Gambar
                        </th>
                        <!-- PERUBAHAN KRITIS: Menambahkan kolom Nama Lapangan -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Nama Lapangan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Olahraga
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            Harga/Jam
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                            Deskripsi Singkat
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($courts)): ?>
                        <?php $no = 1; foreach ($courts as $court): ?>
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo $no++; // Menampilkan dan menaikkan nomor urut ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php 
                                    $court_img_src = base_url($court['profile_photo']);
                                    // Placeholder jika foto kosong atau tidak valid
                                    if (empty($court['profile_photo']) || !file_exists($court['profile_photo'])) {
                                        $court_img_src = "https://placehold.co/50x50/B9CF32/ffffff?text=FOTO";
                                    }
                                    ?>
                                    <img src="<?php echo $court_img_src; ?>" alt="Court Photo" class="w-12 h-12 object-cover rounded-md border">
                                </td>
                                <!-- PERUBAHAN KRITIS: Menampilkan court_name -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                    <?php echo html_escape($court['court_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo html_escape($court['sport_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">
                                    Rp. <?php echo number_format($court['price_per_hour'], 0, ',', '.'); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                                    <?php echo html_escape($court['description']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                    <a href="<?php echo site_url('mitra/edit_court/' . $court['id_court']); ?>" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                    
                                    <a href="#" 
                                       onclick="confirmDeleteCourt('<?php echo site_url('mitra/delete_court/' . $court['id_court']); ?>', '<?php echo html_escape($court['court_name']); ?>')" 
                                       class="text-red-600 hover:text-red-900 font-medium ml-3">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada lapangan yang ditambahkan. Silakan klik "Tambah Lapangan" di atas.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Akhir Tabel Court -->
    </div>
</div>

<!-- Modal Konfirmasi Hapus Court (Custom UI) -->
<div id="delete-court-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Konfirmasi Penghapusan Lapangan</h3>
        <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus lapangan <strong id="court-name-display"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="document.getElementById('delete-court-modal').classList.add('hidden');" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Batal</button>
            <a id="delete-court-confirm-link" href="#" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Hapus</a>
        </div>
    </div>
</div>

<script>
function confirmDeleteCourt(deleteUrl, courtName) {
    document.getElementById('court-name-display').textContent = '"' + courtName + '"';
    document.getElementById('delete-court-confirm-link').href = deleteUrl;
    document.getElementById('delete-court-modal').classList.remove('hidden');
    document.getElementById('delete-court-modal').classList.add('flex');
}
</script>