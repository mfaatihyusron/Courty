<div class="py-6">
    <!-- Breadcrumb (Simulasi) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
        <a href="<?= site_url('App/index') ?>" class="text-gray-500 hover:text-[#926699]">Home</a> 
        <span class="mx-2 text-gray-400">/</span> 
        <span class="font-medium text-[#926699]"><?php echo html_escape($venue['venue_name']); ?></span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-2xl rounded-xl overflow-hidden p-6 md:p-10 border border-gray-100">
            
            <!-- HEADER VENUE & FOTO UTAMA -->
            <div class="mb-8">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-2"><?php echo html_escape($venue['venue_name']); ?></h1>
                <p class="text-xl text-gray-600 mb-6">GOR / Venue terbaik untuk aktivitas olahraga Anda.</p>
                
                <?php 
                $img_src = base_url($venue['link_profile_img']);
                if (empty($venue['link_profile_img']) || $venue['link_profile_img'] == 'placeholder.jpg') {
                    $img_src = "https://placehold.co/1200x500/926699/FFFFFF?text=FOTO+UTAMA+VENUE";
                }
                ?>
                <img src="<?php echo $img_src; ?>" alt="Foto Utama <?php echo html_escape($venue['venue_name']); ?>" 
                     class="w-full h-64 sm:h-96 object-cover rounded-xl shadow-lg border-4 border-gray-100">
            </div>

            <!-- GRID DETAIL & BOOKING -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <!-- KOLOM KIRI (Detail Venue & Courts) -->
                <div class="lg:col-span-2 space-y-10">
                    
                    <!-- SECTION 1: DETAIL VENUE -->
                    <section class="p-6 bg-gray-50 rounded-xl border border-gray-200">
                        <h2 class="text-2xl font-bold text-[#926699] mb-4 border-b pb-2">Informasi Dasar Venue</h2>
                        
                        <div class="grid grid-cols-2 gap-4 text-gray-700">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Alamat</p>
                                <p class="font-semibold"><?php echo html_escape($venue['address']); ?></p>
                                <a href="<?php echo html_escape($venue['maps_url']); ?>" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm flex items-center mt-1">
                                    <i class="fas fa-map-marked-alt mr-2"></i> Lihat di Google Maps
                                </a>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Jam Operasional</p>
                                <p class="font-semibold text-lg"><?php echo html_escape($venue['opening_time']); ?> - <?php echo html_escape($venue['closing_time']); ?></p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-500 mb-1">Deskripsi Venue</p>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?php echo html_escape($venue['description']); ?></p>
                        </div>
                    </section>

                    <!-- SECTION 2: DAFTAR COURT / LAPANGAN & HARGA -->
                    <section>
                        <h2 class="text-2xl font-bold text-[#926699] mb-4">Daftar Lapangan Tersedia</h2>
                        
                        <div class="space-y-4">
                            <?php if (!empty($courts)): ?>
                                <?php foreach ($courts as $index => $court): ?>
                                    <div class="flex flex-col sm:flex-row bg-gray-100 p-4 rounded-xl shadow-md border-l-4 border-[#B9CF32] items-center space-x-4">
                                        
                                        <!-- Foto Lapangan -->
                                        <?php 
                                        $court_img_src = base_url($court['profile_photo']);
                                        if (empty($court['profile_photo']) || !file_exists($court['profile_photo'])) {
                                            $court_img_src = "https://placehold.co/100x100/B9CF32/ffffff?text=COURT";
                                        }
                                        ?>
                                        <img src="<?php echo $court_img_src; ?>" alt="Court Photo" class="w-16 h-16 object-cover rounded-lg flex-shrink-0 mb-3 sm:mb-0">
                                        
                                        <!-- Detail Lapangan -->
                                        <div class="flex-grow">
                                            <h3 class="text-lg font-bold text-gray-800">
                                                Lapangan #<?php echo $index + 1; ?> (<?php echo html_escape($court['sport_name']); ?>)
                                            </h3>
                                            <p class="text-sm text-gray-600"><?php echo html_escape($court['description']); ?></p>
                                        </div>
                                        
                                        <!-- Harga -->
                                        <div class="flex-shrink-0 text-right mt-2 sm:mt-0">
                                            <p class="text-sm text-gray-500">Harga per Jam</p>
                                            <p class="text-xl font-extrabold text-red-600">
                                                Rp. <?php echo number_format($court['price_per_hour'], 0, ',', '.'); ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-600 p-4 bg-yellow-100 rounded-lg">Maaf, belum ada lapangan yang terdaftar di Venue ini.</p>
                            <?php endif; ?>
                        </div>
                    </section>
                    
                    <!-- SECTION 3: GALERI FOTO GOR -->
                    <section>
                        <h2 class="text-2xl font-bold text-[#926699] mb-4">Galeri Foto</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php foreach ($gallery_photos as $photo): ?>
                                <img src="<?php echo html_escape($photo['url']); ?>" 
                                     alt="Galeri Foto" 
                                     class="w-full h-40 object-cover rounded-lg shadow-md hover:scale-[1.05] transition duration-300 cursor-pointer">
                            <?php endforeach; ?>
                        </div>
                    </section>

                </div>

                <!-- KOLOM KANAN (Section Buat Pesanan) -->
                <div class="lg:col-span-1">
                    <section class="sticky top-20 p-6 bg-[#EBE1D8] rounded-xl shadow-xl border-4 border-[#B9CF32]">
                        <h2 class="text-2xl font-bold text-[#7d5583] mb-4">Buat Pesanan & Cek Slot</h2>
                        <p class="text-sm text-gray-600 mb-6">Pilih lapangan, tanggal, dan jam untuk melihat ketersediaan slot.</p>

                        <form action="<?= site_url('App/create_order') ?>" method="POST" class="space-y-4">
                            <!-- Input Lapangan -->
                            <div>
                                <label for="court_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Lapangan</label>
                                <select id="court_id" name="court_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#926699] focus:border-[#926699] bg-white" required>
                                    <option value="">-- Pilih Lapangan --</option>
                                    <?php if (!empty($courts)): ?>
                                        <?php foreach ($courts as $court): ?>
                                            <option value="<?php echo $court['id_court']; ?>">
                                                #<?php echo $court['id_court']; ?> - <?php echo html_escape($court['sport_name']); ?> (Rp. <?php echo number_format($court['price_per_hour'], 0); ?>/Jam)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Input Tanggal -->
                            <div>
                                <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Booking</label>
                                <input type="date" id="booking_date" name="booking_date" 
                                       min="<?php echo date('Y-m-d'); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#926699] focus:border-[#926699]" required>
                            </div>

                            <!-- Input Jam Mulai & Durasi (Simulasi Slot) -->
                            <div class="flex space-x-4">
                                <div class="w-1/2">
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                                    <input type="time" id="start_time" name="start_time" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#926699] focus:border-[#926699]" required>
                                </div>
                                <div class="w-1/2">
                                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Durasi (Jam)</label>
                                    <select id="duration" name="duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#926699] focus:border-[#926699] bg-white" required>
                                        <option value="1">1 Jam</option>
                                        <option value="2">2 Jam</option>
                                        <option value="3">3 Jam</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Tombol Cek Ketersediaan -->
                            <button type="submit" class="w-full py-3 mt-4 text-lg font-semibold text-white bg-[#926699] rounded-xl shadow-lg hover:bg-[#7d5583] transition duration-150">
                                Cek Slot & Pesan Sekarang
                            </button>
                        </form>
                        
                        <p class="text-center text-xs text-gray-500 mt-4">Anda akan diarahkan ke halaman konfirmasi setelah cek slot.</p>
                    </section>
                </div>
                
            </div>
            <!-- END GRID -->

        </div>
    </div>
</div>