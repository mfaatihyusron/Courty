<main>
    <!--
    PERBAIKAN 1: HERO SECTION - MEMPERTAHANKAN WARNA BACKGROUND HERO
    - Tetap menggunakan bg-soft pada hero untuk kurva di bawahnya.
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

            <div class="mt-12 max-w-4xl mx-auto bg-white p-2 rounded-full shadow-2xl relative z-20 flex items-center group transition duration-300 hover:shadow-xl">
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
    </section>
        
    <!-- PERUBAHAN KRITIS: HAPUS bg-soft PADA SECTION UTAMA INI -->
    <!-- Sekarang background utama dari section ini adalah PUTIH (default body/div) -->
    <section class="pb-20"> 
        
        <!-- Bagian Pilih Kategori Olahraga -->
        <!-- Penyesuaian padding atas dari 10 menjadi 16 untuk spacing yang lebih lega dari kurva Hero -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16"> 
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-8" >Pilih Kategori Olahraga</h2>
            <div class="py-4" >
                <div class="flex space-x-6 overflow-x-auto pb-2 scrollbar-hide justify-center" style="overflow: visible;">
                    
                    <?php 
                    // Definisikan ikon dan nama kategori dalam array agar lebih rapi dan mudah diulang
                    // (Menggunakan Emojis sesuai file sebelumnya)
                    $categories = [
                        ['name' => 'Futsal/Sepakbola', 'url' => 'futsal/sepakbola', 'icon' => '⚽'],
                        ['name' => 'Badminton', 'url' => 'badminton', 'icon' => '🏸'],
                        ['name' => 'Basket', 'url' => 'basket', 'icon' => '🏀'],
                        ['name' => 'Voli', 'url' => 'voli', 'icon' => '🏐'],
                        ['name' => 'Tenis', 'url' => 'tenis', 'icon' => '🎾'],
                        ['name' => 'Renang', 'url' => 'renang', 'icon' => '🏊'],
                    ];
                    ?>

                    <?php foreach ($categories as $category): ?>
                        <!-- LINK CONTAINER -->
                        <a href="<?= site_url('App/view_sport_category/' . $category['url']) ?>" 
                           class="flex-shrink-0 flex flex-col items-center group w-24 sm:w-28 text-center">
                            
                            <!-- Icon Container (Lingkaran) - PERUBAHAN KRITIS DI SINI -->
                            <div class="p-4 sm:p-5 rounded-full bg-white shadow-lg border border-gray-100 
                                        group-hover:bg-[#347038] group-hover:border-transparent 
                                        hover:shadow-xl transition duration-300 transform group-hover:scale-105">
                                <span class="text-3xl sm:text-4xl leading-none group-hover:text-white transition duration-300">
                                    <?php echo $category['icon']; ?>
                                </span>
                            </div>
                            
                            <!-- Nama Kategori - Teks tetap berubah warna #347038 (Hijau Gelap) -->
                            <span class="mt-3 text-xs sm:text-sm font-medium text-gray-700 group-hover:text-[#347038]">
                                <?php echo $category['name']; ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                    
                </div>
            </div>
        </div>


        <!-- How It Works (Alur Kerja Reservasi Courty) - Background Putih -->
        <!-- Penyesuaian padding atas dari 10 menjadi 16 untuk spacing yang lebih lega -->
        <div class="pt-16 pb-10"> 
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-10">Alur Kerja Reservasi Courty</h2>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-10">
                    
                    <!-- Step 1: Cari & Request -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-t-main transition duration-300 hover:shadow-xl">
                        <div class="w-14 h-14 mx-auto mb-4 bg-main text-white rounded-full flex items-center justify-center text-3xl font-bold transform group-hover:scale-105 transition">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Cari & Kirim Permintaan</h3>
                        <p class="mt-3 text-gray-600 text-sm">Pilih lapangan, kirim permintaan. Pesanan Anda akan berstatus Pending menunggu persetujuan Mitra.</p>
                    </div>

                    <!-- Step 2: Konfirmasi Mitra -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-t-action transition duration-300 hover:shadow-xl">
                        <div class="w-14 h-14 mx-auto mb-4 bg-action text-white rounded-full flex items-center justify-center text-3xl font-bold transform group-hover:scale-105 transition">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Konfirmasi Cepat oleh Mitra</h3>
                        <p class="mt-3 text-gray-600 text-sm">Mitra GOR menyetujui ketersediaan. Anda mendapat notifikasi Confirmed (Siap Bayar).</p>
                    </div>

                    <!-- Step 3: Bayar & Main -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-t-main transition duration-300 hover:shadow-xl">
                        <div class="w-14 h-14 mx-auto mb-4 bg-main text-white rounded-full flex items-center justify-center text-3xl font-bold transform group-hover:scale-105 transition">
                            <i class="fas fa-basketball-ball"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Bayar & Selesai</h3>
                        <p class="mt-3 text-gray-600 text-sm">Selesaikan pembayaran. Reservasi Anda resmi Completed dan terjamin.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- REKOMENDASI LAPANGAN -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- PERUBAHAN JUDUL: Hapus garis bawah (border-b-4 border-main) dan ubah warna teks menjadi hitam (text-gray-900) -->
        <h2 class="text-3xl font-bold text-gray-900 mb-8 inline-block pb-1">
            Rekomendasi Lapangan
        </h2>

        <!-- Penempatan Elemen: Tambah sedikit padding vertikal dan pastikan flex box rapi -->
        <div class="flex space-x-6 overflow-x-auto py-4 scrollbar-hide">
            <?php if (!empty($featured_venues)): ?>
                <?php foreach ($featured_venues as $venue): 
                    // Pastikan id_venue tersedia
                    $id_venue = isset($venue['id_venue']) ? $venue['id_venue'] : 0; 

                    // Image fallback logic
                    $img_src = base_url($venue['link_profile_img']);
                    if (empty($venue['link_profile_img']) || $venue['link_profile_img'] == 'placeholder.jpg' || (file_exists($venue['link_profile_img']) === false)) {
                        $img_src = "https://placehold.co/600x400/926699/FFFFFF?text=" . urlencode($venue['venue_name']);
                    }
                ?>
                    <!-- LINK KRITIS: Memanggil App/detail_venue dengan ID yang benar -->
                    <a href="<?= site_url('App/detail_venue/' . $id_venue) ?>" 
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