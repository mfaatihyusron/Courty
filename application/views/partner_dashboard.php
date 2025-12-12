<!-- BANNER SECTION -->
<section class="relative h-80 overflow-hidden shadow-md">
    <!-- Background Image (Venue/GOR) -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://recreation.ucsb.edu/sites/default/files/2024-12/F24_Photos_Facility_LockerRoom_Web-12.jpg');">
        <div class="absolute inset-0 bg-gray-900/70"></div> <!-- Overlay Gelap -->
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col items-center justify-center text-center">
        <span class="text-[#B9CF32] font-bold tracking-wider uppercase text-sm mb-2">Mitra Area</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-3">
            Dashboard <span class="text-[#B9CF32]">Mitra</span>
        </h1>
        <p class="text-lg text-gray-200 max-w-2xl">
            Kelola profil venue, lapangan, dan ketersediaan jadwal Anda dengan mudah.
        </p>
    </div>
</section>

<!-- KONTEN UTAMA -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-8 relative z-10">
    
    <!-- Flash Messages -->
    <?php 
    if ($this->session->flashdata('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-6" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.59l4.3-4.3 1.4 1.41L9 14.41l-3.7-3.7 1.4-1.42z"/></svg></div>
                <div><?php echo $this->session->flashdata('success'); ?></div>
            </div>
        </div>
    <?php endif; 
    if ($this->session->flashdata('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm mb-6" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM10 9l-3.5-3.5 1.42-1.42L10 6.18l2.08-2.1 1.42 1.42L10 9zm0 2l3.5 3.5-1.42 1.42L10 13.82l-2.08 2.1-1.42-1.42L10 11z"/></svg></div>
                <div><?php echo $this->session->flashdata('error'); ?></div>
            </div>
        </div>
    <?php endif; 
    ?>

    <!-- BAGIAN 1: DETAIL VENUE UTAMA -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-10 border border-gray-100">
        <!-- Header Card -->
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo html_escape($venue['venue_name']); ?></h2>
                <p class="text-sm text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i> <?php echo html_escape($venue['address']); ?></p>
            </div>
            <div class="mt-4 md:mt-0">
                <!-- PERBAIKAN 1: Tombol Edit Profil Venue menggunakan bg-action (#347048) -->
                <a href="<?php echo site_url('mitra/edit_venue'); ?>" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-action rounded-lg hover:bg-[#2e5d3c] transition shadow-md">
                    <i class="fas fa-edit mr-2"></i> Edit Profil Venue
                </a>
            </div>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Kolom Kiri: Foto dan Deskripsi -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Foto Profil Venue -->
                    <div class="relative group">
                        <?php 
                        $img_src = base_url($venue['link_profile_img']);
                        if ($venue['link_profile_img'] == 'placeholder.jpg' || empty($venue['link_profile_img'])) {
                            $img_src = "https://placehold.co/800x400/e2e8f0/94a3b3?text=Foto+Venue";
                        }
                        ?>
                        <img src="<?php echo $img_src; ?>" 
                             alt="Foto Profil Venue" 
                             class="w-full h-64 object-cover rounded-xl shadow-md">
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#926699]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            Deskripsi Venue
                        </h3>
                        <p class="text-gray-600 leading-relaxed whitespace-pre-wrap bg-gray-50 p-4 rounded-lg border border-gray-100"><?php echo html_escape($venue['description']); ?></p>
                    </div>
                </div>

                <!-- Kolom Kanan: Detail Info -->
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Informasi Operasional</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Jam Buka</p>
                                <p class="text-base font-medium text-gray-900 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <?php echo html_escape($venue['opening_time']); ?> - <?php echo html_escape($venue['closing_time']); ?>
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Lokasi Maps</p>
                                <a href="<?php echo html_escape($venue['maps_url']); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm mt-1 flex items-center font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Buka di Google Maps
                                </a>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Status Akun</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                    Verified Partner
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 2: LIST COURT/LAPANGAN -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Daftar Lapangan (Courts)</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola data lapangan yang tersedia untuk dipesan.</p>
            </div>
            <!-- PERBAIKAN 2: Tombol Tambah Lapangan menggunakan bg-action (#347048) -->
            <a href="<?php echo site_url('mitra/add_court'); ?>" class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-action rounded-lg hover:bg-[#2e5d3c] transition shadow-md">
                <i class="fas fa-plus mr-2"></i> Tambah Lapangan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Foto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lapangan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Olahraga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga/Jam</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($courts)): ?>
                        <?php $no = 1; foreach ($courts as $court): ?>
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $no++; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php 
                                    $court_img = base_url($court['profile_photo']);
                                    if (empty($court['profile_photo']) || !file_exists($court['profile_photo'])) {
                                        $court_img = "https://placehold.co/50x50/e2e8f0/94a3b8?text=IMG";
                                    }
                                    ?>
                                    <img src="<?php echo $court_img; ?>" alt="Foto" class="h-12 w-12 rounded-lg object-cover border border-gray-200">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    <?php echo html_escape($court['court_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?php echo html_escape($court['sport_name']); ?>
                                    </span>
                                </td>
                                <!-- PERBAIKAN 3: Harga/Jam menggunakan warna text-action (#347048) -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-action">
                                    Rp <?php echo number_format($court['price_per_hour'], 0, ',', '.'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-3">
                                    <a href="<?php echo site_url('mitra/edit_court/' . $court['id_court']); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                                    <a href="#" onclick="confirmDeleteCourt('<?php echo site_url('mitra/delete_court/' . $court['id_court']); ?>', '<?php echo html_escape($court['court_name']); ?>')" class="text-red-600 hover:text-red-900 font-semibold">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500 bg-gray-50 italic">
                                Belum ada lapangan yang ditambahkan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus Court -->
<div id="delete-court-modal" class="fixed inset-0 bg-gray-900/50 hidden items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-6 transform transition-all scale-100">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Lapangan?</h3>
        <p class="text-sm text-gray-600 mb-6">Anda yakin ingin menghapus <strong id="court-name-display" class="text-gray-800"></strong>? Tindakan ini permanen.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="document.getElementById('delete-court-modal').classList.add('hidden');" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">Batal</button>
            <a id="delete-court-confirm-link" href="#" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">Ya, Hapus</a>
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