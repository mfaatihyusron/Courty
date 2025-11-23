<div class="py-6">
    <h1 class="text-4xl font-bold text-[#B9CF32] mb-2">Dashboard Mitra</h1>
    <p class="text-gray-600 mb-8">Kelola informasi GOR/Venue Anda di sini.</p>

    <div class="bg-white shadow-2xl rounded-xl border border-gray-100 p-8">
        
        <!-- HEADER DAN TOMBOL AKSI -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-4">
            <h2 class="text-3xl font-bold text-[#926699]"><?php echo html_escape($venue['venue_name']); ?></h2>
            <div class="mt-3 md:mt-0 space-x-3 flex">
                <a href="<?php echo site_url('praktek/edit_venue'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-lg shadow-md hover:bg-indigo-600 transition duration-150">
                    <i class="fas fa-edit"></i> Edit Venue
                </a>
                <a href="<?php echo site_url('praktek/add_court'); ?>" class="px-4 py-2 text-sm font-semibold text-white bg-[#B9CF32] rounded-lg shadow-md hover:bg-[#a6bd2e] transition duration-150">
                    <i class="fas fa-plus"></i> Tambah Lapangan
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
                    if ($venue['link_profile_img'] == 'placeholder.jpg') {
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
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Detail Kontak & Lokasi</h3>
                
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

                <!-- Koordinat -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Koordinat (Lat, Lon)</p>
                    <p class="text-lg text-gray-700"><?php echo html_escape($venue['coordinate']); ?></p>
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
</div>