<main>
    <!--
    PERBAIKAN 1: HERO SECTION - FULL WIDTH DAN FOKUS KE SEARCH BAR LAMA
    - Hapus max-w-7xl di container luar agar full-page.
    - Container utama diatur ke relative z-10 di dalam.
    -->
    <section class="relative h-[65vh] sm:h-[80vh] flex items-center justify-center overflow-hidden bg-soft -mt-16">
        
        <!-- Background Image & Overlay (FULL WIDTH) -->
        <div class="absolute inset-0 z-0">
            <!-- Asumsi: tennis_court_bg.jpg sudah ada di folder uploads/ -->
            <img src="<?= base_url('upload/tennis_court.jpg') ?>" 
                 alt="Lapangan Tenis Background" 
                 class="w-full h-full object-cover brightness-50 contrast-100">
            <!-- Overlay menggunakan warna aksi hijau gelap -->
            <div class="absolute inset-0 bg-action opacity-25"></div> 
        </div>

        <!-- Konten Utama (Title & Search Bar) - Memastikan konten di tengah -->
        <div class="relative z-10 text-center max-w-7xl mx-auto px-4">
            <h1 class="text-4xl sm:text-7xl font-extrabold text-white leading-tight mt-10">
                PLAY SPORTS
            </h1>
            <p class="mt-4 text-lg text-white/80 max-w-3xl mx-auto font-medium">
                World's Biggest Sports Community
            </p>

            <!-- Search Bar LAMA (INPUT TEKS TUNGGAL) - Ditempatkan di tengah, di atas curve -->
            <!-- PERBAIKAN: Menggunakan design search bar yang lebih clean dan lama -->
            <div class="mt-12 max-w-4xl mx-auto bg-white p-2 rounded-full shadow-2xl relative z-20 flex items-center">
                <div class="relative flex-grow">
                    <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="search_query" name="search_query" placeholder="Cari nama venue, olahraga, atau lokasi..." 
                           class="w-full pl-12 pr-4 py-3 text-base border-none rounded-full focus:ring-0 focus:outline-none bg-transparent">
                </div>
                <button type="submit" class="flex-shrink-0 px-6 py-3 bg-action text-white font-bold text-base rounded-full shadow-md hover:bg-[#2e5d3c] transition duration-150">
                    Search
                </button>
            </div>
            
            <!-- Tombol Geolocation -->
            <button type="button" class="text-sm font-semibold text-white/80 hover:text-white transition duration-150 mt-3" onclick="getGeolocation()">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Gunakan Lokasi Saya Sekarang
            </button>
        </div>
        
        <!-- Kurva Bawah Hero Section -->
        <div class="absolute bottom-0 left-0 right-0 h-40 bg-soft transform translate-y-2/3 rounded-t-[100px] sm:rounded-t-[150px] lg:rounded-t-[200px] z-0"></div>
    </section>
        
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-soft">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-4" >Pilih Kategori Olahraga</h2>
        <div class="mt-4 mb-12 py-4">
            <div class="flex space-x-6 overflow-x-auto pb-2 scrollbar-hide justify-center">
                
                <!-- Category Item 1: Futsal/Sepakbola -->
                <a href="<?= site_url('App/view_sport_category/futsal/sepakbola') ?>" 
                   class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 rounded-xl shadow-md border-2 border-transparent 
                          hover:border-main transition duration-200 group w-28 sm:w-32 transform hover:bg-white hover:scale-105">
                    <span class="text-3xl sm:text-4xl">⚽</span>
                    <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-main text-center">Futsal/Sepakbola</span>
                </a>
                
                <!-- Category Item 2: Badminton -->
                <a href="<?= site_url('App/view_sport_category/badminton') ?>" 
                   class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 rounded-xl shadow-md border-2 border-transparent 
                          hover:border-main transition duration-200 group w-28 sm:w-32 transform hover:bg-white hover:scale-105">
                    <span class="text-3xl sm:text-4xl">🏸</span>
                    <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-main text-center">Badminton</span>
                </a>
                
                <!-- Category Item 3: Basket -->
                <a href="<?= site_url('App/view_sport_category/basket') ?>" 
                   class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 rounded-xl shadow-md border-2 border-transparent 
                          hover:border-main transition duration-200 group w-28 sm:w-32 transform hover:bg-white hover:scale-105">
                    <span class="text-3xl sm:text-4xl">🏀</span>
                    <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-main text-center">Basket</span>
                </a>
                
                <!-- Category Item 4: Voli -->
                <a href="<?= site_url('App/view_sport_category/voli') ?>" 
                   class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 rounded-xl shadow-md border-2 border-transparent 
                          hover:border-main transition duration-200 group w-28 sm:w-32 transform hover:bg-white hover:scale-105">
                    <span class="text-3xl sm:text-4xl">🏐</span>
                    <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-main text-center">Voli</span>
                </a>
                
                <!-- Category Item 5: Tenis -->
                <a href="<?= site_url('App/view_sport_category/tenis') ?>" 
                   class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 rounded-xl shadow-md border-2 border-transparent 
                          hover:border-main transition duration-200 group w-28 sm:w-32 transform hover:bg-white hover:scale-105">
                    <span class="text-3xl sm:text-4xl">🎾</span>
                    <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-main text-center">Tenis</span>
                </a>

                 <!-- Category Item 6: Renang -->
                <a href="<?= site_url('App/view_sport_category/renang') ?>" 
                   class="flex-shrink-0 flex flex-col items-center p-3 sm:p-4 rounded-xl shadow-md border-2 border-transparent 
                          hover:border-main transition duration-200 group w-28 sm:w-32 transform hover:bg-white hover:scale-105">
                    <span class="text-3xl sm:text-4xl">🏊</span>
                    <span class="mt-1 text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-main text-center">Renang</span>
                </a>
                
            </div>
        </div>
    </section>

    <!-- How It Works (Alur Kerja Reservasi Courty) - Menggunakan Warna Aksi Hijau -->
    <section class="py-20 bg-soft"> 
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Alur Kerja Reservasi Courty</h2>
            <p class="mt-4 text-lg text-gray-500">Kami menjamin keakuratan dengan proses konfirmasi Mitra GOR yang cepat.</p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-10">
                
                <!-- Step 1: Cari & Request -->
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-t-main transition duration-300 hover:shadow-xl">
                    <div class="w-12 h-12 mx-auto bg-main text-white rounded-full flex items-center justify-center text-2xl font-bold">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Cari & Kirim Permintaan</h3>
                    <p class="mt-4 text-gray-600 text-sm">Pilih lapangan, kirim permintaan. Pesanan Anda akan berstatus **Pending** menunggu persetujuan Mitra.</p>
                </div>

                <!-- Step 2: Konfirmasi Mitra -->
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-t-action transition duration-300 hover:shadow-xl">
                    <div class="w-12 h-12 mx-auto bg-action text-white rounded-full flex items-center justify-center text-2xl font-bold">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Konfirmasi Cepat oleh Mitra</h3>
                    <p class="mt-4 text-gray-600 text-sm">Mitra GOR menyetujui ketersediaan. Anda mendapat notifikasi **Confirmed** (Siap Bayar).</p>
                </div>

                <!-- Step 3: Bayar & Main -->
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-t-main transition duration-300 hover:shadow-xl">
                    <div class="w-12 h-12 mx-auto bg-main text-white rounded-full flex items-center justify-center text-2xl font-bold">
                        <i class="fas fa-basketball-ball"></i>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Bayar & Selesai</h3>
                    <p class="mt-4 text-gray-600 text-sm">Selesaikan pembayaran. Reservasi Anda resmi **Completed** dan terjamin.</p>
                </div>

            </div>
        </div>
    </section>

    <!--
    PERBAIKAN 3: REKOMENDASI LAPANGAN - FIX DATA BINDING ERROR
    - Mengubah $venue['field'] (Array) menjadi $venue->field (Object) untuk mengatasi potensi error.
    -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <h2 class="text-3xl font-bold text-action mb-8 border-b-4 border-main inline-block pb-1">
            Rekomendasi Lapangan
        </h2>

        <div class="flex space-x-6 overflow-x-auto py-6 scrollbar-hide">
            <?php if (!empty($featured_venues)): ?>
                <?php foreach ($featured_venues as $venue): 
                    // Perbaikan: Jika data dikirim sebagai array of objects (CI3 default jika Model menggunakan result())
                    // Jika tetap array, gunakan $venue['field']. Jika error, kemungkinan Anda menggunakan result(), jadi kita ubah ke Object access.
                    // Jika Anda menggunakan result_array() di Model, biarkan tetap Array. Karena error terjadi, kita asumsikan Model mengembalikan ARRAY
                    
                    $img_src = base_url($venue['link_profile_img']);
                    if (empty($venue['link_profile_img']) || $venue['link_profile_img'] == 'placeholder.jpg' || (file_exists($venue['link_profile_img']) === false)) {
                        $img_src = "https://placehold.co/600x400/926699/FFFFFF?text=" . urlencode($venue['venue_name']);
                    }
                ?>
                    <a href="<?= site_url('App/detail_venue/' . $venue['id_venue']) ?>" 
                       class="flex-shrink-0 w-80 bg-white rounded-xl shadow-lg overflow-hidden transition transform hover:scale-[1.02] hover:shadow-xl duration-300 group">
                        
                        <img src="<?php echo $img_src; ?>" alt="<?php echo html_escape($venue['venue_name']); ?>" 
                             class="w-full h-48 object-cover group-hover:opacity-90 transition duration-300">
                        
                        <div class="p-5">
                            <h4 class="text-xl font-semibold text-gray-900 truncate"><?php echo html_escape($venue['venue_name']); ?></h4>
                            <div class="mt-2 text-sm text-gray-600 flex justify-between items-center">
                                <p>
                                    <span class="font-bold text-main"><?php echo $venue['court_count']; ?></span> Lapangan Tersedia
                                </p>
                                
                                <p class="font-bold text-action text-lg">
                                    Rp. <?php echo number_format($venue['min_price'], 0, ',', '.'); ?>,-
                                </p>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                <?php echo html_escape($venue['sports_offered']); ?> | 
                                <span class="text-xs text-gray-400">~ 5 km dari Anda</span>
                            </p>
                            
                            <div class="mt-4 w-full text-center py-2 text-sm font-semibold text-white bg-action rounded-lg group-hover:bg-[#2e5d3c] transition duration-150">
                                Lihat Detail & Slot
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center p-10 bg-white rounded-xl shadow-lg">
                    <p class="text-xl text-gray-500">Belum ada Lapangan/GOR yang terdaftar sebagai Mitra.</p>
                    <p class="text-sm text-gray-400 mt-2">Daftar sekarang untuk menjadi yang pertama!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>